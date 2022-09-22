<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Wiki\VendorsCoupon\Model\Api;


class Coupon extends \Magento\Framework\Model\AbstractModel implements
    \Wiki\VendorsCoupon\Api\Data\CouponInterface
{

    /**
     * @inheritdoc
     */
    public function getRuleId()
    {
        return $this->getData(self::RULE_ID);
    }

    /**
     * @inheritdoc
     */
    public function setRuleId($ruleId)
    {
        return $this->setData(self::RULE_ID, $ruleId);
    }

    /**
     * Get Coupon Name
     *
     * @return $this
     */
    public function getName()
    {
        return $this->getData(self::NAME);
    }

    /**
     * Set Coupon Name
     *
     * @param string $couponName
     * @return $this
     */
    public function setName($couponName)
    {
        return $this->setData(self::NAME, $couponName);
    }

    /**
     * Get Coupon Code
     *
     * @return $this
     */
    public function getCode()
    {
        return $this->getData(self::COUPONCODE);
    }

    /**
     * Set Coupon Code
     *
     * @param string $couponCode
     * @return $this
     */
    public function setCode($couponCode)
    {
        return $this->setData(self::COUPONCODE, $couponCode);
    }

    /**
     * @inheritdoc
     */
    public function getCodeGenerate()
    {
        return $this->getData(self::CODE_GENERATE);
    }
    /**
     * @inheritdoc
     */
    public function setCodeGenerate($codeGenerate)
    {
        return $this->setData(self::CODE_GENERATE, $codeGenerate);
    }

    /**
     * Get Image Coupon
     *
     * @return $this
     */
    public function getImage()
    {
        return $this->getData(self::IMAGE);
    }

    /**
     * Set Image Coupon
     *
     * @param string $image
     * @return $this
     */
    public function setImage($image)
    {
        return $this->setData(self::IMAGE, $image);
    }

    /**
     * Get To Date
     *
     * @return $this
     */
    public function getToDate()
    {
        return $this->getData(self::TODATE);
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

    /**
     * Get Simple Action.
     *
     * @return $this
     */
    public function getSimpleAction()
    {
        return $this->getData(self::SIMPLE_ACTION);
    }

    /**
     * Set Simple Action.
     *
     * @param string $simpleAction
     * @return $this
     */
    public function setSimpleAction($simpleAction)
    {
        return $this->setData(self::SIMPLE_ACTION, $simpleAction);
    }

    /**
     * Get Discount Amount.
     *
     * @return $this
     */
    public function getDiscountAmount()
    {
        return $this->getData(self::DISCOUNT_AMOUNT);
    }

    /**
     * Set Discount Amount.
     *
     * @param int $discountAmount
     * @return $this
     */
    public function setDiscountAmount($discountAmount)
    {
        return $this->setData(self::DISCOUNT_AMOUNT, $discountAmount);
    }

    /**
     * Get Apply To Shipping.
     *
     * @return $this
     */
    public function getApplyToShipping()
    {
        return $this->getData(self::APPLY_TO_SHIPPING);
    }

    /**
     * Set Apply To Shipping.
     *
     * @param string $applyToShipping
     * @return $this
     */
    public function setApplyToShipping($applyToShipping)
    {
        return $this->setData(self::APPLY_TO_SHIPPING, $applyToShipping);
    }

    /**
     * Get Store Name.
     *
     * @return $this
     */
    public function getStoreName()
    {
        return $this->getData(self::STORE_NAME);
    }

    /**
     * Set Store Name.
     *
     * @param string $storeName
     * @return $this
     */
    public function setStoreName($storeName)
    {
        return $this->setData(self::STORE_NAME, $storeName);
    }

    /**
     * Get Type.
     *
     * @return $this
     */
    public function getType()
    {
        return $this->getData(self::TYPE);
    }

    /**
     * Set Type.
     *
     * @param string $type
     * @return $this
     */
    public function setType($type)
    {
        return $this->setData(self::TYPE, $type);
    }

    /**
     * Get Is recommend.
     *
     * @return $this
     */
    public function getIsRecommend()
    {
        return $this->getData(self::IS_RECOMMEND);
    }

    /**
     * Set Is recommend.
     *
     * @param int $recommend
     * @return $this
     */
    public function setIsRecommend($recommend)
    {
        return $this->setData(self::IS_RECOMMEND, $recommend);
    }

    /**
     * Get Show All page.
     *
     * @return $this
     */
    public function getShowAllpage()
    {
        return $this->getData(self::IS_DISPLAY_ALL);
    }

    /**
     * Set Show All page.
     *
     * @param int $show
     * @return $this
     */
    public function setShowAllpage($show)
    {
        return $this->setData(self::IS_DISPLAY_ALL, $show);
    }

    /**
     * Get Vendor.
     *
     * @return $this
     */
    public function getVendor()
    {
        return $this->getData(self::VENDOR);
    }

    /**
     * Set Vendor.
     *
     * @param \Wiki\VendorsProduct\Api\Data\SellerInterface $vendor
     * @return $this
     */
    public function setVendor($vendor)
    {
        return $this->setData(self::VENDOR, $vendor);
    }

     /**
     * Get Coupon Type
     *
     * @return $this
     */
    public function getCouponType()
    {
        return $this->getData(self::COUPON_TYPE);
    }

    /**
     * Set Coupon Type
     *
     * @param string|null $type
     * @return $this
     */
    public function setCouponType($type)
    {
        return $this->setData(self::COUPON_TYPE, $type);
    }

     /**
     * Get Max Discount Amount.
     *
     * @return $this
     */
    public function getMaxDiscountAmount()
    {
        return $this->getData(self::MAX_DISCOUNT_AMOUNT);
    }

    /**
     * Set Max Discount Amount.
     *
     * @param int|null $price
     * @return $this
     */
    public function setMaxDiscountAmount($price)
    {
        return $this->setData(self::MAX_DISCOUNT_AMOUNT, $price);
    }

     /**
     * Get Minimum Price.
     *
     * @return $this
     */
    public function getMinimumPrice()
    {
        return $this->getData(self::MINIMUM_PRICE);
    }

    /**
     * Set Minimum Price.
     *
     * @param int|null $price
     * @return $this
     */
    public function setMinimumPrice($price)
    {
        return $this->setData(self::MINIMUM_PRICE, $price);
    }

     /**
     * Get Uses Per Coupon
     *
     * @return $this
     */
    public function getUsesPerCoupon()
    {
        return $this->getData(self::USES_PER_COUPON);
    }

    /**
     * Set Uses Per Coupon
     *
     * @param int|null $per
     * @return $this
     */
    public function setUsesPerCoupon($per)
    {
        return $this->setData(self::USES_PER_COUPON, $per);
    }

    /**
     * Get From Date
     *
     * @return $this
     */
    public function getFromDate()
    {
        return $this->getData(self::FROM_DATE);
    }

    /**
     * Set From Date
     *
     * @param string|null $date
     * @return $this
     */
    public function setFromDate($date)
    {
        return $this->setData(self::FROM_DATE, $date);
    }

      /**
     * @inheritdoc
     */
    public function getCategoryId()
    {
        return $this->getData(self::CATEGORY_ID);
    }
    /**
     * @inheritdoc
     */
    public function setCategoryId($id)
    {
        return $this->setData(self::CATEGORY_ID, $id);
    }
}
