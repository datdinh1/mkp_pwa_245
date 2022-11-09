<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Wiki\VendorsChat\Model\Api;

/**
 * Softprodigy Dailydeal date model
 */
class BodyContent extends \Magento\Framework\Model\AbstractModel implements \Wiki\VendorsChat\Api\Data\BodyContentInterface
{
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
     * @return string[]|null
     */
    public function getImages()
    {
        return $this->getData(self::IMAGE);
    }

    /**
     * Set Image
     * @param string[] $img
     * @return $this
     */
    public function setImages($img)
    {
        return $this->setData(self::IMAGE, $img);
    }
}
