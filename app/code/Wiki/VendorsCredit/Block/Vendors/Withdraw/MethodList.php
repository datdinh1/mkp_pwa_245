<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

// @codingStandardsIgnoreFile

namespace Wiki\VendorsCredit\Block\Vendors\Withdraw;

/**
 * Vendor Notifications block
 */
class MethodList extends \Wiki\Vendors\Block\Vendors\AbstractBlock
{
    /**
     * @var \Wiki\Vendors\Model\Session
     */
    protected $_vendorSession;

    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $_objectManager;
    
    /**
     * @var \Wiki\VendorsCredit\Helper\Data
     */
    protected $helper;
    
    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Wiki\Vendors\Model\UrlInterface $url
     * @param \Wiki\Vendors\Model\Session $session
     * @param \Wiki\VendorsCredit\Helper\Data $helper
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Wiki\Vendors\Model\UrlInterface $url,
        \Wiki\Vendors\Model\Session $session,
        \Wiki\VendorsCredit\Helper\Data $helper,
        array $data = []
    ) {
        parent::__construct($context, $url, $data);
        $this->_url = $url;
        $this->_vendorSession = $session;
        $this->helper = $helper;
    }
    
    /**
     * Get withdrawal methods
     * 
     * @throws \Exception
     * @return multitype:\Magento\Framework\mixed
     */
    public function getWithdrawalMethods(){
        return $this->helper->getWithdrawalMethods();
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
     * Get Withdrawal URL
     * 
     * @param \Wiki\VendorsCredit\Model\Withdrawal\Method\AbstractMethod $method
     * @return string
     */
    public function getWithdrawalUrl(\Wiki\VendorsCredit\Model\Withdrawal\Method\AbstractMethod $method){
        return $this->getUrl('credit/withdraw/form',['method'=>$method->getCode()]);
    }
}
