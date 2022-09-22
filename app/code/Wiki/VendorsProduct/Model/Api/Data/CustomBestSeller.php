<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Wiki\VendorsProduct\Model\Api\Data;

/**
 * Softprodigy Dailydeal date model
 */
class CustomBestSeller extends \Magento\Framework\Api\AbstractExtensibleObject implements \Wiki\VendorsProduct\Api\Data\CustomBestSellerInterface
{

    /**
     * Get name
     *
     * @return \Magento\Catalog\Api\Data\CategoryInterface
     */
    public function getCategory()
    {
        return $this->_get(self::CATEGORY);
    }

    /**
     * Set Name 
     *
     * @param \Magento\Catalog\Api\Data\CategoryInterface $searchCriteria
     * @return $this
     */
    public function setCategory($searchCriteria)
    {
        return $this->setData(self::CATEGORY, $searchCriteria);
    }

  
    /**
     *
     * @return \Magento\Catalog\Api\Data\ProductInterface[]
     */
    public function getListProduct()
    {
        return $this->_get(self::LIST_PRODUCT);
    }

    /**

     *
     * @param \Magento\Catalog\Api\Data\ProductInterface[] $product
     * @return $this
     */
    public function setListProduct($product)
    {
        return $this->setData(self::LIST_PRODUCT, $product);
    }
}
