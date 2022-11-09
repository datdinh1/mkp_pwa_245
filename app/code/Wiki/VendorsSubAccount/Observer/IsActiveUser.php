<?php

namespace Wiki\VendorsSubAccount\Observer;

use Magento\Framework\Event\ObserverInterface;

class IsActiveUser implements ObserverInterface
{
    /**
     * @var \Wiki\Vendors\Model\Session
     */
    protected $session;
    
    /**
     * @var \Wiki\VendorsSubAccount\Model\ResourceModel\UserFactory
     */
    protected $resourceFactory;
    
    /**
     * @var \Magento\Framework\Message\ManagerInterface
     */
    protected $messageManager;
    
    /**
     * @var \Magento\Framework\Url
     */
    protected $frontendUrl;
    
    /**
     * @param \Wiki\Vendors\Model\Session $session
     * @param \Wiki\VendorsSubAccount\Model\ResourceModel\UserFactory $resourceFactory
     * @param \Magento\Framework\Message\ManagerInterface $messageManager
     * @param \Magento\Framework\Url $frontendUrl
     */
    public function __construct(
        \Wiki\Vendors\Model\Session $session,
        \Wiki\VendorsSubAccount\Model\ResourceModel\UserFactory $resourceFactory,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Magento\Framework\Url $frontendUrl
    ) {
        $this->session = $session;
        $this->resourceFactory = $resourceFactory;
        $this->messageManager = $messageManager;
        $this->frontendUrl = $frontendUrl;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     * @codeCoverageIgnore
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
         $request = $observer->getRequet();
         $controller = $observer->getControllerAction();
        // $actionFlag = $controller->getActionFlag();
        // $user = $this->session->getCustomer();
        // $resource = $this->resourceFactory->create();
        // $userData = $resource->getUserData($user);
        // if($userData && !$userData['is_super_user'] && !$userData['is_active_user']){
        //     $this->messageManager->addError(__("Your account is temporarily disabled."));
        //     $this->session->setIsUrlNotice($actionFlag->get('', \Wiki\Vendors\App\AbstractAction::FLAG_IS_URLS_CHECKED));
        //     $controller->getResponse()->setRedirect($this->frontendUrl->getUrl('customer/account'));
        //     $actionFlag->set('', 'no-dispatch', true);
        // }
    }
}
