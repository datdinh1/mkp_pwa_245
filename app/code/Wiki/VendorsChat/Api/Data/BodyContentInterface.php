<?php

namespace Wiki\Vendorschat\Api\Data;

/**
 * Interface CommentInterface
 * @package Mageplaza\Blog\Api\Data
 */
interface BodyContentInterface
{
    /**
     * Constants used as data array keys
     */
    const MESSAGE         = 'message';
    const IMAGE           = 'image';

    /**
     * Get Message
     *
     * @return string
     */
    public function getMessage();

    /**
     * Set Content
     *
     * @param string $mess
     *
     * @return $this
     */
    public function setMessage($mess);

    /**
     * Get Seller
     *
     * @return string[]
     */
    public function getImages();

    /**
     * Set Seller
     *
     * @param string[] $image
     *
     * @return $this
     */
    public function setImages($image);

}
