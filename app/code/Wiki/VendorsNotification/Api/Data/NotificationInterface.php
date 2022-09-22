<?php

namespace Wiki\VendorsNotification\Api\Data;

interface NotificationInterface
{
    const NOTIFICATIONID            = 'notification_id';
    const VENDORID                  = 'vendor_id';
    const TYPE                      = 'type';
    const MESSAGE                   = 'message';
    const ADDITIONALINFO            = 'additional_info';
    const ISREAD                    = 'is_read';
    const ISREACHED                 = 'is_reached';
    const ISHIDDEN                  = 'is_hidden';
    const CREATEDAT                 = 'created_at';
    const CUSTOMERID                = 'customer_id';
    const NOTIAMINID                = 'noti_admin_id';
    const CONTENT                   = 'content';

    /**#@-*/

    /**
     * Get Notification Id.
     *
     * @return int
     */
    public function getNotificationId();

    /**
     * Set Notification Id.
     *
     * @param int $notificationId
     *
     * @return $this
     */
    public function setNotificationId($notificationId);

    /**
     * Get Vendor Id.
     *
     * @return int
     */
    public function getVendorId();

    /**
     * Set Vendor Id.
     *
     * @param int $vendorId
     *
     * @return $this
     */
    public function setVendorId($vendorId);

    /**
     * Get Type.
     *
     * @return string|null
     */
    public function getType();

    /**
     * Set Type.
     *
     * @param string|null $type
     *
     * @return $this
     */
    public function setType($type);

    /**
     * Get Message.
     *
     * @return string|null
     */
    public function getMessage();

    /**
     * Set Message.
     *
     * @param string|null $message
     *
     * @return $this
     */
    public function setMessage($message);

    /**
     * Get Additional Info.
     *
     * @return string|null
     */
    public function getAdditionalInfo();

    /**
     * Set Additional Info.
     *
     * @param string|null $additionalInfo
     *
     * @return $this
     */
    public function setAdditionalInfo($additionalInfo);

    /**
     * Get Is Read.
     *
     * @return int
     */
    public function getIsRead();

    /**
     * Set Is Read.
     *
     * @param int $isRead
     *
     * @return $this
     */
    public function setIsRead($isRead);

    /**
     * Get Is Reached.
     *
     * @return int
     */
    public function getIsReached();

    /**
     * Set Is Reached.
     *
     * @param int $isReached
     *
     * @return $this
     */
    public function setIsReached($isReached);

    /**
     * Get Is Hidden.
     *
     * @return int
     */
    public function getIsHidden();

    /**
     * Set Is Hidden.
     *
     * @param int $isHidden
     *
     * @return $this
     */
    public function setIsHidden($isHidden);

    /**
     * Get Created At.
     *
     * @return string
     */
    public function getCreatedAt();

    /**
     * Set Created At.
     *
     * @param string $createdAt
     *
     * @return $this
     */
    public function setCreatedAt($createdAt);

    /**
     * Get Customer Id.
     *
     * @return int
     */
    public function getCustomerId();

    /**
     * Set Customer Id.
     *
     * @param int $customerId
     *
     * @return $this
     */
    public function setCustomerId($customerId);

    /**
     * Get Notification Admin Id.
     *
     * @return int
     */
    public function getNotiAdminId();

    /**
     * Set Notification Admin Id.
     *
     * @param int $notiAdminId
     *
     * @return $this
     */
    public function setNotiAdminId($notiAdminId);

    /**
     * Get Content.
     *
     * @return string|null
     */
    public function getContent();

    /**
     * Set Content.
     *
     * @param string|null $content
     *
     * @return $this
     */
    public function setContent($content);
}