<?php
namespace Wiki\StoreApi\Api\Data;

/**
 * Interface DataProductOutStockInterface
 * @api
 * @since 100.0.2
 */
interface DataProductOutStockInterface
{
    /**#@+
     * Constants defined for keys of array, makes typos less likely
     */
    
    const SKU           = 'sku';
    const IS_IN_STOCK   = 'is_in_stock';
    const QTY           = 'qty';

    /**#@-*/

    /**
     * Returns the product SKU.
     * @return string
     */
    public function getSku();

    /**
     * Sets the product SKU.
     * @param string $sku
     * @return $this
     */
    public function setSku($sku);

    /**
     * Returns the product quantity.
     * @return float Product quantity.
     */
    public function getIsInStock();

    /**
     * Sets the product in stock.
     * @param bool $isInStock
     * @return bool
     */
    public function setIsInStock($isInStock);

    /**
     * Returns the product quantity.
     * @return float Product quantity.
     */
    public function getQty();

    /**
     * Sets the product quantity.
     * @param float $qty
     * @return $this
     */
    public function setQty($qty);
}
