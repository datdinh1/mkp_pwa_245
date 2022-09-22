<?php
namespace Wiki\VendorsChat\Api\Data;

interface DataRoomItemsInterface
{
    /**
     * Constants for keys of data array.
     */
    const ITEMS               = 'items';
    const TOTAL_COUNT         = 'total_count';

    /**
     * Get Items.
     * @return \Wiki\VendorsChat\Api\Data\InfoRoomInterface[]|null
     */
    public function getItems();

    /**
     * Set Items.
     * @param \Wiki\VendorsChat\Api\Data\InfoRoomInterface[]|null $items
     * @return $this
     */
    public function setItems($items);

    /**
     * Get Total Count.
     * @return int
     */
    public function getTotal();

    /**
     * Set Total Count.
     * @param int $totalCount
     * @return $this
     */
    public function setTotal($totalCount);
}
