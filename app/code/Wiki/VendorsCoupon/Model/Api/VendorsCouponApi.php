<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Wiki\VendorsCoupon\Model\Api;

class VendorsCouponApi extends \Magento\Framework\Model\AbstractModel implements
    \Wiki\VendorsCoupon\Api\Data\VendorsCouponInterface
{

    /**
     * @inheritdoc
     */
    public function getVendor()
    {
        return $this->getData(self::VENDOR);
    }

    /**
     * @inheritdoc
     */
    public function setVendor($vendor)
    {
        return $this->setData(self::VENDOR, $vendor);
    }

    /**
     * @inheritdoc
     */
    public function getCoupons()
    {
        return $this->getData(self::COUPONS);
    }

    /**
     * @inheritdoc
     */
    public function setCoupons($coupons)
    {
        return $this->setData(self::COUPONS, $coupons);
    }
}
