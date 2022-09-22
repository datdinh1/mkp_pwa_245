<?php


namespace Wiki\VendorsSales\Api\Data;

interface RequestReturnOrderInterface
{
    /**
     * Constants used as data array keys
     */
    const ORDER_ID          = 'order_id';
    const ITEMS             = 'items';
    const REASON            = 'reason';
    const PICTURE           = 'picture';
    const CONTENT           = 'content_of_seller';
    const STATUS            = 'status_of_seller';

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

    /**
     * Get Content confirm of Seller
     * @return string
     */
    public function getContentOfSeller();

    /**
     * Set Content confirm of Seller
     * @param string $content
     *
     * @return $this
     */
    public function setContentOfSeller($content);

    /**
     * Get Status confirm of Seller
     * @return string
     */
    public function getStatusOfSeller();

    /**
     * Set Status confirm of Seller
     * @param string $status
     *
     * @return $this
     */
    public function setStatusOfSeller($status);
}
