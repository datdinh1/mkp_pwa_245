<?php
namespace Wiki\VendorsFollow\Model\Api\Data;

use Magento\Framework\Model\AbstractModel;
use Wiki\VendorsFollow\Api\Data\CustomerInterface;

class CustomerData extends AbstractModel implements CustomerInterface
{

    /**
     * @inheritdoc
     */
    public function getCustomerId()
    {
        return $this->getData(self::CUSTOMER_ID);
    }

    /**
     * @inheritdoc
     */
    public function setCustomerId($customerId)
    {
        return $this->setData(self::CUSTOMER_ID, $customerId);
    }

    /**
     * @inheritdoc
     */
    public function getFirstName()
    {
        return $this->getData(self::FIRSTNAME);
    }

    /**
     * @inheritdoc
     */
    public function setFirstName($firstname)
    {
        return $this->setData(self::FIRSTNAME, $firstname);
    }

    /**
     * @inheritdoc
     */
    public function getLastName()
    {
        return $this->getData(self::LASTNAME);
    }

    /**
     * @inheritdoc
     */
    public function setLastName($lastname)
    {
        return $this->setData(self::LASTNAME, $lastname);
    }

    /**
     * @inheritdoc
     */
    public function getAvatar()
    {
        return $this->getData(self::AVATAR);
    }

    /**
     * @inheritdoc
     */
    public function setAvatar($avatar)
    {
        return $this->setData(self::AVATAR, $avatar);
    }
}