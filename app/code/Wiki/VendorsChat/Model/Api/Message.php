<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Wiki\VendorsChat\Model\Api;

/**
 * Softprodigy Dailydeal date model
 */
class Message extends \Magento\Framework\Model\AbstractModel implements \Wiki\VendorsChat\Api\Data\MessageInterface
{
    /**
     * Get Action Id
     *
     * @return int
     */
    public function getMessageId()
    {
        return $this->getData(self::MSG_ID);
    }

    /**
     * Set Action Id
     *
     * @param int $id
     * @return $this
     */
    public function setMessageId($mgsId)
    {
        return $this->setData(self::MSG_ID, $mgsId);
    }
    /**
     * Get Room Id
     *
     * @return int
     */
    public function getRoomId()
    {
        return $this->getData(self::ROOM_ID);
    }

    /**
     * Set Room Id
     *
     * @param int $id
     * @return $this
     */
    public function setRoomId($roomId)
    {
        return $this->setData(self::ROOM_ID, $roomId);
    }

    /**
     * Get Message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->getData(self::MESSAGE);
    }

    /**
     * Set Message
     *
     * @param string $mess
     * @return $this
     */
    public function setMessage($mess)
    {
        return $this->setData(self::MESSAGE, $mess);
    }

    /**
     * Get Image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->getData(self::IMAGE);
    }

    /**
     * Set Image
     * @param string $image
     * @return $this
     */
    public function setImage($image)
    {
        return $this->setData(self::IMAGE, $image);
    }

    /**
     * Get  Sender Id
     *
     * @return string
     */
    public function getSenderId()
    {
        return $this->getData(self::SENDER_ID);
    }

    /**
     * Set  Sender Id
     *
     * @param string $id
     * @return $this
     */
    public function setSenderId($id)
    {
        return $this->setData(self::SENDER_ID, $id);
    }

    /**
     * Get  Sender type
     *
     * @return string
     */
    public function getSenderType()
    {
        return $this->getData(self::SENDER_TYPE);
    }

    /**
     * Set  Sender type
     *
     * @param string $type
     * @return $this
     */
    public function setSenderType($type)
    {
        return $this->setData(self::SENDER_TYPE, $type);
    }

    /**
     * Get  Created At
     *
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * Set  Created At
     *
     * @param string $date
     * @return $this
     */
    public function setCreatedAt($date)
    {
        return $this->setData(self::CREATED_AT, $date);
    }


    /**
     * Get From System
     *
     * @return boolean
     */
    public function getFromSystem()
    {
        return $this->getData(self::FROM_SYSTEM);
    }

    /**
     * Set From System
     *
     * @param boolean $type
     * @return $this
     */
    public function setFromSystem($type)
    {
        return $this->setData(self::FROM_SYSTEM, $type);
    }
   
}
