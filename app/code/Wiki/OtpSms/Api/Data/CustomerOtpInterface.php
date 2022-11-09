<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Wiki\OtpSms\Api\Data;

interface CustomerOtpInterface
{
    /**#@+
     * Constants for keys of data array.
     */
    const MOBILE                = 'mobile';
    const FIRST_NAME            = 'first_name';
    const LAST_NAME             = 'last_name';
    const PASSWORD              = 'password';

    /**#@-*/

    /**
     * Get Mobile Phone
     * @return string|null
     */
    public function getMobile();

    /**
     * Set Mobile Phone
     * @param string|null $mobile
     * @return $this
     */
    public function setMobile($mobile);

    /**
     * Get Password
     * @return string
     */
    public function getPassword();

    /**
     * Set Password
     * @param string $password
     * @return $this
     */
    public function setPassword($password);

    /**
     * Get First Name
     * @return string
     */
    public function getFirstName();

    /**
     * Set First Name
     * @param string $name
     * @return $this
     */
    public function setFirstName($name);

    /**
     * Get Last Name
     * @return string
     */
    public function getLastName();

    /**
     * Set Last Name
     * @param string $name
     * @return $this
     */
    public function setLastName($name);
}
