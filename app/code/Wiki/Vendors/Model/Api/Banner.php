<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Wiki\Vendors\Model\Api;

class Banner extends \Magento\Framework\Model\AbstractModel implements \Wiki\Vendors\Api\Data\BannerInterface
{
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
     *
     * @param string $image
     * @return $this
     */
    public function setImage($image)
    {
        return $this->setData(self::IMAGE, $image);
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->getData(self::URL);
    }

    /**
     * Set url
     *
     * @param string $url
     * @return $this
     */
    public function setUrl($url)
    {
        return $this->setData(self::URL, $url);
    }

    /**
     * Get id
     *
     * @return string
     */
    public function getId()
    {
        return $this->getData(self::ID);
    }

    /**
     * Set id
     *
     * @param string $id
     * @return $this
     */
    public function setId($id)
    {
        return $this->setData(self::ID, $id);
    }
}
