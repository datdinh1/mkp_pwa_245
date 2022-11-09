<?php

namespace Wiki\VendorsSalesRule\Api\Data;

interface RuleInterface
{
    /**
     * Constants used as data array keys
     */
    const RULE_ID             = 'rule_id';
    const VENDOR_ID           = 'vendor_id';
    const TYPE                = 'type';
    const NAME                = 'name';
    const COUPON_CODE         = 'coupon_code';
    const CODE_GENERATE         = 'auto_generate';
    const IS_RECOMMEND        = 'is_recommend';
    const IS_DISPLAY_ALL      = 'is_display_all';

    const FROM_DATE           = 'from_date';
    const TO_DATE             = 'to_date';
    const SIMPLE_ACTION       = 'simple_action';
    const DISCOUNT_AMOUNT     = 'discount_amount';

    const MAX_DISCOUNT_AMOUNT = 'max_discount_amount';
    const MINIMUM_PRICE       = 'minimum_price';
    const USES_PER_COUPON     = 'uses_per_coupon';
    const LIST_SKU            = 'list_sku';
    const IMAGE               = 'image';
    const CATEGORY_ID         = 'category_id';

    const BYFIXED            = 'by_fixed';

    /**
     * Get Rule id
     *
     * @return int|null
     */
    public function getRuleId();

    /**
     * Set Rule id
     *
     * @param int|null $ruleId
     *
     * @return $this
     */
    public function setRuleId($ruleId);

    /**
     * Get Vendor id
     *
     * @return string|null
     */
    public function getVendorId();

    /**
     * Set Vendor id
     *
     * @param string|null $vendorId
     *
     * @return $this
     */
    public function setVendorId($vendorId);

    /**
     * Get type of coupon
     *
     * @return string
     */
    public function getType();

    /**
     * Set type of coupon
     *
     * @param string $type
     *
     * @return $this
     */
    public function setType($type);

    /**
     * Get Name of coupon 
     *
     * @return string
     */
    public function getName();

    /**
     * Set Name of coupon 
     *
     * @param string $name
     *
     * @return $this
     */
    public function setName($name);

    /**
     * Get From Date
     *
     * @return string
     */
    public function getFromDate();

    /**
     * Set From Date
     *
     * @param string $date
     *
     * @return $this
     */
    public function setFromDate($date);

    /**
     * Get To Date
     *
     * @return string
     */
    public function getToDate();

    /**
     * Set To Date
     *
     * @param string $date
     *
     * @return $this
     */
    public function setToDate($date);

    /**
     * Get simple action
     *
     * @return string
     */
    public function getSimpleAction();

    /**
     * Set simple action
     *
     * @param string $action
     *
     * @return $this
     */
    public function setSimpleAction($action);

    /**
     * Get discount amount
     *
     * @return int
     */
    public function getDiscountAmount();

    /**
     * Set discount amount
     *
     * @param int $amount
     *
     * @return $this
     */
    public function setDiscountAmount($amount);

    /**
     * Get Max discount amount
     *
     * @return int|null
     */
    public function getMaxDiscountAmount();

    /**
     * Set Max discount amount
     *
     * @param int|null $amount
     *
     * @return $this
     */
    public function setMaxDiscountAmount($amount);

    /**
     * Get Minimun Price
     *
     * @return int
     */
    public function getMinimumPrice();

    /**
     * Set Minimun Price
     *
     * @param int|null $price
     *
     * @return $this
     */
    public function setMinimumPrice($price);

    /**
     * Get uses person coupon
     *
     * @return int
     */
    public function getUsesPerCoupon();

    /**
     * Set uses person coupon
     *
     * @param int $per
     *
     * @return $this
     */
    public function setUsesPerCoupon($per);

    /**
     * Get list sku
     *
     * @return string[]
     */
    public function getListSku();

    /**
     * Set list sku
     *
     * @param string[]|null $sku
     *
     * @return $this
     */
    public function setListSku($sku);

    /**
     * Get code
     *
     * @return string
     */
    public function getCode();

    /**
     * Set code
     *
     * @param string $code
     *
     * @return $this
     */
    public function setCode($code);

    /**
     * Get code Generate
     *
     * @return string|null
     */
    public function getCodeGenerate();

    /**
     * Set code Generate
     *
     * @param string|null $codeGenerate
     *
     * @return $this
     */
    public function setCodeGenerate($codeGenerate);

    /**
     * Get Is Recommend
     *
     * @return int
     */
    public function getIsRecommend();

    /**
     * Set Is Recommend
     *
     * @param int $isRecommend
     *
     * @return $this
     */
    public function setIsRecommend($isRecommend);

    /**
     * Get Show All page
     *
     * @return int
     */
    public function getShowAllpage();

    /**
     * Set Show All page
     *
     * @param int $isDisplayAllPage
     *
     * @return $this
     */
    public function setShowAllpage($isDisplayAllPage);

    /**
     * Get Image
     *
     * @return string|null
     */
    public function getImage();

    /**
     * Set Image
     *
     * @param string|null $image
     *
     * @return $this
     */
    public function setImage($image);

     /**
     * Get Category id
     *
     * @return int|null
     */
    public function getCategoryId();

    /**
     * Set Category id
     *
     * @param int|null $id
     *
     * @return $this
     */
    public function setCategoryId($id);
}
