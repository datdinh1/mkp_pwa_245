<?php
/**
 * Copyright (c) 2017 Wiki Co ltd. All rights reserved.
 */

namespace Wiki\VendorsSubAccount\Controller\Vendors\Role;

class Edit extends \Wiki\Vendors\Controller\Vendors\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    protected $_aclResource = 'Wiki_VendorsQuotation::subaccount_role';
    
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;
    
    /**
     * @var \Wiki\VendorsSubAccount\Model\RoleFactory
     */
    protected $roleFactory;
    
    
    /**
     * @param \Wiki\Vendors\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Wiki\VendorsSubAccount\Model\RoleFactory $roleFactory
     */
    public function __construct(
        \Wiki\Vendors\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Wiki\VendorsSubAccount\Model\RoleFactory $roleFactory
    )
    {
        $this->resultPageFactory = $resultPageFactory;
        $this->roleFactory = $roleFactory;
        parent::__construct($context);
    }

    /**
     * Index action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $role = $this->roleFactory->create();
        $roleId = $this->getRequest()->getParam('role_id');
        $role->load($roleId);
        if(
            $role->getId() && 
            $role->getVendorId() != $this->_session->getVendor()->getId()
        ) {
            $this->messageManager->addError(__("The role is no longer available."));
            return $this->resultRedirectFactory->create()->setPath('*/*');
        }
        $this->_coreRegistry->register('role', $role);
        $this->_coreRegistry->register('current_role', $role);
        
        $resultPage = $this->resultPageFactory->create();
        $this->setActiveMenu('Wiki_VendorsQuotation::subaccount_role');
        $this->_addBreadcrumb(__('Sub Account'), __('Sub Account'));
        $this->_addBreadcrumb(__('Manage Roles'), __('Manage Roles'), $this->getUrl('*/*/'));
        $label = $role->getId()?__('Edit Role %1', $role->getRoleName()):__('New Role');
        $this->_addBreadcrumb($label, $label);
        $resultPage->getConfig()->getTitle()->prepend($label);
        return $resultPage;
    }
}
