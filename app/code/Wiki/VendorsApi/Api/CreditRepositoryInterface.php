<?php

namespace Wiki\VendorsApi\Api;

/**
 * Vendor CRUD interface.
 * @api
 */
interface CreditRepositoryInterface
{
    /**
     * @param int $customerId
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Wiki\VendorsApi\Api\Data\Credit\TransactionSearchResultInterface
     */
    public function getTransactions($customerId, \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);
}
