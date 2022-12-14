<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\VendorsProduct\Model\Product\CopyConstructor;

class Vendor implements \Magento\Catalog\Model\Product\CopyConstructorInterface
{
    /**
     * Vendor Product helper
     * @var \Wiki\VendorsProduct\Helper\Data
     */
    protected $helper;
    
    /**
     * @param \Wiki\VendorsProduct\Helper\Data $helper
     */
    public function __construct(\Wiki\VendorsProduct\Helper\Data $helper)
    {
        $this->helper = $helper;
        return $this;
    }
    /**
     * Build product links
     *
     * @param \Magento\Catalog\Model\Product $product
     * @param \Magento\Catalog\Model\Product $duplicate
     * @return void
     */
    public function build(\Magento\Catalog\Model\Product $product, \Magento\Catalog\Model\Product $duplicate)
    {
        $duplicate->setVendorId($product->getVendorId());
        if ($this->helper->isNewProductsApproval()) {
            $duplicate->setApproval(\Wiki\VendorsProduct\Model\Source\Approval::STATUS_NOT_SUBMITED);
        } else {
            $duplicate->setApproval(\Wiki\VendorsProduct\Model\Source\Approval::STATUS_APPROVED);
        }
    }
}
