<?php


namespace Wiki\VendorsSalesRule\Model\Api;

class Rule extends \Magento\Framework\Model\AbstractModel implements \Wiki\VendorsSalesRule\Api\Data\RuleInterface
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
     * Get Vendor id
     *
     * @return string|null
     */
    public function getVendorId()
    {
        return $this->getData(self::VENDOR_ID);
    }

    /**
     * Set Vendor id 
     *
     * @param string|null $vendorId
     * @return $this
     */
    public function setVendorId($vendorId)
    {
        return $this->setData(self::VENDOR_ID, $vendorId);
    }


    /**
     * Get type of coupon
     *
     * @return string
     */
    public function getType()
    {
        return $this->getData(self::TYPE);
    }

    /**
     * Set type of coupon
     *
     * @param string $type
     *
     * @return $this
     */
    public function setType($type)
    {
        return $this->setData(self::TYPE, $type);
    }

    /**
     * Get Name of coupon 
     *
     * @return string
     */
    public function getName()
    {
        return $this->getData(self::NAME);
    }

    /**
     * Set Name of coupon 
     *
     * @param string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * Get From Date
     *
     * @return string
     */
    public function getFromDate()
    {
        return $this->getData(self::FROM_DATE);
    }

    /**
     * Set From Date
     *
     * @param string $date
     *
     * @return $this
     */
    public function setFromDate($date)
    {
        return $this->setData(self::FROM_DATE, $date);
    }

    /**
     * Get To Date
     *
     * @return string
     */
    public function getToDate()
    {
        return $this->getData(self::TO_DATE);
    }

    /**
     * Set To Date
     *
     * @param string $date
     *
     * @return $this
     */
    public function setToDate($date)
    {
        return $this->setData(self::TO_DATE, $date);
    }

    /**
     * Get simple action
     *
     * @return string
     */
    public function getSimpleAction()
    {
        return $this->getData(self::SIMPLE_ACTION);
    }

    /**
     * Set simple action
     *
     * @param string $action
     *
     * @return $this
     */
    public function setSimpleAction($action)
    {
        return $this->setData(self::SIMPLE_ACTION, $action);
    }

    /**
     * Get discount amount
     *
     * @return int
     */
    public function getDiscountAmount()
    {
        return $this->getData(self::DISCOUNT_AMOUNT);
    }
    /**
     * Set discount amount
     *
     * @param int|null $amount
     *
     * @return $this
     */
    public function setDiscountAmount($amount)
    {
        return $this->setData(self::DISCOUNT_AMOUNT, $amount);
    }

    /**
     * Get Max discount amount
     *
     * @return int
     */
    public function getMaxDiscountAmount()
    {
        return $this->getData(self::DISCOUNT_AMOUNT);
    }
    /**
     * Set Max discount amount
     *
     * @param int|null $amount
     *
     * @return $this
     */
    public function setMaxDiscountAmount($amount)
    {
        return $this->setData(self::MAX_DISCOUNT_AMOUNT, $amount);
    }

    /**
     * Get Minimun Price
     *
     * @return int
     */
    public function getMinimumPrice()
    {
        return $this->getData(self::MINIMUM_PRICE);
    }
    /**
     * Set Minimun Price
     *
     * @param int|null $price
     *
     * @return $this
     */
    public function setMinimumPrice($price)
    {
        return $this->setData(self::MINIMUM_PRICE, $price);
    }

    /**
     * Get uses person coupon
     *
     * @return int
     */
    public function getUsesPerCoupon()
    {
        return $this->getData(self::USES_PER_COUPON);
    }
    /**
     * Set uses person coupon
     *
     * @param int $per
     *
     * @return $this
     */
    public function setUsesPerCoupon($per)
    {
        return $this->setData(self::USES_PER_COUPON, $per);
    }

    /**
     * Get list sku
     *
     * @return string[]
     */
    public function getListSku()
    {
        return $this->getData(self::LIST_SKU);
    }
    /**
     * Set Coupon Code
     *
     * @param string[]|null $sku
     *
     * @return $this
     */
    public function setListSku($sku)
    {
        return $this->setData(self::LIST_SKU, $sku);
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->getData(self::COUPON_CODE);
    }
    /**
     * Set code
     *
     * @param string $code
     *
     * @return $this
     */
    public function setCode($code)
    {
        return $this->setData(self::COUPON_CODE, $code);
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
     * @inheritdoc
     */
    public function getIsRecommend()
    {
        return $this->getData(self::IS_RECOMMEND);
    }
    /**
     * @inheritdoc
     */
    public function setIsRecommend($isRecommend)
    {
        return $this->setData(self::IS_RECOMMEND, $isRecommend);
    }

    /**
     * @inheritdoc
     */
    public function getShowAllpage()
    {
        return $this->getData(self::IS_DISPLAY_ALL);
    }
    /**
     * @inheritdoc
     */
    public function setShowAllpage($isDisplayAllPage)
    {
        return $this->setData(self::IS_DISPLAY_ALL, $isDisplayAllPage);
    }

    /**
     * @inheritdoc
     */
    public function getImage()
    {
        return $this->getData(self::IMAGE);
    }
    /**
     * @inheritdoc
     */
    public function setImage($image)
    {
        return $this->setData(self::IMAGE, $image);
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
