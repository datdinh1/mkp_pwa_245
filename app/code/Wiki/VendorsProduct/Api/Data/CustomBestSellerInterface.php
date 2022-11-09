<?php

/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Wiki\VendorsProduct\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

/**
 * Customer group interface.
 * @api
 */
interface CustomBestSellerInterface
{

    const CATEGORY       = 'category';
    const LIST_PRODUCT         = 'list_product';
    /**
     * Get category
     *
     * @return \Magento\Catalog\Api\Data\CategoryInterface
     */
    public function getCategory();

    /**
     * Set name
     *
     * @param \Magento\Catalog\Api\Data\CategoryInterface $searchCriteria
     * @return $this
     */
    public function setCategory($searchCriteria);


    /**
     * Retrieve existing extension attributes object or create a new one.
     * 
     * @return  \Magento\Catalog\Api\Data\ProductInterface[] 
     */
    public function getListProduct();

    /**
     * Set an extension attributes object.
     * 
     * @param  \Magento\Catalog\Api\Data\ProductInterface[] $productInterface
     * @return $this
     */
    public function setListProduct($productInterface);
}
