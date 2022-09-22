<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\StoreApi\Api;

interface CouponListInterface
{
    /**
     * @api
     * @return \Wiki\StoreApi\Api\Data\CouponInterface[] the coupon list data
     * @throws \Magento\Framework\Exception\NoSuchEntityException the specified cart does not exist
     */
    public function getAll();

    /**
     * @api
     * @return \Wiki\VendorsCoupon\Api\Data\CouponInterface[]
     * @throws \Magento\Framework\Exception\NoSuchEntityException the specified cart does not exist
     */
    public function getAllCouponShip();

    /**
     * @api
     * @param int $cartId the cart ID
     * @return \Wiki\StoreApi\Api\Data\CouponInterface[] the coupon list data
     * @throws \Magento\Framework\Exception\NoSuchEntityException the specified cart does not exist
     */
    public function getCart($cartId);

    /**
     * @api
     * @param string $cartId the cart ID
     * @return \Wiki\StoreApi\Api\Data\CouponInterface[] the coupon list data
     * @throws \Magento\Framework\Exception\NoSuchEntityException the specified cart does not exist
     */
    public function getGuest($cartId);
    
    /**
     * @param int $cusId
     * @return \Magento\Catalog\Api\Data\ProductInterface[]
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function recommendProductFreeShip($cusId);
}
