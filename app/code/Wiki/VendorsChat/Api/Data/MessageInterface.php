<?php

namespace Wiki\Vendorschat\Api\Data;

interface MessageInterface
{
    /**
     * Constants used as data array keys
     */
    const MSG_ID              = 'action_id';
    const ROOM_ID             = 'chat_id';
    const MESSAGE             = 'message';
    const IMAGE               = 'image';
    const SENDER_ID           = 'sender_id';
    const SENDER_TYPE         = 'sender_type';
    const CREATED_AT          = 'created_at';
    const FROM_SYSTEM         = 'from_system';

    /**
     * Get Message Id
     *
     * @return int
     */
    public function getMessageId();

    /**
     * Set Message Id
     *
     * @param int $mgsId
     *
     * @return $this
     */
    public function setMessageId($mgsId);

    /**
     * Get Room Id
     *
     * @return int
     */
    public function getRoomId();

    /**
     * Set Room Id
     *
     * @param int $roomId
     *
     * @return $this
     */
    public function setRoomId($roomId);

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
     * @return string
     */
    public function getImage();

    /**
     * Set Seller
     *
     * @param string $image
     *
     * @return $this
     */
    public function setImage($image);

    /**
     * Get Sender Id
     *
     * @return string
     */
    public function getSenderId();

    /**
     * Set  Sender Id
     *
     * @param string $id
     *
     * @return $this
     */
    public function setSenderId($id);

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
