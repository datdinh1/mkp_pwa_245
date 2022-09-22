<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Wiki\VendorsChat\Model\Api;

/**
 * Softprodigy Dailydeal date model
 */
class Room extends \Magento\Framework\Model\AbstractModel implements \Wiki\VendorsChat\Api\Data\RoomInterface
{
    /**
     * Get Chat Id
     *
     * @return int
     */
    public function getRoomId()
    {
        return $this->getData(self::ROOM_ID);
    }

    /**
     * Set Chat Id
     *
     * @param int $id
     * @return $this
     */
    public function setRoomId($id)
    {
        return $this->setData(self::ROOM_ID, $id);
    }

    /**
     * Get Customer Id
     *
     * @return int
     */
    public function getCustomerId()
    {
        return $this->getData(self::CUSTOMER_ID);
    }

    /**
     * Set Customer Id
     * @param int $id
     * @return $this
     */
    public function setCustomerId($id)
    {
        return $this->setData(self::CUSTOMER_ID, $id);
    }

    /**
     * Get Vendor Id
     *
     * @return string
     */
    public function getVendorId()
    {
        return $this->getData(self::VENDOR_ID);
    }

    /**
     * SetVendor Id
     * @param string $id
     * @return $this
     */
    public function setVendorId($id)
    {
        return $this->setData(self::VENDOR_ID, $id);
    }

    /**
     * @inheritdoc
     */
    public function getIsRead()
    {
        return $this->getData(self::IS_READ);
    }

    /**
     * @inheritdoc
     */
    public function setIsRead($isRead)
    {
        return $this->setData(self::IS_READ, $isRead);
    }

    /**
     * Get Created At
     *
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * Set Created At
     * @param string $date
     * @return $this
     */
    public function setCreatedAt($date)
    {
        return $this->setData(self::CREATED_AT, $date);
    }

    /**
     * Get Update At
     *
     * @return string
     */
    public function getUpdatedAt()
    {
        return $this->getData(self::UPDATED_AT);
    }

    /**
     * Set Update At
     * @param string $date
     * @return $this
     */
    public function setUpdatedAt($date)
    {
        return $this->setData(self::UPDATED_AT, $date);
    }
}
