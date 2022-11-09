<?php

namespace Wiki\VendorsSubaccount\Observer;

use Magento\Framework\App\ObjectManager;
use Magento\Framework\Event\ObserverInterface;
use Wiki\VendorsSubaccount\Helper\Data as Helper;

class SaveUserPredispatch implements ObserverInterface
{
    /**
     * @var \Wiki\Vendors\Model\Session
     */
    protected $_vendorSession;

    /**
     * @var \Magento\Framework\App\Response\RedirectInterface
     */
    protected $_redirect;

    /**
     * @var \Magento\Framework\Message\ManagerInterface
     */
    protected $messageManager;


    /**
     * @var \Magento\Framework\App\RequestInterface
     */
    protected $request;

    /**
     * CouponPredispatch constructor.
     * @param \Wiki\Vendors\Model\Session $vendorSession
     * @param \Magento\Framework\App\Response\RedirectInterface $redirect
     * @param \Magento\Framework\Message\ManagerInterface $messageManager
     * @param \Magento\Framework\App\RequestInterface $request
     */
    public function __construct(
        \Wiki\Vendors\Model\Session $vendorSession,
        \Magento\Framework\App\Response\RedirectInterface $redirect,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Magento\Framework\App\RequestInterface $request
    ) {
        $this->_vendorSession = $vendorSession;
        $this->_redirect = $redirect;
        $this->messageManager = $messageManager;
        $this->request = $request;
    }

    /**
     *
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return self
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        if(!class_exists('Wiki\VendorsGroup\Helper\Data')) return;
        if($this->request->getParam('user_id')) return;

        $vendorGroupId = $this->_vendorSession->getVendor()->getGroupId();
        /** @var \Wiki\VendorsGroup\Helper\Data $groupHelper */
        $groupHelper = ObjectManager::getInstance()->get('Wiki\VendorsGroup\Helper\Data');
        $maxUser = $groupHelper->getConfig(Helper::XML_PATH_VENDOR_SUBACCOUNT_LIMITATION, $vendorGroupId);
        if(!$maxUser) return;

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        /** @var \Magento\Framework\App\ResourceConnection $resource */
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();

        $select = $connection->select();
        $select->from(
            $resource->getTableName('ves_vendor_user'),
            ['total_user' => 'count(customer_id)']
        )->where(
            'vendor_id = :vendor_id'
        )->where(
            'is_super_user = :is_super_user'
        );
        $bind = ['vendor_id' => $this->_vendorSession->getVendor()->getId(), 'is_super_user' => 0];
        $subUserCount = $connection->fetchOne($select, $bind);

        if (
            $subUserCount >= $maxUser
        ) {
            $controllerAction = $observer->getControllerAction();
            $this->messageManager->addError(__("Your membership plan is allowed to add %1 sub accounts only.", $maxUser));
            $this->_redirect->redirect($controllerAction->getResponse(), 'subaccount/user');
            $controllerAction->getActionFlag()->set('', \Magento\Framework\App\ActionInterface::FLAG_NO_DISPATCH, true);
            return;
        }
    }
}
