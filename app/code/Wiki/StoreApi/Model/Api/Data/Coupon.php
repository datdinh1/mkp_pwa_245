<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Wiki\StoreApi\Model\Api\Data;


class Coupon extends \Magento\Framework\Api\AbstractExtensibleObject implements
    \Wiki\StoreApi\Api\Data\CouponInterface
{

    /**
     * Get Coupon Name
     *
     * @return $this
     */
    public function getCouponName()
    {
        return $this->_get(self::COUPONNAME);
    }

    /**
     * Set Coupon Name
     *
     * @param string $couponName
     * @return $this
     */
    public function setCouponName($couponName)
    {
        return $this->setData(self::COUPONNAME, $couponName);
    }

    /**
     * Get Coupon Code
     *
     * @return $this
     */
    public function getCouponCode()
    {
        return $this->_get(self::COUPONCODE);
    }

    /**
     * Set Coupon Code
     *
     * @param string $couponCode
     * @return $this
     */
    public function setCouponCode($couponCode)
    {
        return $this->setData(self::COUPONCODE, $couponCode);
    }

    /**
     * Get Description
     *
     * @return $this
     */
    public function getDescription()
    {
        return $this->_get(self::DESCRIPTION);
    }

    /**
     * Set Description
     *
     * @param string $description
     * @return $this
     */
    public function setDescription($description)
    {
        return $this->setData(self::DESCRIPTION, $description);
    }

    /**
     * Get To Date
     *
     * @return $this
     */
    public function getToDate()
    {
        return $this->_get(self::TODATE);
    }

    /**
     * Set To Date
     *
     * @param string $toDate
     * @return $this
     */
    public function setToDate($toDate)
    {
        return $this->setData(self::TODATE, $toDate);
    }
}
