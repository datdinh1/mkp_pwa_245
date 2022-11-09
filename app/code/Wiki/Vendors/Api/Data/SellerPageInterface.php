<?php

namespace Wiki\Vendors\Api\Data;

/**
 * Interface CommentInterface
 * @package Mageplaza\Blog\Api\Data
 */
interface SellerPageInterface
{
    /**
     * Constants used as data array keys
     */
    const BANNER         = 'banner';
    const ABOUT_ME    = 'about_me';
    const REFUND_POLICY           = 'refund_policy';
    const SHIPPING_POLICY     = 'shipping_policy';
    const URL_WEBSITE   = 'url_website';
    const URL_FACEBOOK    = 'url_facebook';
    const URL_TWITTER    = 'url_twitter';
    const URL_INSTAGRAM   = 'url_instagram';
    const URL_GOOGLE_PLUS    = 'url_google_plus';
    const URL_YOUTUBE    = 'url_youtube';
    const URL_PINTEREST   = 'url_pinterest';
    const URL_VIMEO   = 'url_vimeo';

    /**
     * Get Banner
     *
     * @return \Wiki\Vendors\Api\Data\BannerInterface[]
     */
    public function getBanners();

    /**
     * Set Banner
     *
     * @param \Wiki\Vendors\Api\Data\BannerInterface[] $banner
     *
     * @return $this
     */
    public function setBanners($banner);

    /**
     * Get About me 
     *
     * @return string
     */
    public function getAboutMe();

    /**
     * Set About me
     *
     * @param string $aboutMe
     *
     * @return $this
     */
    public function setAboutMe($aboutMe);

    /**
     * Get  Refund Policy 
     *
     * @return string
     */
    public function getRefundPolicy();

    /**
     * Set Refund Policy
     *
     * @param string $refundPolicy
     *
     * @return $this
     */
    public function setRefundPolicy($refundPolicy);

    /**
     * Get  shipping Policy
     *
     * @return string
     */
    public function getShippingPolicy();

    /**
     * Set shipping Policy
     *
     * @param string $ship
     *
     * @return $this
     */
    public function setShippingPolicy($ship);

    /**
     * Get  url website
     *
     * @return string
     */
    public function getUrlWebsite();

    /**
     * Set url website
     *
     * @param string $web
     *
     * @return $this
     */
    public function setUrlWebsite($web);

    /**
     * Get   url facebook
     *
     * @return string
     */
    public function getUrlFacebook();

    /**
     * Set url facebook
     *
     * @param string $facebook
     *
     * @return $this
     */
    public function setUrlFacebook($facebook);

    /**
     * Get url twitter
     *
     * @return string
     */
    public function getUrlTwitter();

    /**
     * Set url twitter
     *
     * @param string $twitter
     *
     * @return $this
     */
    public function setUrlTwitter($twitter);

    /**
     * Get url instagram
     *
     * @return string
     */
    public function getUrlInstagram();

    /**
     * Set url instagram
     *
     * @param string $instagram
     *
     * @return $this
     */
    public function setUrlInstagram($instagram);

    /**
     * Get url google plus
     *
     * @return string
     */
    public function getUrlGooglePlus();

    /**
     * Set url google plus
     *
     * @param string $google
     *
     * @return $this
     */
    public function setUrlGooglePlus($google);

    /**
     * Get url youtube
     *
     * @return string
     */
    public function getUrlYoutube();

    /**
     * Set url youtubeSellerPageInterface
     * @param string $youtube
     *
     * @return $this
     */
    public function setUrlYoutube($youtube);

    /**
     * Get url pinterest
     *
     * @return string
     */
    public function getUrlPinterest();

    /**
     * Set url pinterest
     *
     * @param string $pinterest
     *
     * @return $this
     */
    public function setUrlPinterest($pinterest);

    /**
     * Get url vimeo
     *
     * @return string
     */
    public function getUrlVimeo();

    /**
     * Set url vimeo
     *
     * @param string $vimeo
     *
     * @return $this
     */
    public function setUrlVimeo($vimeo);
}
