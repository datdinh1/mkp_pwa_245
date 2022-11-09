<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Wiki\VendorsProduct\Model\Api\Data;

/**
 * Seller Data model
 */
class SellerData extends \Magento\Framework\Model\AbstractModel implements \Wiki\VendorsProduct\Api\Data\SellerInterface
{
    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getData(self::ID);
    }

    /**
     * @inheritdoc
     */
    public function setId($id)
    {
        return $this->setData(self::ID, $id);
    }

    /**
     * @inheritdoc
     */
    public function getVendorId()
    {
        return $this->getData(self::VENDOR_ID);
    }

    /**
     * @inheritdoc
     */
    public function setVendorId($vendorId)
    {
        return $this->setData(self::VENDOR_ID, $vendorId);
    }

    /**
     * @inheritdoc
     */
    public function getGroupId()
    {
        return $this->getData(self::GROUP_ID);
    }

    /**
     * @inheritdoc
     */
    public function setGroupId($groupId)
    {
        return $this->setData(self::GROUP_ID, $groupId);
    }

    /**
     * @inheritdoc
     */
    public function getStatus()
    {
        return $this->getData(self::STATUS);
    }

    /**
     * @inheritdoc
     */
    public function setStatus($status)
    {
        return $this->setData(self::STATUS, $status);
    }

    /**
     * @inheritdoc
     */
    public function getTelephone()
    {
        return $this->getData(self::TELEPHONE);
    }

    /**
     * @inheritdoc
     */
    public function setTelephone($telephone)
    {
        return $this->setData(self::TELEPHONE, $telephone);
    }

    /**
     * @inheritdoc
     */
    public function getGroupName()
    {
        return $this->getData(self::GROUP_NAME);
    }

    /**
     * @inheritdoc
     */
    public function setGroupName($groupName)
    {
        return $this->setData(self::GROUP_NAME, $groupName);
    }

    /**
     * @inheritdoc
     */
    public function getStoreName()
    {
        return $this->getData(self::STORE_NAME);
    }

    /**
     * @inheritdoc
     */
    public function setStoreName($storeName)
    {
        return $this->setData(self::STORE_NAME, $storeName);
    }

    /**
     * @inheritdoc
     */
    public function getLogo()
    {
        return $this->getData(self::LOGO);
    }

    /**
     * @inheritdoc
     */
    public function setLogo($logo)
    {
        return $this->setData(self::LOGO, $logo);
    }

    /**
     * @inheritdoc
     */
    public function getCreatedAt()
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * @inheritdoc
     */
    public function setCreatedAt($createdAt)
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }
}
