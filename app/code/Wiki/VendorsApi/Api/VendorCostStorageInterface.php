<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Wiki\VendorsApi\Api;

/**
 * Product cost storage.
 * @api
 * @since 101.1.0
 */
interface VendorCostStorageInterface
{
    /**
     * Return product prices. In case of at least one of skus is not found exception will be thrown.
     *
     * @param int $customerId
     * @param string[] $skus
     * @return \Magento\Catalog\Api\Data\CostInterface[]
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @since 101.1.0
     */
    public function get($customerId, array $skus);

    /**
     * Add or update product cost.
     * Input item should correspond to \Magento\Catalog\Api\Data\CostInterface.
     * If any items will have invalid cost, store id or sku, they will be marked as failed and excluded from
     * update list and \Magento\Catalog\Api\Data\PriceUpdateResultInterface[] with problem description will be returned.
     * If there were no failed items during update empty array will be returned.
     * If error occurred during the update exception will be thrown.
     *
     * @param int $customerId
     * @param \Magento\Catalog\Api\Data\CostInterface[] $prices
     * @return \Magento\Catalog\Api\Data\PriceUpdateResultInterface[]
     * @since 101.1.0
     */
    public function update($customerId, array $prices);

    /**
     * Delete product cost. In case of at least one of skus is not found exception will be thrown.
     * If error occurred during the delete exception will be thrown.
     *
     * @param int $customerId
     * @param string[] $skus
     * @return bool Will return True if deleted.
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     * @since 101.1.0
     */
    public function delete($customerId, array $skus);
}
