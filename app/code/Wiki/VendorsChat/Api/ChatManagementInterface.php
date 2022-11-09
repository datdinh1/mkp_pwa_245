<?php

/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Wiki\VendorsChat\Api;

use Magento\Framework\Exception\InputException;

/**
 * Interface for managing customers accounts.
 * @api
 * @since 100.0.2
 */
interface ChatManagementInterface
{
    /**
     * @param \Wiki\VendorsChat\Api\Data\ChatInterface $message
     * @return boolean
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function createConversation($message);

    /**
     * @param string[] $base64_image
     * @return string[]
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function uploadImage($base64_image);

    /**
     * @param string $id
     * @param string $sender_type
     * @param int|null $page_size
     * @param int|null $current_page
     * @return \Wiki\VendorsChat\Api\Data\DataRoomItemsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getListRoomById($id, $sender_type, $page_size = null, $current_page = null);

    /**
     * @param int $customer_id
     * @param string $vendor_id
     * @param string $token
     * @param string $type
     * @param int|null $page_size
     * @param int|null $current_page
     * @return \Wiki\VendorsChat\Api\Data\DataMessageItemsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getMessage($customer_id, $vendor_id, $token, $type, $page_size = null, $current_page = null);

    /**
     * @param int $room_id
     * @param string $id
     * @param string $token
     * @param string $sender_type
     * @return bool
     */
    public function deleteRoom($room_id, $id, $token, $sender_type);
}
