<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\StoreApi\Api;

interface CartsMineInterface
{
    /**
     * @api
     * @param int $cartId the cart ID
     * @param \Magento\Quote\Api\Data\CartItemInterface[] $cartItems The items.
     * @return \Wiki\StoreApi\Api\Data\DataProductOutStockInterface[]|null
     */
    public function addCartMultiProduct($cartId, $cartItems);
    
    /**
     * @api
     * @param string $cartId the cart ID
     * @param \Magento\Quote\Api\Data\CartItemInterface[] $cartItems The items.
     * @return \Wiki\StoreApi\Api\Data\DataProductOutStockInterface[]|null
     */
    public function addGuestCartMultiProduct($cartId, $cartItems);

    /**
     * @api
     * @param int $cartId the cart ID
     * @return bool
     */
    public function removeAllItems($cartId);

    /**
     * @api
     * @param string $cartId the cart ID
     * @return bool
     */
    public function removeGuestCartAllItems($cartId);
}
