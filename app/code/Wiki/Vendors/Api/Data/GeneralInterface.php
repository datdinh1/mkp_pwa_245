<?php

namespace Wiki\Vendors\Api\Data;

/**
 * Interface CommentInterface
 * @package Mageplaza\Blog\Api\Data
 */
interface GeneralInterface
{
    /**
     * Constants used as data array keys
     */
    const FALCON         = 'falcon';
    const SELLER_LOGO    = 'seller_logo';
    const LOGO           = 'logo';
    const STORE_NAME     = 'store_name';
    const STORE_DETAIL   = 'store_detail';
    const STORE_PHONE    = 'store_phone';
    const STORE_HOURS    = 'store_hours';
    const COVER_IMAGE    = 'cover_image';

    /**
     * Get falcon
     *
     * @return string
     */
    public function getFalcon();

    /**
     * Set falcon
     *
     * @param string $falcon
     *
     * @return $this
     */
    public function setFalcon($falcon);

    /**
     * Get seller logo 
     *
     * @return string
     */
    public function getSellerLogo();

    /**
     * Set seller logo 
     *
     * @param string $sellerLogo
     *
     * @return $this
     */
    public function setSellerLogo($sellerLogo);

    /**
     * Get  logo 
     *
     * @return string
     */
    public function getLogo();

    /**
     * Set seller logo 
     *
     * @param string $sellerLogo
     *
     * @return $this
     */
    public function setLogo($sellerLogo);

    /**
     * Get  strore name 
     *
     * @return string
     */
    public function getStoreName();

    /**
     * Set strore name
     *
     * @param string $storeName
     *
     * @return $this
     */
    public function setStoreName($storeName);

    /**
     * Get  strore detail 
     *
     * @return string
     */
    public function getStoreDetail();

    /**
     * Set strore detail
     *
     * @param string $storeDetail
     *
     * @return $this
     */
    public function setStoreDetail($storeDetail);

    /**
     * Get  strore phone 
     *
     * @return string
     */
    public function getStorePhone();

    /**
     * Set strore phone
     *
     * @param string $storePhone
     *
     * @return $this
     */
    public function setStorePhone($storePhone);

    /**
     * Get  strore hours 
     *
     * @return string
     */
    public function getStoreHours();

    /**
     * Set strore hours
     *
     * @param string $storeHours
     *
     * @return $this
     */
    public function setStoreHours($storeHours);

    /**
     * Get cover image 
     *
     * @return string
     */
    public function getCoverImage();

    /**
     * Set cover image 
     *
     * @param string $coverImage
     *
     * @return $this
     */
    public function setCoverImage($coverImage);
}
