<?php

namespace Wiki\VendorsApi\Api;

/**
 * Vendor CRUD interface.
 * @api
 */
interface MemoRepositoryInterface
{
    /**
     * @param int $customerId
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Wiki\VendorsApi\Api\Data\Sale\MemoSearchResultInterface
     */
    public function getList($customerId, \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     * @param  int $vendorOrderId
     * @param  \Wiki\VendorsApi\Api\Data\Sale\ItemQtyInterface[] $items
     * @param  string $comment
     * @param  int $doOffline
     * @return \Wiki\VendorsApi\Api\Data\Sale\MemoInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function createMemo(
        $vendorOrderId,
        $items,
        $comment,
        $doOffline
    );
}
