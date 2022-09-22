<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

// @codingStandardsIgnoreFile

namespace Wiki\VendorsPage\Block\Vendors\Toplinks;

/**
 * Vendor Notifications block
 */
class HomePage extends \Wiki\Vendors\Block\Vendors\AbstractBlock
{
    /**
     * @var \Wiki\VendorsPage\Helper\Data
     */
    protected $_pageHelper;
    
    /**
     * @var \Wiki\Vendors\Model\Session
     */
    protected $_vendorSession;
    
    /**
     * 
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Wiki\Vendors\Model\UrlInterface $url
     * @param \Wiki\VendorsPage\Helper\Data $pageHelper
     * @param \Magento\Framework\Registry $registry
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Wiki\Vendors\Model\UrlInterface $url,
        \Wiki\VendorsPage\Helper\Data $pageHelper,
        \Wiki\Vendors\Model\Session $vendorSession,
        array $data = [])
    {
        $this->_vendorSession = $vendorSession;
        $this->_pageHelper = $pageHelper;
        parent::__construct($context, $url, $data);
    }
    
    /**
     * Get Vendor object
     *
     * @return \Wiki\Vendors\Model\Vendor
     */
    public function getVendor(){
        return $this->_vendorSession->getVendor();
    }
    
    /**
     * Get Homepage URL
     * 
     * @return string
     */
    public function getHomePageUrl(){
        return $this->_pageHelper->getUrl($this->getVendor(),'');
    }
    
    /**
     * Hide the button if the customer account is not approved.
     * 
     * @see \Magento\Framework\View\Element\Template::_toHtml()
     */
    protected function _toHtml(){
        if($this->getVendor()->getStatus() != \Wiki\Vendors\Model\Vendor::STATUS_APPROVED) return '';
        return parent::_toHtml();
    }
}
