<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Wiki\StoreApi\Model;

use Wiki\StoreApi\Api\CouponListInterface;
use Wiki\StoreApi\Model\Rule\CouponCollection;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Quote\Model\QuoteIdMaskFactory;
use Wiki\VendorsProduct\Model\ProductManagement;

class CouponList implements CouponListInterface
{
    /**
     * @var CartRepositoryInterface
     */
    protected $quoteRepository;

    /**
     * @var CouponCollection
     */
    protected $couponCollection;

    /**
     * @var QuoteIdMaskFactory
     */
    protected $quoteIdMask;

    /**
     * @var ProductManagement
     */
    protected $productManagement;

    /**
     * @param CartRepositoryInterface $quoteRepository
     * @param CouponCollection $couponCollection
     */
    public function __construct(
        CartRepositoryInterface $quoteRepository,
        QuoteIdMaskFactory      $quoteIdMask,
        CouponCollection        $couponCollection,
        ProductManagement       $productManagement
    ) {
        $this->quoteRepository   = $quoteRepository;
        $this->quoteIdMask       = $quoteIdMask;
        $this->couponCollection  = $couponCollection;
        $this->productManagement = $productManagement;
    }

    /**
     * {@inheritdoc}
     */
    public function getAll()
    {
        return $this->couponCollection->getAllCoupon();
    }

    /**
     * {@inheritdoc}
     */
    public function getAllCouponShip()
    {
        $result = $this->couponCollection->getAllCouponShip();
        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function getCart($cartId)
    {
        /** @var Quote $quote */
        $quote = $this->quoteRepository->getActive($cartId);
        return $this->couponCollection->getValidCouponList($quote);
    }

    /**
     * {@inheritdoc}
     */
    public function getGuest($cartId)
    {
        /** @var QuoteIdMask $quoteIdMask */
        $quoteIdMask = $this->quoteIdMask->create()->load($cartId, 'masked_id');
        return $this->getCart($quoteIdMask->getQuoteId());
    }

    public function recommendProductFreeShip($cusId)
    {
        $listProductRecommend = $this->productManagement->recommendProductProductPage($cusId);

        $result = [];
        if (count($listProductRecommend) > 0) {
            foreach ($listProductRecommend as $productInterface) {
                $attributesFreeShip = $productInterface->getExtensionAttributes()->getIsFreeship();
                if ($attributesFreeShip) {
                    $result[] = $productInterface;
                }
            }
        }
        return $result;
    }
}
