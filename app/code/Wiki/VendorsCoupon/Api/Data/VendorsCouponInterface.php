<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\VendorsCoupon\Api\Data;

/**
 * Interface PaymentDetailsInterface
 * @api
 */
interface VendorsCouponInterface
{
    const VENDOR    = 'vendor';
    const COUPONS   = 'coupons';


    /**
     * @return \Wiki\VendorsProduct\Api\Data\SellerInterface|null
     */
    public function getVendor();

    /**
     * @param \Wiki\VendorsProduct\Api\Data\SellerInterface|null $vendor
     * @return \Wiki\VendorsProduct\Api\Data\SellerInterface|null
     */
    public function setVendor($vendor);

    /**
     * @return Wiki\VendorsCoupon\Api\Data\CouponInterface[]
     */
    public function getCoupons();

    /**
     * @param Wiki\VendorsCoupon\Api\Data\CouponInterface[] $coupons
     * @return $this
     */
    public function setCoupons($coupons);

}
