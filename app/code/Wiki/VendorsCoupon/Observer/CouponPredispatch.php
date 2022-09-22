<?php

namespace Wiki\VendorsCoupon\Observer;

use Magento\Framework\App\ObjectManager;
use Magento\Framework\Event\ObserverInterface;
use Wiki\VendorsCoupon\Helper\Data as Helper;

class CouponPredispatch implements ObserverInterface
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
        $vendorGroupId = $this->_vendorSession->getVendor()->getGroupId();
        /** @var \Wiki\VendorsGroup\Helper\Data $groupHelper */
        $groupHelper = ObjectManager::getInstance()->get('Wiki\VendorsGroup\Helper\Data');

        if (
            !$groupHelper->getConfig(Helper::XML_PATH_VENDOR_COUPON, $vendorGroupId)
        ) {
            $controllerAction = $observer->getControllerAction();
            $this->messageManager->addError(__("You don't have permission to access this page."));
            $this->_redirect->redirect($controllerAction->getResponse(), 'dashboard');
            $controllerAction->getActionFlag()->set('', \Magento\Framework\App\ActionInterface::FLAG_NO_DISPATCH, true);
            return;
        }
    }
}
