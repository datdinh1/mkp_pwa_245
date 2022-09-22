<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Wiki\Vendors\Model\Api;

/**
 * Softprodigy Dailydeal date model
 */
class SellerPage extends \Magento\Framework\Model\AbstractModel implements \Wiki\Vendors\Api\Data\SellerPageInterface
{
    /**
     * Get Banner
     *
     * @return \Wiki\Vendors\Api\Data\BannerInterface[]
     */
    public function getBanners()
    {
        return $this->getData(self::BANNER);
    }

    /**
     * Set Banner
     *
     * @param \Wiki\Vendors\Api\Data\BannerInterface[]  $banner
     * @return $this
     */
    public function setBanners($banner)
    {
        return $this->setData(self::BANNER, $banner);
    }

    /**
     * Get About me 
     *
     * @return string
     */
    public function getAboutMe()
    {
        return $this->getData(self::ABOUT_ME);
    }

    /**
     * Set About me 
     *
     * @param string $aboutMe
     * @return $this
     */
    public function setAboutMe($aboutMe)
    {
        return $this->setData(self::ABOUT_ME, $aboutMe);
    }
    /**
     * Get Refund Policy 
     *
     * @return string
     */
    public function getRefundPolicy()
    {
        return $this->getData(self::REFUND_POLICY);
    }

    /**
     * Set Refund Policy 
     *
     * @param string $refundPolicy
     * @return $this
     */
    public function setRefundPolicy($refundPolicy)
    {
        return $this->setData(self::REFUND_POLICY, $refundPolicy);
    }

    /**
     * Get shipping Policy
     *
     * @return string
     */
    public function getShippingPolicy()
    {
        return $this->getData(self::SHIPPING_POLICY);
    }

    /**
     * Set shipping Policy
     *
     * @param string $ship
     * @return $this
     */
    public function setShippingPolicy($ship)
    {
        return $this->setData(self::SHIPPING_POLICY, $ship);
    }

    /**
     * Get shipping Policy
     *
     * @return string
     */
    public function getUrlWebsite()
    {
        return $this->getData(self::URL_WEBSITE);
    }

    /**
     * Set shipping Policy
     *
     * @param string $web
     * @return $this
     */
    public function setUrlWebsite($web)
    {
        return $this->setData(self::URL_WEBSITE, $web);
    }
    /**
     * Get  url facebook
     *
     * @return string
     */
    public function getUrlFacebook()
    {
        return $this->getData(self::URL_FACEBOOK);
    }

    /**
     * Set  url facebook
     *
     * @param string $facebook
     * @return $this
     */
    public function setUrlFacebook($facebook)
    {
        return $this->setData(self::URL_FACEBOOK, $facebook);
    }
    /**
     * Get url twitter
     *
     * @return string
     */
    public function getUrlTwitter()
    {
        return $this->getData(self::URL_TWITTER);
    }

    /**
     * Set url twitter
     *
     * @param string $twitter
     * @return $this
     */
    public function setUrlTwitter($twitter)
    {
        return $this->setData(self::URL_TWITTER, $twitter);
    }

    /**
     * Get url instagram
     *
     * @return string
     */
    public function getUrlInstagram()
    {
        return $this->getData(self::URL_INSTAGRAM);
    }

    /**
     * Set url instagram
     *
     * @param string $hours
     * @return $this
     */
    public function setUrlInstagram($instagram)
    {
        return $this->setData(self::URL_INSTAGRAM, $instagram);
    }

    /**
     * Get url google plus
     *
     * @return string
     */
    public function getUrlGooglePlus()
    {
        return $this->getData(self::URL_GOOGLE_PLUS);
    }

    /**
     * Set url google plus
     *
     * @param string $google
     * @return $this
     */
    public function setUrlGooglePlus($google)
    {
        return $this->setData(self::URL_GOOGLE_PLUS, $google);
    }

    /**
     * Get url youtube
     *
     * @return string
     */
    public function getUrlYoutube()
    {
        return $this->getData(self::URL_YOUTUBE);
    }

    /**
     * Set url youtube
     *
     * @param string $youtube
     * @return $this
     */
    public function setUrlYoutube($youtube)
    {
        return $this->setData(self::URL_YOUTUBE, $youtube);
    }

    /**
     * Get url pinterest
     *
     * @return string
     */
    public function getUrlPinterest()
    {
        return $this->getData(self::URL_PINTEREST);
    }

    /**
     * Set url pinterest
     *
     * @param string $pinterest
     * @return $this
     */
    public function setUrlPinterest($pinterest)
    {
        return $this->setData(self::URL_PINTEREST, $pinterest);
    }

    /**
     * Get url     vimeo 

     *
     * @return string
     */
    public function getUrlVimeo()
    {
        return $this->getData(self::URL_VIMEO);
    }

    /**
     * Set url vimeo
     *
     * @param string $vimeo
     * @return $this
     */
    public function setUrlVimeo($vimeo)
    {
        return $this->setData(self::URL_VIMEO, $vimeo);
    }
}
