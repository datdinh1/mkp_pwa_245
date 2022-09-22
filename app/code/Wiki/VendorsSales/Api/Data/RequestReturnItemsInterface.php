<?php


namespace Wiki\VendorsSales\Api\Data;

interface RequestReturnItemsInterface
{
    /**
     * Constants used as data array keys
     */
    const ORDER_ID          = 'order_id';
    const ITEMS             = 'items';
    const REASON            = 'reason';
    const PICTURE           = 'picture';

    /**
     * Get Order Id
     * @return int
     */
    public function getOrderId();

    /**
     * Set Order Id
     * @param int $id
     *
     * @return $this
     */
    public function setOrderId($id);

    /**
     * Get Items
     * @return int[]
     */
    public function getItems();

    /**
     * Set Items
     * @param int[] $items
     *
     * @return $this
     */
    public function setItems($items);

    /**
     * Get Reason
     * @return mixed
     */
    public function getReason();

    /**
     * Set Reason
     * @param string $reason
     *
     * @return $this
     */
    public function setReason($reason);

    /**
     * Get Picture
     * @return string[]
     */
    public function getPicture();

    /**
     * Set Picture
     * @param string[] $pic
     *
     * @return $this
     */
    public function setPicture($pic);
}
