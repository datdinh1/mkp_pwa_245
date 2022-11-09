<?php


namespace Wiki\VendorsSales\Api\Data\Product;
interface ProductItemInterface
{
    /**
     * Constants used as data array keys
     */
    const ID         = 'id';
    const QTY        = 'qty';

    /**
     * Get Id
     * @return int
     */
    public function getId();

    /**
     * Set Id
     * @param int $id
     *
     * @return $this
     */
    public function setId($id);

    /**
     * Get Qty
     * @return int
     */
    public function getQty();

    /**
     * Set Qty
     * @param int $qty
     *
     * @return $this
     */
    public function setQty($qty);
}