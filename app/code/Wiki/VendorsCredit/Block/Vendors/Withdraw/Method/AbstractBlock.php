<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

// @codingStandardsIgnoreFile

namespace Wiki\VendorsCredit\Block\Vendors\Withdraw\Method;

/**
 * Vendor Notifications block
 */
class AbstractBlock extends \Wiki\Vendors\Block\Vendors\AbstractBlock
{
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
    
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Wiki\Vendors\Model\UrlInterface $url,
        \Wiki\Vendors\Model\Session $session,
        \Magento\Framework\Registry $coreRegistry,
        array $data = []
    ) {
        parent::__construct($context, $url, $data);
        $this->_vendorSession = $session;
        $this->_coreRegistry = $coreRegistry;
    }
    
    /**
     * Get Vendor
     *
     * @return \Wiki\Vendors\Model\Vendor
     */
    public function getVendor(){
        return $this->_vendorSession->getVendor();
        
    }
    
    /**
     * Can show edit link
     * 
     * @return boolean
     */
    public function canShowEditLink(){
        return $this->_coreRegistry->registry('step') != 'review';
    }
    
    /**
     * Get Edit URL
     * 
     * @return string
     */
    public function getEditUrl(){
        return $this->getUrl('config/index/edit/',['section' => 'withdrawal']);
    }
}
