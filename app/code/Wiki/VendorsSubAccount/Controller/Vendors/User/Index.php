<?php
/**
 * Copyright (c) 2017 Wiki Co ltd. All rights reserved.
 */

namespace Wiki\VendorsSubAccount\Controller\Vendors\User;

class Index extends \Wiki\Vendors\Controller\Vendors\Action
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
     * @var \Wiki\Vendors\Model\Session
     */
    protected $vendorSession;
    
    /**
     * @param \Wiki\Vendors\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Wiki\Vendors\Model\Session $vendorSession
     */
    public function __construct(
        \Wiki\Vendors\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Wiki\Vendors\Model\Session $vendorSession
    )
    {
        $this->resultPageFactory = $resultPageFactory;
        $this->vendorSession = $vendorSession;
        parent::__construct($context);
    }

    /**
     * Index action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $this->getRequest()->setParam('vendor_id', $this->vendorSession->getVendor()->getId());
        $resultPage = $this->resultPageFactory->create();
        $this->setActiveMenu('Wiki_VendorsQuotation::subaccount_user');
        $this->_addBreadcrumb(__('Sub Account'), __('Sub Account'));
        $this->_addBreadcrumb(__('Users'), __('Manage Users'));
        $resultPage->getConfig()->getTitle()->prepend(__("Manage Users"));
        return $resultPage;
    }
}
