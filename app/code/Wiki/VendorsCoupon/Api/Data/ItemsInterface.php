<?php

namespace Wiki\VendorsCoupon\Api\Data;

interface ItemsInterface
{
    /**
     * Constants for keys of data array.
     */
   
    const ITEMS               = 'items';
    const TOTAL_COUNT         = 'total_count';
    const CATEGORY            = 'category';
     /**
     * Get Category.
     * @return \Magento\Catalog\Api\Data\CategoryInterface|null
     */
    public function getCategory();

    /**
     * Set Category.
     * @param \Magento\Catalog\Api\Data\CategoryInterface|null $category
     * @return $this
     */
    public function setCategory($category);

    /**
     * Get Items.
     * @return \Wiki\VendorsCoupon\Api\Data\CouponInterface[]|null
     */
    public function getItems();

    /**
     * Set Items.
     * @param \Wiki\VendorsCoupon\Api\Data\CouponInterface[]|null $items
     * @return $this
     */
    public function setItems($items);

    /**
     * Get Total Count.
     * @return int
     */
    public function getTotalCount();

    /**
     * Set Total Count.
     * @param int $totalCount
     * @return $this
     */
    public function setTotalCount($totalCount);
}
