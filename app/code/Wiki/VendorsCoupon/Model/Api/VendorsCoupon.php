<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Wiki\VendorsCoupon\Model\Api;

class VendorsCoupon extends \Magento\Framework\Model\AbstractModel implements
    \Wiki\VendorsCoupon\Api\Data\VendorsCouponInterface
{

    /**
     * 
     * @return \Wiki\VendorsProduct\Api\Data\SellerInterface
     */
    public function getVendor()
    {
        return $this->getData(self::VENDOR);
    }

    /**
     * 
     * @param \Wiki\VendorsProduct\Api\Data\SellerInterface|null $vendor
     * @return $this
     */
    public function setVendor($vendor)
    {
        return $this->setData(self::VENDOR, $vendor);
    }

    /**
     * 
     * @return \Wiki\VendorsCoupon\Api\Data\CouponInterface[]
     */
    public function getCoupons()
    {
        return $this->getData(self::COUPONS);
    }

    /**
     * @param \Wiki\VendorsCoupon\Api\Data\CouponInterface[] $coupons
     * @return $this
     */
    public function setCoupons($coupons)
    {
        return $this->setData(self::COUPONS, $coupons);
    }
}
