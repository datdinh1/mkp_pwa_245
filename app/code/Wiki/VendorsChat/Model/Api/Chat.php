<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Wiki\VendorsChat\Model\Api;

/**
 * Softprodigy Dailydeal date model
 */
class Chat extends \Magento\Framework\Model\AbstractModel implements \Wiki\VendorsChat\Api\Data\ChatInterface
{
    /**
     * Get Vendor id
     *
     * @return string
     */
    public function getVendorId()
    {
        return $this->getData(self::VENDOR_ID);
    }

    /**
     * Set Vendor id
     *
     * @param string $id
     * @return $this
     */
    public function setVendorId($id)
    {
        return $this->setData(self::VENDOR_ID, $id);
    }

    /**
     * Get Visitor id
     *
     * @return int
     */
    public function getCustomerId()
    {
        return $this->getData(self::CUSTOMER_ID);
    }

    /**
     * Set Visitor id
     * @param int $id
     * @return $this
     */
    public function setCustomerId($id)
    {
        return $this->setData(self::CUSTOMER_ID, $id);
    }

    /**
     * Get Message
     *
     * @return string|null
     */
    public function getMessage()
    {
        return $this->getData(self::MESSAGE);
    }

    /**
     * Set Message
     *
     * @param string|null $message
     * @return $this
     */
    public function setMessage($message)
    {
        return $this->setData(self::MESSAGE, $message);
    }

    /**
     * @inheritdoc
     */
    public function getImages()
    {
        return $this->getData(self::IMAGES);
    }

    /**
     * @inheritdoc
     */
    public function setImages($images)
    {
        return $this->setData(self::IMAGES, $images);
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
