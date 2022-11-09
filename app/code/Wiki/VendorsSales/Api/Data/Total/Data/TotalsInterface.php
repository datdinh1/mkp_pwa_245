<?php

namespace Wiki\VendorsSales\Api\Data\Total\Data;

/**
 * Interface TotalsInterface
 */
interface TotalsInterface
{
    /**#@+
     * Constants defined for keys of array, makes typos less likely
     */
    const GRAND_TOTAL                   = 'grand_total';
    const BASE_GRAND_TOTAL              = 'base_grand_total';
    const SUB_TOTAL                     = 'sub_total';
    const BASE_SUBTOTAL                 = 'base_subtotal';
    const DISCOUNT_AMOUNT               = 'discount_amount';
    const BASE_DISCOUNT_AMOUNT          = 'base_discount_amount';
    const SUBTOTAL_WITH_DISCOUNT        = 'subtotal_with_discount';
    const BASE_SUBTOTAL_WITH_DISCOUNT   = 'base_subtotal_with_discount';
    const DISCOUNT_MKP                  = 'discount_mkp';
    /**#@-*/

    /**
     * Get grand total in quote currency
     * @return float|null
     */
    public function getGrandTotal();

    /**
     * Set grand total in quote currency
     * @param float $grandTotal
     * @return $this
     */
    public function setGrandTotal($grandTotal);

    /**
     * Get grand total in base currency
     * @return float|null
     */
    public function getBaseGrandTotal();

    /**
     * Set grand total in base currency
     * @param float $baseGrandTotal
     * @return $this
     */
    public function setBaseGrandTotal($baseGrandTotal);

    /**
     * Get subtotal in quote currency
     * @return float|null
     */
    public function getSubTotal();

    /**
     * Set subtotal in quote currency
     * @param float $subtotal
     * @return $this
     */
    public function setSubTotal($subtotal);

    /**
     * Get subtotal in base currency
     * @return float|null
     */
    public function getBaseSubtotal();

    /**
     * Set subtotal in base currency
     * @param float $baseSubtotal
     * @return $this
     */
    public function setBaseSubtotal($baseSubtotal);

    /**
     * Get discount amount in quote currency
     * @return float|null
     */
    public function getDiscountAmount();

    /**
     * Set discount amount in quote currency
     * @param float $discountAmount
     * @return $this
     */
    public function setDiscountAmount($discountAmount);

    /**
     * Get discount amount in base currency
     * @return float|null
     */
    public function getBaseDiscountAmount();

    /**
     * Set discount amount in base currency
     * @param float $baseDiscountAmount
     * @return $this
     */
    public function setBaseDiscountAmount($baseDiscountAmount);

    /**
     * Get subtotal in quote currency with applied discount
     * @return float|null
     */
    public function getSubtotalWithDiscount();

    /**
     * Set subtotal in quote currency with applied discount
     * @param float $subtotalWithDiscount
     * @return $this
     */
    public function setSubtotalWithDiscount($subtotalWithDiscount);

    /**
     * Get subtotal in base currency with applied discount
     * @return float|null
     */
    public function getBaseSubtotalWithDiscount();

    /**
     * Set subtotal in base currency with applied discount
     * @param float $baseSubtotalWithDiscount
     * @return $this
     */
    public function setBaseSubtotalWithDiscount($baseSubtotalWithDiscount);
    
    /**
     * Get Discount from MKP 
     * @return float|null
     */
    public function getDiscountMkp();

    /**
     * Set Discount from MKP 
     * @param float $price
     * @return $this
     */
    public function setDiscountMkp($price);
}