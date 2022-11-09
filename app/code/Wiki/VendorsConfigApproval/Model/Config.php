<?php

namespace Wiki\VendorsConfigApproval\Model;

class Config extends \Magento\Framework\Model\AbstractModel
{
    const STATUS_PENDING    = 0;
    const STATUS_REJECTED   = 1;
    
    /**
     * Prefix of model events names
     * @var string
     */
    protected $_eventPrefix = 'vendor_config_approval';
    
    /**
     * @var \Wiki\VendorsConfig\Helper\Data
     */
    protected $_configHelper;

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Wiki\VendorsConfigApproval\Model\ResourceModel\Config');
    }
}
