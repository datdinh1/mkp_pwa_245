<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\VendorsNotification\Api;

interface NotificationRepositoryInterface
{
    /**
     * @param int $id
     * @return \Wiki\VendorsNotification\Api\Data\NotificationInterface
     */
    public function getNotificationById($id);

    /**
     * @param int $customerId
     * @return \Wiki\VendorsNotification\Api\Data\NotificationInterface[]
     */
    public function getNotificationByCustomerId($customerId);

    /**
     * @param int $vendorId
     * @return \Wiki\VendorsNotification\Api\Data\NotificationInterface[]
     */
    public function getNotificationByVendorId($vendorId);

    /**
     * @param int $order_id
     * @param string $reason
     * @return bool
     */
    public function createNotificationRequest($order_id, $reason);

    /**
     * @param int $order_id
     * @param string $reason
     * @param boolean $accept
     * @return bool
     */
    public function createNotificationConfirm($order_id, $reason, $accept);

    /**
     * @param int $order_id
     * @param string $reason
     * @return bool
     */
    public function createNotificationDeny($order_id, $reason);
}
