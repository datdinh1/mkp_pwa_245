<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\VendorsCredit\Model\Withdrawal\Method;

class Paypal extends AbstractMethod
{
    /**
     * Constructor
     *
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        \Wiki\VendorsCredit\Model\Withdrawal\Method\Context $context
    ) {
        parent::__construct($context);
        $this->_code = 'paypal';
    }
    
    /**
     * @see \Wiki\VendorsCredit\Model\Withdrawal\Method\AbstractMethod::getBlock()
     */
    public function getBlock()
    {
        return 'Wiki\VendorsCredit\Block\Vendors\Withdraw\Method\Paypal';
    }
    
    /**
     * (non-PHPdoc)
     * @see \Wiki\VendorsCredit\Model\Withdrawal\Method\AbstractMethod::isEnteredMethodInfo()
     */
    public function isEnteredMethodInfo($vendorId)
    {
        if ($vendorId instanceof \Wiki\Vendors\Model\Vendor) {
            $vendorId = $vendorId->getId();
        }
        
        return strlen($this->getPaypalEmailAccount($vendorId));
    }
    
    /**
     * Get Paypal email account
     *
     * @param unknown $vendorId
     */
    public function getPaypalEmailAccount($vendorId)
    {
        return $this->_vendorConfigHelper->getVendorConfig(
            'withdrawal/paypal/email',
            $vendorId
        );
    }
    
    /**
     * (non-PHPdoc)
     * @see \Wiki\VendorsCredit\Model\Withdrawal\Method\AbstractMethod::getVendorAccountInfo()
     */
    public function getVendorAccountInfo($vendorId)
    {
        $info = [
            ['label' => 'Paypal Email Account', 'value' => $this->getPaypalEmailAccount($vendorId)]
        ];
        
        return $info;
    }
}
