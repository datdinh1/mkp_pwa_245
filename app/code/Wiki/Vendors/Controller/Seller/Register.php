<?php
/**
 *
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\Vendors\Controller\Seller;

use Magento\Framework\App\Action\Action;
use \Wiki\Vendors\Model\Session as VendorSession;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Action\Context;

class Register extends Action
{
    /**
     * @var \Magento\Framework\Controller\Result\ForwardFactory
     */
    protected $resultForwardFactory;

    /** @var DataObjectHelper */
    protected $dataObjectHelper;
    
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;
    
    /**
     * @var \Wiki\Vendors\Model\Session
     */
    protected $_vendorSession;
    
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;
    
    /**
     * @var \Wiki\Vendors\Helper\Data
     */
    protected $_vendorHelper;
    
    /**
     * @param Context $context
     * @param Session $customerSession
     * @param PageFactory $resultPageFactory
     * @param CustomerRepositoryInterface $customerRepository
     * @param DataObjectHelper $dataObjectHelper
     */
    public function __construct(
        Context $context,
        VendorSession $vendorSession,
        PageFactory $resultPageFactory,
        CustomerRepositoryInterface $customerRepository,
        \Magento\Framework\Registry $coreRegistry,
        \Wiki\Vendors\Helper\Data $vendorHelper,
        DataObjectHelper $dataObjectHelper
    ) {
        $this->_vendorSession = $vendorSession;
        $this->resultPageFactory = $resultPageFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->_coreRegistry = $coreRegistry;
        $this->_vendorHelper = $vendorHelper;
        
        parent::__construct($context);
    }

    /**
     * Renders CMS Home page
     *
     * @param string|null $coreRoute
     * @return \Magento\Framework\Controller\Result\Forward
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function execute($coreRoute = null)
    {

        if (!$this->_vendorHelper->moduleEnabled()) {
            return $this->_forward('no-route');
        }

	if (!$this->_vendorHelper->isEnableVendorRegister()) {
            return $this->_forward('no-route');
        }

        if ($this->_vendorSession->isLoggedIn() && $this->_vendorSession->getVendor()->getId()) {
            $redirectUrl = $this->_vendorHelper->getUrl('dashboard');
            return $this->_redirect($redirectUrl);
        }

        /** @var \Magento\Framework\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $this->_coreRegistry->register('form_data', $this->_vendorSession->getFormData(true));

        $resultPage->getConfig()->getTitle()->set(__('Register a Seller Account'));
        $resultPage->getLayout()->getBlock('messages')->setEscapeMessageFlag(true);
        return $resultPage;
    }
}
