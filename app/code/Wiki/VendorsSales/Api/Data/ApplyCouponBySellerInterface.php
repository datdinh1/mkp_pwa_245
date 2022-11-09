<?php


namespace Wiki\VendorsSales\Api\Data;
interface ApplyCouponBySellerInterface
{
    /**
     * Constants used as data array keys
     */
    const PRODUCTS              = 'products';
    const VENDOR_ID             = 'vendor_id';
    const COUPON                = 'coupon';

    /**
     * Get Products
     * @return Wiki\VendorsSales\Api\Data\Product\ProductItemInterface[]
     */
    public function getProducts();

    /**
     * Set Products
     * @param Wiki\VendorsSales\Api\Data\Product\ProductItemInterface[] $products
     *
     * @return $this
     */
    public function setProducts($products);

    /**
     * Get Vendor Id
     * @return string
     */
    public function getVendorId();

    /**
     * Set Vendor Id
     * @param string $vendorId
     *
     * @return $this
     */
    public function setVendorId($vendorId);

     /**
     * Get Coupon
     * @return string
     */
    public function getCoupon();

    /**
     * Set Coupon
     * @param string $coupon
     *
     * @return $this
     */
    public function setCoupon($coupon);
}