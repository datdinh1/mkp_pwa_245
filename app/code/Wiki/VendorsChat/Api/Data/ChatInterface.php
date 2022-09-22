<?php

namespace Wiki\Vendorschat\Api\Data;

/**
 * Interface CommentInterface
 * @package Mageplaza\Blog\Api\Data
 */
interface ChatInterface
{
    /**
     * Constants used as data array keys
     */
    const VENDOR_ID             = 'vendor_id';
    const CUSTOMER_ID           = 'customer_id';
    const MESSAGE               = 'message';
    const IMAGES                = 'images';
    const SENDER_TYPE           = 'sender_type';
    const FROM_SYSTEM           = 'from_system';


    
    /**
     * Get Vendor id
     *
     * @return string
     */
    public function getVendorId();

    /**
     * Set Vendor id
     *
     * @param string $id
     *
     * @return $this
     */
    public function setVendorId($id);

    /**
     * Get Visitor id
     *
     * @return int
     */
    public function getCustomerId();

    /**
     * Set Visitor id
     *
     * @param int $id
     *
     * @return $this
     */
    public function setCustomerId($id);

    /**
     * Get Message
     *
     * @return string|null
     */
    public function getMessage();

    /**
     * Set Message
     *
     * @param string|null $message
     *
     * @return $this
     */
    public function setMessage($message);

    /**
     * Get Images
     *
     * @return string[]|null
     */
    public function getImages();

    /**
     * Set Images
     *
     * @param string[]|null $images
     *
     * @return $this
     */
    public function setImages($images);

    /**
     * Get Sender type
     *
     * @return string
     */
    public function getSenderType();

    /**
     * Set  Sender type
     *
     * @param string $type
     *
     * @return $this
     */
    public function setSenderType($type);

    /**
     * Get From System
     *
     * @return boolean
     */
    public function getFromSystem();

    /**
     * Set From System
     *
     * @param boolean $type
     *
     * @return $this
     */
    public function setFromSystem($type);
}
