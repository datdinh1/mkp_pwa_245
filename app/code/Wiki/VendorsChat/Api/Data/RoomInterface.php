<?php

namespace Wiki\Vendorschat\Api\Data;

/**
 * Interface CommentInterface
 * @package Mageplaza\Blog\Api\Data
 */
interface RoomInterface
{
    /**
     * Constants used as data array keys
     */
    const ROOM_ID             = 'chat_id';
    const CUSTOMER_ID         = 'customer_id';
    const VENDOR_ID           = 'vendor_id';
    const IS_READ             = 'is_read';
    const CREATED_AT          = 'created_at';
    const UPDATED_AT          = 'updated_at';

    /**
     * Get Chat Id
     *
     * @return int
     */
    public function getRoomId();

    /**
     * Set Chat Id
     *
     * @param int $id
     *
     * @return $this
     */
    public function setRoomId($id);


    /**
     * Get Customer Id
     *
     * @return int
     */
    public function getCustomerId();

    /**
     * Set Customer Id
     *
     * @param int $id
     *
     * @return $this
     */
    public function setCustomerId($id);

    /**
     * Get Vendor Id
     *
     * @return string
     */
    public function getVendorId();

    /**
     * Set Vendor Id
     *
     * @param string $id
     *
     * @return $this
     */
    public function setVendorId($id);

    /**
     * Get Is Read
     *
     * @return bool
     */
    public function getIsRead();

    /**
     * Set Is Read
     *
     * @param bool $isRead
     *
     * @return $this
     */
    public function setIsRead($isRead);

    /**
     * Get Created At
     *
     * @return string
     */
    public function getCreatedAt();

    /**
     * Set Created At
     *
     * @param string $date
     *
     * @return $this
     */
    public function setCreatedAt($date);


    /**
     * Get Update At
     *
     * @return string
     */
    public function getUpdatedAt();

    /**
     * Set Update At
     *
     * @param string $date
     *
     * @return $this
     */
    public function setUpdatedAt($date);
}
