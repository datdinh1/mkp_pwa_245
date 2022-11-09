<?php

namespace Wiki\VendorsApi\Api;

interface NotificationRepositoryInterface
{
    /**
     * @param int $customerId
     * @return int
     */
    public function getUnreadCount($customerId);
    
    /**
     * @param int $customerId
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Wiki\VendorsApi\Api\Data\NotificationSearchResultInterface
     */
    public function getList($customerId, \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     * @param int $customerId
     * @return bool
     */
    public function markAllAsRead($customerId);

    /**
     * @param int $notificationId
     * @param int $customerId
     * @return bool
     */
    public function deleteById($notificationId, $customerId);

    /**
     * @param int[] $notificationIds
     * @param int $customerId
     * @return bool
     */
    public function massDelete($notificationIds, $customerId);
}
