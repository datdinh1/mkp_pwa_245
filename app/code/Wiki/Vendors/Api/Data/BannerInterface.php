<?php

namespace Wiki\Vendors\Api\Data;

interface BannerInterface
{
    const IMAGE     = 'image';
    const URL       = 'url';
    const ID        = 'id';
    /**
     * Get Image
     *
     * @return  string
     */
    public function getImage();

    /**
     * Set Image
     *
     * @param  string $image
     *
     * @return $this
     */
    public function setImage($image);

    /**
     * Get URL
     *
     * @return string
     */
    public function getUrl();

    /**
     * Set URL
     *
     * @param string $url
     *
     * @return $this
     */
    public function setUrl($url);

        /**
     * Get Id
     *
     * @return string
     */
    public function getId();

    /**
     * Set Id
     *
     * @param string $url
     *
     * @return $this
     */
    public function setId($id);
}
