<?php
/**
 * Copyright (c) 2017 Wiki Co ltd. All rights reserved.
 */

namespace Wiki\VendorsSubAccount\Controller\Vendors\User;

class Edit extends \Wiki\Vendors\Controller\Vendors\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    protected $_aclResource = 'Wiki_VendorsQuotation::subaccount_user';
    
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;
    
    /**
     * @var \Magento\Customer\Model\CustomerFactory
     */
    protected $customerFactory;
    
    /**
     * @param \Wiki\Vendors\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Wiki\VendorsSubAccount\Model\RoleFactory $roleFactory
     */
    public function __construct(
        \Wiki\Vendors\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Customer\Model\CustomerFactory $customerFactory
    )
    {
        $this->resultPageFactory = $resultPageFactory;
        $this->customerFactory = $customerFactory;
        parent::__construct($context);
    }

    /**
     * Index action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        try{
            $customer = $this->customerFactory->create();
            $customer->load($this->getRequest()->getParam('user_id'));
            if($userData = $this->_session->getData('user_data', true)){
                $customer->addData($userData);
            }
            $resource = $this->_objectManager->create('Wiki\VendorsSubAccount\Model\ResourceModel\User');
            $resource->loadUserData($customer);
            if(
                $customer->getId() &&
                $customer->getVendorId() != $this->_session->getVendor()->getId()
            ) {
                throw new \Magento\Framework\Exception\LocalizedException(__("The user is not available."));
            }
            if($customer->getIsSuperUser()){
                $this->messageManager->addWarning(__("You are editing the super user. You are not allowed to delete, change role or disable this user."));
            }
            $this->_coreRegistry->register('user', $customer);
            $this->_coreRegistry->register('current_user', $customer);
            
            $resultPage = $this->resultPageFactory->create();
            $this->setActiveMenu('Wiki_VendorsQuotation::subaccount_user');
            $this->_addBreadcrumb(__('Sub Account'), __('Sub Account'));
            $this->_addBreadcrumb(__('Manage Users'), __('Manage Users'), $this->getUrl('*/*/'));
            $label = $customer->getId()?__('%1', $customer->getName()):__('New User');
            $this->_addBreadcrumb($label, $label);
            $resultPage->getConfig()->getTitle()->prepend($label);
            return $resultPage;
        }catch(\Exception $e){
            $this->messageManager->addError($e->getMessage());
            return $this->resultRedirectFactory->create()->setPath('*/*');
        }
    }
}
