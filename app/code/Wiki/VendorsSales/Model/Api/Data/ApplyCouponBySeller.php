<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Wiki\VendorsSales\Model\Api\Data;
use Magento\Framework\Model\AbstractModel;
use Wiki\VendorsSales\Api\Data\ApplyCouponBySellerInterface;

/**
 * Apply Coupon by Seller
 */
class ApplyCouponBySeller extends AbstractModel implements ApplyCouponBySellerInterface
{
    /**
     * @inheritdoc
     */
    public function getProducts()
    {
        return $this->getData(self::PRODUCTS);
    }

    /**
     * @inheritdoc
     */
    public function setProducts($products)
    {
        return $this->setData(self::PRODUCTS, $products);
    }

    /**
     * @inheritdoc
     */
    public function getVendorId()
    {
        return $this->getData(self::VENDOR_ID);
    }

    /**
     * @inheritdoc
     */
    public function setVendorId($vendorId)
    {
        return $this->setData(self::VENDOR_ID, $vendorId);
    }

    /**
     * @inheritdoc
     */
    public function getCoupon()
    {
        return $this->getData(self::COUPON);
    }

    /**
     * @inheritdoc
     */
    public function setCoupon($coupon)
    {
        return $this->setData(self::COUPON, $coupon);
    }
}
