<?php

namespace Wiki\Vendors\Api\Data;

interface OrdersSellerInterface
{
    const ITEMS       = 'items';
    const TOTAL_COUNT  = 'total_count';

    /**
     * Get Items
     *
     * @return  \Magento\Sales\Api\Data\OrderInterface[]
     */
    public function getItems();

    /**
     * Set Items
     *
     * @param  \Magento\Sales\Api\Data\OrderInterface[] $items
     *
     * @return $this
     */
    public function setItems($items);

    /**
     * Get total count
     *
     * @return int
     */
    public function getTotalCount();

    /**
     * Set total count
     *
     * @param int $count
     *
     * @return $this
     */
    public function setTotalCount($count);
}
