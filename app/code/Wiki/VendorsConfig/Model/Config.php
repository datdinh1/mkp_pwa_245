<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\VendorsConfig\Model;

use Magento\Framework\Exception\LocalizedException;

/**
 * @method int getCustomerId();
 * @method int getCredit();
 */
class Config extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Prefix of model events names
     * @var string
     */
    protected $_eventPrefix = 'vendor_config';
    
    /**
     * @var \Wiki\VendorsConfig\Helper\Data
     */
    protected $_configHelper;
    
    /**
     * Constructor
     *
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Wiki\VendorsConfig\Model\ResourceModel\Config $resource
     * @param \Wiki\VendorsConfig\Model\ResourceModel\Config\Collection $resourceCollection
     * @param \Wiki\VendorsConfig\Helper\Data $configHelper
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Wiki\VendorsConfig\Model\ResourceModel\Config $resource = null,
        \Wiki\VendorsConfig\Model\ResourceModel\Config\Collection $resourceCollection = null,
        \Wiki\VendorsConfig\Helper\Data $configHelper,
        array $data = []
    ) {
        $this->_configHelper = $configHelper;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }
    
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Wiki\VendorsConfig\Model\ResourceModel\Config');
    }
}
