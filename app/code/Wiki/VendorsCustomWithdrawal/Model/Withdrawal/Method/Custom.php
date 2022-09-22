<?php

namespace Wiki\VendorsCustomWithdrawal\Model\Withdrawal\Method;

class Custom extends \Wiki\VendorsCredit\Model\Withdrawal\Method\AbstractMethod
{
    /**
     * @var \Wiki\VendorsCustomWithdrawal\Model\Method
     */
    protected $method;
    
    /**
     * Constructor
     *
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        \Wiki\VendorsCredit\Model\Withdrawal\Method\Context $context
    ) {
        parent::__construct($context);
    }
    
    /**
     * @param \Wiki\VendorsCustomWithdrawal\Model\Method $method
     * @return \Wiki\VendorsCustomWithdrawal\Model\Withdrawal\Method\Custom
     */
    public function setMethodObj(\Wiki\VendorsCustomWithdrawal\Model\Method $method){
        $this->_code = $method->getCode();
        $this->method = $method;
        return $this;
    }
    
    /**
     * @return \Wiki\VendorsCustomWithdrawal\Model\Method
     */
    public function getMethodObj(){
        return $this->method;
    }
    
    /**
     * @see \Wiki\VendorsCredit\Model\Withdrawal\Method\AbstractMethod::getBlock()
     */
    public function getBlock()
    {
        return 'Wiki\VendorsCustomWithdrawal\Block\Vendors\Withdraw\Method\Custom';
    }
    
    /**
     * (non-PHPdoc)
     * @see \Wiki\VendorsCredit\Model\Withdrawal\Method\AbstractMethod::isEnteredMethodInfo()
     */
    public function isEnteredMethodInfo($vendorId)
    {
        return true;
    }
    
    /**
     * (non-PHPdoc)
     * @see \Wiki\VendorsCredit\Model\Withdrawal\Method\AbstractMethod::getVendorAccountInfo()
     */
    public function getVendorAccountInfo($vendorId)
    {
       return [];
    }
    
    /**
     * Get Method Code
     *
     * @return string
     */
    public function getCode()
    {
        if (!$this->_code) {
            throw new \Exception(__("Method code of '%1' is not defined.", __CLASS__));
        }
        return $this->_code;
    }
    
    /**
     * Is Active
     *
     * @return bool
     */
    public function isActive()
    {
        return $this->method->getIsEnabled();
    }
    
    /**
     * Get Method Title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->method->getTitle();
    }
    
    /**
     * Get Method Description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->method->getDescription();
    }
    
    /**
     * Fee Type
     *
     * @return string
     */
    public function getFeeType()
    {
        return $this->method->getFeeType();
    }
    
    /**
     * Get Method Fee
     *
     * @return string
     */
    public function getFee($isFormated = true)
    {
        $fee = $this->method->getFee() * 1;
        if ($this->getFeeType() == self::FEE_TYPE_PERCENT) {
            return $isFormated?__('%1%', $fee):$fee;
        }
    
        return $isFormated?$this->_storeManager->getStore()->getBaseCurrency()->formatPrecision($fee, 2, [], false):$fee;
    }
    
    /**
     * Get Method Max Value
     *
     * @return string
     */
    public function getMaxValue()
    {
        return (float)$this->method->getMaxValue();
    }
    
    /**
     * Get Method Max Value
     *
     * @return string
     */
    public function getMinValue()
    {
        return (float)$this->method->getMinValue();
    }
}
