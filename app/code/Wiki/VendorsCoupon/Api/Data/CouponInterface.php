<?php

namespace Wiki\VendorsCoupon\Api\Data;

interface CouponInterface
{
  /**
   * Constants for keys of data array.
   */
  const RULE_ID               = 'rule_id';
  const NAME                  = 'name';
  const COUPONCODE            = 'code';
  const CODE_GENERATE         = 'auto_generate';

  const IMAGE                 = 'image';
  const TODATE                = 'to_date';
  const SIMPLE_ACTION         = 'simple_action';
  const DISCOUNT_AMOUNT       = 'discount_amount';
  const APPLY_TO_SHIPPING     = 'apply_to_shipping';
  const STORE_NAME            = 'store_name';
  const TYPE                  = 'type';
  const IS_RECOMMEND          = 'is_recommend';
  const IS_DISPLAY_ALL        = 'is_display_all';
  const VENDOR                = 'vendor';
  const COUPON_TYPE           = 'coupon_type';
  const MAX_DISCOUNT_AMOUNT   = 'max_discount_amount';
  const MINIMUM_PRICE         = 'minimum_price';
  
  const USES_PER_COUPON     = 'uses_per_coupon';
  const FROM_DATE           = 'from_date';
  const CATEGORY_ID         = 'category_id';


  /**#@-*/

  /**
   * Get Rule Id.
   *
   * @return string|null
   */
  public function getRuleId();

  /**
   * Set Rule Id.
   *
   * @param string|null $ruleId
   *
   * @return $this
   */
  public function setRuleId($ruleId);

  /**
   * Get Coupon Name.
   *
   * @return string|null
   */
  public function getName();

  /**
   * Set Coupon Name.
   *
   * @param string|null $couponName
   *
   * @return $this
   */
  public function setName($couponName);

  /**
   * Get Coupon Code.
   *
   * @return string
   */
  public function getCode();

  /**
   * Set Coupon Code.
   *
   * @param string $couponCode
   *
   * @return $this
   */
  public function setCode($couponCode);

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
   * Get Image Coupon.
   *
   * @return string|null
   */
  public function getImage();

  /**
   * Set Image Coupon.
   *
   * @param string|null
   *
   * @return $this
   */
  public function setImage($image);

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

  /**
   * Get Simple Action.
   *
   * @return string|null
   */
  public function getSimpleAction();

  /**
   * Set Simple Action.
   *
   * @param string|null
   *
   * @return $this
   */
  public function setSimpleAction($simpleAction);

  /**
   * Get Discount Amount.
   *
   * @return int|null
   */
  public function getDiscountAmount();

  /**
   * Set Discount Amount.
   *
   * @param int|null
   *
   * @return $this
   */
  public function setDiscountAmount($discountAmount);

  /**
   * Get Apply To Shipping.
   *
   * @return string|null
   */
  public function getApplyToShipping();

  /**
   * Set Apply To Shipping.
   *
   * @param string|null
   *
   * @return $this
   */
  public function setApplyToShipping($applyToShipping);

  /**
   * Get Store Name.
   *
   * @return string|null
   */
  public function getStoreName();

  /**
   * Set Store Name.
   *
   * @param string|null
   *
   * @return $this
   */
  public function setStoreName($storeName);

  /**
   * Get Type.
   *
   * @return string|null
   */
  public function getType();

  /**
   * Set Type.
   *
   * @param string|null
   *
   * @return $this
   */
  public function setType($type);

  /**
   * Get Is recommend.
   *
   * @return int
   */
  public function getIsRecommend();

  /**
   * Set Is recommend.
   *
   * @param int
   *
   * @return $this
   */
  public function setIsRecommend($type);

  /**
   * Get Show All Page.
   *
   * @return int
   */
  public function getShowAllpage();

  /**
   * Set Show All Page.
   *
   * @param int
   *
   * @return $this
   */
  public function setShowAllpage($type);


  /**
   * Get Vendor.
   *
   * @return \Wiki\VendorsProduct\Api\Data\SellerInterface|null
   */
  public function getVendor();

  /**
   * Set Vendor.
   *
   * @param \Wiki\VendorsProduct\Api\Data\SellerInterface|null
   *
   * @return $this
   */
  public function setVendor($type);

   /**
   * Get Coupon Type.
   *
   * @return string|null
   */
  public function getCouponType();

  /**
   * Set Coupon Type.
   *
   * @param string|null
   *
   * @return $this
   */
  public function setCouponType($type);

   /**
   * Get Max Discount Amount.
   *
   * @return int|null
   */
  public function getMaxDiscountAmount();

  /**
   * Set Max Discount Amount.
   *
   * @param int|null
   *
   * @return $this
   */
  public function setMaxDiscountAmount($type);

   /**
   * Get Minimum Price.
   *
   * @return int|null
   */
  public function getMinimumPrice();

  /**
   * Set Minimum Price.
   *
   * @param int|null
   *
   * @return $this
   */
  public function setMinimumPrice($type);

    /**
   * Get Uses Per Coupon
   *
   * @return int|null
   */
  public function getUsesPerCoupon();

  /**
   * Set Uses Per Coupon
   *
   * @param int|null
   *
   * @return $this
   */
  public function setUsesPerCoupon($per);

    /**
   * Get From Date
   *
   * @return string|null
   */
  public function getFromDate();

  /**
   * Set Minimum Price.
   *
   * @param string|null
   *
   * @return $this
   */
  public function setFromDate($date);


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
