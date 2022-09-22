<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\Vendors\Model\Config\Backend;

/**
 * System config file field backend model
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @SuppressWarnings(PHPMD.ExcessiveParameterList)
 */
class StoreDescription extends \Wiki\VendorsConfig\Model\Config
{
    /**
     * @var \Wiki\Vendors\Helper\Data
     */
    protected $_vendorHelper;
    
    /**
     * Constructor
     *
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Wiki\VendorsConfig\Model\ResourceModel\Config $resource
     * @param \Wiki\VendorsConfig\Model\ResourceModel\Config\Collection $resourceCollection
     * @param \Wiki\VendorsConfig\Helper\Data $configHelper
     * @param \Wiki\Vendors\Helper\Data $vendorHelper
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Wiki\VendorsConfig\Model\ResourceModel\Config $resource = null,
        \Wiki\VendorsConfig\Model\ResourceModel\Config\Collection $resourceCollection = null,
        \Wiki\VendorsConfig\Helper\Data $configHelper,
        \Wiki\Vendors\Helper\Data $vendorHelper,
        array $data = []
    ) {
        $this->_vendorHelper = $vendorHelper;
        parent::__construct($context, $registry, $resource, $resourceCollection, $configHelper, $data);
    }

    /**
     * Save uploaded file before saving config value
     *
     * @return $this
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function beforeSave()
    {
        $value = $this->getValue();
        
        $length = $this->_vendorHelper->getDescriptionMaxLength();
        if (strlen($value) > $length) {
            throw new \Magento\Framework\Exception\LocalizedException(
                __('Short Description must be less than %1 characters', $length)
            );
        }
        return $this;
    }
}
