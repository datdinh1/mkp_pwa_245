<?php 
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\OtpSms\Model\Data;

use Wiki\OtpSms\Api\Data\CustomerOtpInterface;
use Magento\Framework\Api\AbstractExtensibleObject;

class CustomerOtp extends AbstractExtensibleObject implements CustomerOtpInterface
{
    /**
     * @inheritdoc
     */
    public function getMobile()
    {
        return $this->_get(self::MOBILE);
    }

    /**
     * @inheritdoc
     */
    public function setMobile($mobile)
    {
        return $this->setData(self::MOBILE, $mobile);
    }
    
    /**
     * @inheritdoc
     */
    public function getPassword()
    {
        return $this->_get(self::PASSWORD);
    }

    /**
     * @inheritdoc
     */
    public function setPassword($password)
    {
        return $this->setData(self::PASSWORD, $password);
    }

     /**
     * @inheritdoc
     */
    public function getFirstName()
    {
        return $this->_get(self::FIRST_NAME);
    }

    /**
     * @inheritdoc
     */
    public function setFirstName($password)
    {
        return $this->setData(self::FIRST_NAME, $password);
    }

     /**
     * @inheritdoc
     */
    public function getLastName()
    {
        return $this->_get(self::LAST_NAME);
    }

    /**
     * @inheritdoc
     */
    public function setLastName($password)
    {
        return $this->setData(self::LAST_NAME, $password);
    }
}
