<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Wiki\Vendors\Model\Api;

/**
 * Softprodigy Dailydeal date model
 */
class AccountEmail extends \Magento\Framework\Model\AbstractModel implements \Wiki\Vendors\Api\Data\AccountEmailInterface
{
    /**
     * Get Email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->getData(self::EMAIL);
    }

    /**
     * Set Email
     *
     * @param string $email
     * @return $this
     */
    public function setEmail($email)
    {
        return $this->setData(self::EMAIL, $email);
    }

    /**
     * Get First Name
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->getData(self::FIRST_NAME);
    }

    /**
     * Set First Name
     *
     * @param string $name
     * @return $this
     */
    public function setFirstName($name)
    {
        return $this->setData(self::FIRST_NAME, $name);
    }

        /**
     * Get Last Name
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->getData(self::LAST_NAME);
    }

    /**
     * Set Last Name
     *
     * @param string $name
     * @return $this
     */
    public function setLastName($name)
    {
        return $this->setData(self::LAST_NAME, $name);
    }

            /**
     * Get Password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->getData(self::PASSWORD);
    }

    /**
     * Set Password
     *
     * @param string $pass
     * @return $this
     */
    public function setPassword($pass)
    {
        return $this->setData(self::PASSWORD, $pass);
    }
}
