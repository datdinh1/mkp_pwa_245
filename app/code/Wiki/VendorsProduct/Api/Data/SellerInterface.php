<?php

namespace Wiki\VendorsProduct\Api\Data;


interface SellerInterface
{
    /**
     * Constants used as data array keys
     */
    const ID                    = 'entity_id';
    const VENDOR_ID             = 'vendor_id';
    const GROUP_ID              = 'group_id';
    const STATUS                = 'status';
    const TELEPHONE             = 'telephone';
    const GROUP_NAME            = 'group_name';
    const STORE_NAME            = 'store_name';
    const LOGO                  = 'logo';
    const CREATED_AT            = 'created_at';

    /**
     * Get Id
     *
     * @return int
     */
    public function getId();

    /**
     * Set Id
     *
     * @param int $id
     *
     * @return $this
     */
    public function setId($id);

    /**
     * Get Seller Id
     *
     * @return string
     */
    public function getVendorId();

    /**
     * Set Seller Id
     *
     * @param string $vendorId
     *
     * @return $this
     */
    public function setVendorId($vendorId);

    /**
     * Get Group Id
     *
     * @return int
     */
    public function getGroupId();

    /**
     * Set Group Id
     *
     * @param int $groupId
     *
     * @return $this
     */
    public function setGroupId($groupId);

    /**
     * Get Status
     *
     * @return int
     */
    public function getStatus();

    /**
     * Set Status
     *
     * @param int $status
     *
     * @return $this
     */
    public function setStatus($status);

    /**
     * Get Status
     *
     * @return string
     */
    public function getTelephone();

    /**
     * Set Status
     *
     * @param string|null $status
     *
     * @return $this
     */
    public function setTelephone($telephone);
    
    /**
     * Get Group Name
     *
     * @return string|null
     */
    public function getGroupName();

    /**
     * Set Group Name
     *
     * @param string|null $groupName
     *
     * @return $this
     */
    public function setGroupName($groupName);

    /**
     * Get Store Name
     *
     * @return string|null
     */
    public function getStoreName();

    /**
     * Set Store Name
     *
     * @param string|null $storeName
     *
     * @return $this
     */
    public function setStoreName($storeName);

    /**
     * Get Logo Seller
     *
     * @return string|null
     */
    public function getLogo();

    /**
     * Set Logo Seller
     *
     * @param string|null $logo
     *
     * @return $this
     */
    public function setLogo($logo);

    /**
     * Get Created At
     *
     * @return string
     */
    public function getCreatedAt();

    /**
     * Set Created At
     *
     * @param string|null $createdAt
     *
     * @return $this
     */
    public function setCreatedAt($createdAt);
}
