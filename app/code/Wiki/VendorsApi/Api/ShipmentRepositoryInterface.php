<?php

namespace Wiki\VendorsApi\Api;

/**
 * Vendor CRUD interface.
 * @api
 */
interface ShipmentRepositoryInterface
{
    /**
     * @param int $customerId
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Wiki\VendorsApi\Api\Data\Sale\ShipmentSearchResultInterface
     */
    public function getList($customerId, \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     * @param  int $customerId
     * @param  int $vendorOrderId
     * @param  \Wiki\VendorsApi\Api\Data\Sale\ItemQtyInterface[] $items
     * @param  string $comment
     * @param  \Wiki\VendorsApi\Api\Data\Sale\TrackingInterface[] $trackings
     * @return \Wiki\VendorsApi\Api\Data\Sale\ShipmentInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function createShipment(
        $customerId,
        $vendorOrderId,
        $items,
        $comment,
        $trackings
    );

}