<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Wiki\Vendors\Model\Api;

/**
 * Softprodigy Dailydeal date model
 */
class Customer extends \Magento\Framework\Model\AbstractModel implements \Wiki\Vendors\Api\Data\CustomerInterface
{
    /**
     * Get gender
     *
     * @return boolean
     */
    public function getGender()
    {
        return $this->getData(self::GENDER);
    }

    /**
     * Set gender
     *
     * @param boolean $gender
     * @return $this
     */
    public function setGender($gender)
    {
        return $this->setData(self::GENDER, $gender);
    }

    /**
     * Get dob
     *
     * @return string
     */
    public function getDob()
    {
        return $this->getData(self::DOB);
    }

    /**
     * Set dob
     *
     * @param string $dob
     * @return $this
     */
    public function setDob($dob)
    {
        return $this->setData(self::DOB, $dob);
    }
}
