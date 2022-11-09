<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\Vendors\Block\Account;

use Wiki\Vendors\App\Area\FrontNameResolver;

class Login extends \Magento\Framework\View\Element\Template
{
    /**
     * @var int
     */
    private $_username = -1;

    /**
     * @var \Wiki\Vendors\Model\Session
     */
    protected $_vendorSession;

    /**
     * @var \Wiki\Vendors\Model\Url
     */
    protected $backendUrl;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Customer\Model\Url $customerUrl
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Wiki\Vendors\Model\Session $vendorSession,
        \Wiki\Vendors\Model\Url $backendUrl,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_isScopePrivate = false;
        $this->_vendorSession = $vendorSession;
        $this->backendUrl = $backendUrl;
    }

    /**
     * @return $this
     */
    protected function _prepareLayout()
    {
        $this->pageConfig->getTitle()->set(__('Customer Login'));
        return parent::_prepareLayout();
    }

    /**
     * @return \Magento\Framework\App\Config\mixed
     */
    public function isUsedCustomVendorUrl(){
        return $this->_scopeConfig->getValue(FrontNameResolver::XML_PATH_USE_CUSTOM_VENDOR_URL);
    }
    
    /**
     * Retrieve form posting url
     *
     * @return string
     */
    public function getLoginUrl()
    {
        return $this->backendUrl->getUrl('account/login');
    }
    
    /**
     * Retrieve form posting url
     *
     * @return string
     */
    public function getPostActionUrl()
    {
        if(!$this->isUsedCustomVendorUrl()){
            return $this->getUrl('marketplace/seller/loginPost');
        }
        return $this->backendUrl->getUrl('account/login/loginPost');
    }

    /**
     * Retrieve password forgotten url
     *
     * @return string
     */
    public function getForgotPasswordUrl()
    {
        return $this->getUrl('customer/account/forgotpassword');
    }

    /**
     * Retrieve username for form field
     *
     * @return string
     */
    public function getUsername()
    {
        if (-1 === $this->_username) {
            $this->_username = $this->_vendorSession->getUsername(true);
        }
        return $this->_username;
    }

    /**
     * Check if autocomplete is disabled on storefront
     *
     * @return bool
     */
    public function isAutocompleteDisabled()
    {
        return (bool)!$this->_scopeConfig->getValue(
            \Magento\Customer\Model\Form::XML_PATH_ENABLE_AUTOCOMPLETE,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
}
