<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Wiki\Vendors\Model\Api;

/**
 * Softprodigy Dailydeal date model
 */
class General extends \Magento\Framework\Model\AbstractModel implements \Wiki\Vendors\Api\Data\GeneralInterface
{
    /**
     * Get falcon
     *
     * @return string
     */
    public function getFalcon()
    {
        return $this->getData(self::FALCON);
    }

    /**
     * Set falcon
     *
     * @param string $falcon
     * @return $this
     */
    public function setFalcon($falcon)
    {
        return $this->setData(self::FALCON, $falcon);
    }

    /**
     * Get Seller Logo
     *
     * @return string
     */
    public function getSellerLogo()
    {
        return $this->getData(self::SELLER_LOGO);
    }

    /**
     * Set Seller Logo
     *
     * @param string $sellerLogo
     * @return $this
     */
    public function setSellerLogo($sellerLogo)
    {
        return $this->setData(self::SELLER_LOGO, $sellerLogo);
    }
    /**
     * Get Logo
     *
     * @return string
     */
    public function getLogo()
    {
        return $this->getData(self::LOGO);
    }

    /**
     * Set Logo
     *
     * @param string $logo
     * @return $this
     */
    public function setLogo($logo)
    {
        return $this->setData(self::LOGO, $logo);
    }

    /**
     * Get Store Name
     *
     * @return string
     */
    public function getStoreName()
    {
        return $this->getData(self::STORE_NAME);
    }

    /**
     * Set Store Name
     *
     * @param string $name
     * @return $this
     */
    public function setStoreName($name)
    {
        return $this->setData(self::STORE_NAME, $name);
    }

    /**
     * Get Store Detail
     *
     * @return string
     */
    public function getStoreDetail()
    {
        return $this->getData(self::STORE_DETAIL);
    }

    /**
     * Set Store Detail
     *
     * @param string $detail
     * @return $this
     */
    public function setStoreDetail($detail)
    {
        return $this->setData(self::STORE_DETAIL, $detail);
    }
         /**
     * Get Store Phone
     *
     * @return string
     */
    public function getStorePhone()
    {
        return $this->getData(self::STORE_PHONE);
    }

    /**
     * Set Store Phone
     *
     * @param string $phone
     * @return $this
     */
    public function setStorePhone($phone)
    {
        return $this->setData(self::STORE_PHONE, $phone);
    }
      /**
     * Get Store hours
     *
     * @return string
     */
    public function getStoreHours()
    {
        return $this->getData(self::STORE_HOURS);
    }

    /**
     * Set Store hours
     *
     * @param string $hours
     * @return $this
     */
    public function setStoreHours($hours)
    {
        return $this->setData(self::STORE_HOURS, $hours);
    }
       /**
     * Get cover image 
     *
     * @return string
     */
    public function getCoverImage()
    {
        return $this->getData(self::COVER_IMAGE);
    }

    /**
     * Set cover image 
     *
     * @param string $image
     * @return $this
     */
    public function setCoverImage($image)
    {
        return $this->setData(self::COVER_IMAGE, $image);
    }
}
