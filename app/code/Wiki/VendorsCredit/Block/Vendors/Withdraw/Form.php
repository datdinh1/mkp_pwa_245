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
class Form extends \Wiki\Vendors\Block\Vendors\AbstractBlock
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
    
    /**
     * @var \Wiki\Credit\Model\CreditFactory
     */
    protected $_creditFactory;
    
    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $_objectManager;
    
    /**
     * Constructor
     * 
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     * @param \Wiki\Vendors\Model\UrlInterface $url
     * @param \Wiki\Vendors\Model\Session $session
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Wiki\Credit\Model\CreditFactory $creditAccountFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Wiki\Vendors\Model\UrlInterface $url,
        \Wiki\Vendors\Model\Session $session,
        \Magento\Framework\Registry $coreRegistry,
        \Wiki\Credit\Model\CreditFactory $creditAccountFactory,
        array $data = []
    ) {
        parent::__construct($context, $url, $data);
        $this->_vendorSession = $session;
        $this->_objectManager = $objectManager;
        $this->_coreRegistry = $coreRegistry;
        $this->_creditFactory = $creditAccountFactory;
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
     * Get credit account
     *
     * @return \Wiki\Credit\Model\Credit
     */
    public function getCreditAccount(){
        if(!$this->getData('credit_account')){
            $creditAccount = $this->_creditFactory->create();
            $creditAccount->loadByCustomerId($this->_vendorSession->getCustomer()->getId());
            $this->setData('credit_account',$creditAccount);
        }
    
        return $this->getData('credit_account');
    }
    
    /**
     * Get credit
     *
     * @return number
     */
    public function getCredit(){
        return $this->formatBaseCurrency($this->getCreditAccount()->getCredit());
    }
    
    /**
     * Get current withdrawal method
     * 
     * @return \Wiki\VendorsCredit\Model\Withdrawal\Method\AbstractMethod
     */
    public function getPaymentMethod(){
        return $this->_coreRegistry->registry('current_method');
    }
    
    /**
     * Get methdo block HTML
     * 
     * @return string
     */
    public function getMethodBlockHtml(){
        $block = $this->getLayout()
            ->createBlock($this->getPaymentMethod()
            ->getBlock())->setPaymentMethod($this->getPaymentMethod());
        return $block->toHtml();
    }
    
    /**
     * Get Back Url
     * 
     * @return string
     */
    public function getBackUrl(){
        return $this->getUrl('credit/withdraw');
    }
    
    /**
     * Get Action URL
     * 
     * @return string
     */
    public function getActionUrl(){
        return $this->getUrl(
            'credit/withdraw/formPost',
            ['method' => $this->getPaymentMethod()->getCode()]
        );
    }
    
    /**
     * Format base currency
     * 
     * @param float $amount
     * @return string
     */
    public function formatBaseCurrency($amount){
        return $this->_storeManager->getStore()->getBaseCurrency()
        ->formatPrecision($amount,2,[],false);
    }
    
    /**
     * Get Max Value
     * 
     * @return number
     */
    public function getMaxValue(){
        $this->getPaymentMethod()->getMaxValue();
    }
    
    /**
     * Get Min Value
     *
     * @return number
     */
    public function getMinValue(){
        $this->getPaymentMethod()->getMinValue();
    }
}
