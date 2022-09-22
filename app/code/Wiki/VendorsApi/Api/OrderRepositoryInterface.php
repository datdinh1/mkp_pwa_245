<?php

namespace Wiki\VendorsApi\Api;

/**
 * Vendor CRUD interface.
 * @api
 */
interface OrderRepositoryInterface
{
    /**
     * @param int $customerId
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Wiki\VendorsApi\Api\Data\Sale\OrderSearchResultInterface
     */
    public function getList($customerId, \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);
    
    /**
     * @param int $customerId
     * @param int $orderId
     * @return \Wiki\VendorsApi\Api\Data\Sale\OrderInterface
     */
    public function getOrder($customerId, $orderId);
    
    /**
     * @param int $customerId
     * @param int $orderId
     * @return bool
     */
    public function cancel($customerId, $orderId);
}
