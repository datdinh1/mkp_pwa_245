<?php

/**
 *
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Wiki\VendorsCoupon\Api;

/**
 * Coupon management service interface.
 * @api
 */
interface CouponManagementInterface
{
    /**
     * Returns information for a coupon in a specified cart.
     *
     * @param int $cartId The cart ID.
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException The specified cart does not exist.
     */
    public function getDiscountDetail($cartId);

    /**
     * Adds a coupon by code to a specified cart.
     *
     * @param int $cartId The cart ID.
     * @param string $couponCode The coupon code data.
     * @return bool
     * @throws \Magento\Framework\Exception\NoSuchEntityException The specified cart does not exist.
     * @throws \Magento\Framework\Exception\CouldNotSaveException The specified coupon could not be added.
     */
    public function set($cartId, $couponCode);

    /**
     * Deletes a coupon from a specified cart.
     *
     * @param int $cartId The cart ID.
     * @param string $couponCode The coupon code data.
     * @return bool
     * @throws \Magento\Framework\Exception\NoSuchEntityException The specified cart does not exist.
     * @throws \Magento\Framework\Exception\CouldNotDeleteException The specified coupon could not be deleted.
     */
    public function removeCoupon($cartId, $couponCode);

    /**
     * @return \Wiki\VendorsCoupon\Api\Data\VendorsCouponInterface[]
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getAllCoupon();

    /**
     * @param string $cartId
     * @param mixed $allproducts
     * @return \Wiki\VendorsCoupon\Api\CouponManagementInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getAllCouponMKP($cartId, $allproducts);

    /**
     * @return \Wiki\VendorsCoupon\Api\Data\CouponInterface[]
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getListCouponMKP();

    /**
     * @return \Wiki\VendorsCoupon\Api\Data\VendorsCouponInterface[]
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getListCouponByVendor();



    /**
     * @param string $vendorId
     * @param string|null $status
     * @param int|null $pageSize
     * @param int|null $currentPage
     * @return \Wiki\VendorsCoupon\Api\Data\ItemsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getListCouponByVendorId($vendorId, $status = null, $pageSize = null, $currentPage = null);

    /**
     * @param string $cartId
     * @param string $namestore
     * @param mixed $arrayProductID
     * @return \Wiki\VendorsCoupon\Api\CouponManagementInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getCouponByVendor($cartId, $namestore, $arrayProductID);

    /**
     * Adds a coupon by code to a specified cart.
     *
     * @param int $cartId The cart ID.
     * @param string $couponCode The coupon code data.
     * @return bool
     * @throws \Magento\Framework\Exception\NoSuchEntityException The specified cart does not exist.
     * @throws \Magento\Framework\Exception\CouldNotSaveException The specified coupon could not be added.
     */
    public function applyCouponCart($cartId, $couponCode);

    /**
     * Deletes a coupon from a specified cart.
     *
     * @param int $cartId The cart ID.
     * @param string $couponCode The coupon code data.
     * @return bool
     * @throws \Magento\Framework\Exception\NoSuchEntityException The specified cart does not exist.
     * @throws \Magento\Framework\Exception\CouldNotDeleteException The specified coupon could not be deleted.
     */
    public function cancleCoupon($cartId, $couponCode);

    /**
     * @param string $cartId
     * @param mixed $arrayProductID
     * @return \Wiki\VendorsCoupon\Api\CouponManagementInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getCouponMrkByVendor($cartId, $arrayProductID);

    /**
     * Adds a coupon by code to a specified cart.
     *
     * @param string $cartId The cart ID.
     * @param string $couponCode The coupon code data.
     * @param mixed $arrayProductShop
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException The specified cart does not exist.
     * @throws \Magento\Framework\Exception\CouldNotSaveException The specified coupon could not be added.
     */
    public function applyDiscount($cartId, $couponCode, $arrayProductShop);

    /**
     * Adds a coupon by code to a specified cart.
     * @param string $cartId The cart ID.
     * @param string $couponCode The coupon code data.
     * @param mixed $discountCodeStore The coupon code data.
     * @param mixed $arrayProductSelect The coupon code data.
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException The specified cart does not exist.
     * @throws \Magento\Framework\Exception\CouldNotSaveException The specified coupon could not be added.
     */
    public function applyCouponSumProduct($cartId, $couponCode, $discountCodeStore, $arrayProductSelect);

    /**
     * @param string $cartId
     * @param string $namestore
     * @param mixed $arrayProduct
     * @return \Wiki\VendorsCoupon\Api\CouponManagementInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function recommendCoupon($cartId, $namestore, $arrayProduct);


    /**
     * @param int $idGroup
     * @return \Wiki\VendorsCoupon\Api\CouponManagementInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getCouponMallPage($idGroup);

    /**
     * @param string $vendorId
     * @param mixed $rule
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getVendorIdByMKPSeller($vendorId, $rule);

    /**
     * @param int $int
     * @param string $code
     * @return boolean
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function checkCouponByCollected($int, $code);

    /**
     * @param string $vendor
     * @param mixed $rule
     * @return mixed
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function setVendorOfCoupon($vendor, $rule);
}
