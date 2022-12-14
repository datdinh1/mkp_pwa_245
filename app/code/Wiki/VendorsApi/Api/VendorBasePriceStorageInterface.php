<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Wiki\VendorsApi\Api;

/**
 * Base prices storage.
 * @api
 * @since 101.1.0
 */
interface VendorBasePriceStorageInterface
{
    /**
     * Return product prices. In case of at least one of skus is not found exception will be thrown.
     *
     * @param int $customerId
     * @param string[] $skus
     * @return \Magento\Catalog\Api\Data\BasePriceInterface[]
     * @since 101.1.0
     */
    public function get($customerId, array $skus);

    /**
     * Add or update product prices.
     * Input item should correspond \Magento\Catalog\Api\Data\CostInterface.
     * If any items will have invalid price, store id or sku, they will be marked as failed and excluded from
     * update list and \Magento\Catalog\Api\Data\PriceUpdateResultInterface[] with problem description will be returned.
     * If there were no failed items during update empty array will be returned.
     * If error occurred during the update exception will be thrown.
     *
     * @param int $customerId
     * @param \Magento\Catalog\Api\Data\BasePriceInterface[] $prices
     * @return \Magento\Catalog\Api\Data\PriceUpdateResultInterface[]
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     * @since 101.1.0
     */
    public function update($customerId, array $prices);
}
