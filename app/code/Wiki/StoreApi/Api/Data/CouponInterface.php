<?php

namespace Wiki\StoreApi\Api\Data;

interface CouponInterface
{
    /**
     * Constants for keys of data array.
     */
    const COUPONNAME            = 'coupon_name';
    const COUPONCODE            = 'coupon_code';
    const DESCRIPTION           = 'description';
    const TODATE                = 'to_date';

    /**#@-*/

    /**
     * Get Coupon Name.
     *
     * @return string|null
     */
    public function getCouponName();

    /**
     * Set Coupon Name.
     *
     * @param string|null $couponName
     *
     * @return $this
     */
    public function setCouponName($couponName);

    /**
     * Get Coupon Code.
     *
     * @return string
     */
    public function getCouponCode();

    /**
     * Set Coupon Code.
     *
     * @param string $couponCode
     *
     * @return $this
     */
    public function setCouponCode($couponCode);

    /**
     * Get Description.
     *
     * @return string|null
     */
    public function getDescription();

    /**
     * Set Description.
     *
     * @param string|null
     *
     * @return $this
     */
    public function setDescription($description);

    /**
     * Get To Date.
     *
     * @return string|null
     */
    public function getToDate();

    /**
     * Set To Date.
     *
     * @param string|null
     *
     * @return $this
     */
    public function setToDate($toDate);


}