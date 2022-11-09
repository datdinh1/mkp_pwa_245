<?php

namespace Wiki\Vendors\Api\Data;

/**
 * Interface CommentInterface
 * @package Mageplaza\Blog\Api\Data
 */
interface AccountEmailInterface
{
    /**
     * Constants used as data array keys
     */
    const EMAIL            = 'email';
    const FIRST_NAME       = 'first_name';
    const LAST_NAME        = 'last_name';
    const PASSWORD         = 'password';



    /**
     * Get Email
     *
     * @return string
     */
    public function getEmail();

    /**
     * Set Email
     *
     * @param string $email
     *
     * @return $this
     */
    public function setEmail($email);

    /**
     * Get First Name
     *
     * @return string
     */
    public function getFirstName();

    /**
     * Set First Name
     *
     * @param string $name
     *
     * @return $this
     */
    public function setFirstName($name);

    /**
     * Get Last Name
     *
     * @return string
     */
    public function getLastName();

    /**
     * Set Last Name
     *
     * @param string $name
     *
     * @return $this
     */
    public function setLastName($name);

    /**
     * Get Password
     *
     * @return string
     */
    public function getPassword();

    /**
     * Set Password
     *
     * @param string $pass
     *
     * @return $this
     */
    public function setPassword($pass);
}
