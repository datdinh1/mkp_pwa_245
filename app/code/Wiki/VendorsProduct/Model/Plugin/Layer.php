<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\VendorsProduct\Model\Plugin;

class Layer
{
    /**
     * Vendor helper
     * @var \Wiki\Vendors\Helper\Data
     */
    protected $vendorHelper;
    
    
    /**
     * Vendor Product helper
     * @var \Wiki\VendorsProduct\Helper\Data
     */
    protected $productHelper;
    
    /**
     * @param \Wiki\VendorsProduct\Helper\Data $helper
     */
    public function __construct(
        \Wiki\Vendors\Helper\Data $helper,
        \Wiki\VendorsProduct\Helper\Data $productHelper
    ) {
        $this->vendorHelper = $helper;
        $this->productHelper = $productHelper;
        return $this;
    }
    
    /**
     * Before prepare product collection handler
     *
     * @param \Magento\Catalog\Model\Layer $subject
     * @param \Magento\Catalog\Model\ResourceModel\Collection\AbstractCollection $collection
     *
     * @return void
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function beforePrepareProductCollection(
        \Magento\Catalog\Model\Layer $subject,
        \Magento\Catalog\Model\ResourceModel\Collection\AbstractCollection $collection
    ) {
        if (!$this->vendorHelper->moduleEnabled()) {
            return;
        }
        
        $notActiveVendorIds = $this->vendorHelper->getNotActiveVendorIds();
        if ($collection->isEnabledFlat()) {
            $collection->getSelect()->where('e.approval IN (?)', $this->productHelper->getAllowedApprovalStatus());
            if (sizeof($notActiveVendorIds)) {
                $collection->getSelect()->where('e.vendor_id NOT IN('.implode(",", $notActiveVendorIds).')');
            }
        } else {
            $collection->addAttributeToFilter('approval', ['in' => $this->productHelper->getAllowedApprovalStatus()]);
            if (sizeof($notActiveVendorIds)) {
                $collection->addAttributeToFilter('vendor_id', ['nin' => $this->vendorHelper->getNotActiveVendorIds()]);
            }
        }
    }
}
