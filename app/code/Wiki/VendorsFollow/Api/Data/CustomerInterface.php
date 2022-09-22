<?php
namespace Wiki\VendorsFollow\Api\Data;

/**
 * @api
 */
interface CustomerInterface
{
    const CUSTOMER_ID           = 'customer_id';
    const FIRSTNAME             = 'firstname';
    const LASTNAME              = 'lastname';
    const AVATAR                = 'avatar';

    /**
     * Get Customer Id
     *
     * @return string
     */
    public function getCustomerId();

    /**
     * Set Customer Id
     *
     * @param $customerId
     * @return $this
     */
    public function setCustomerId($customerId);

    /**
     * Get First Name
     *
     * @return string
     */
    public function getFirstName();

    /**
     * Set First Name
     *
     * @param $firstname
     * @return $this
     */
    public function setFirstName($firstname);

    /**
     * Get Last Name
     *
     * @return string
     */
    public function getLastName();

    /**
     * Set Last Name
     *
     * @param $lastname
     * @return $this
     */
    public function setLastName($lastname);

    /**
     * Get Avatar
     *
     * @return string
     */
    public function getAvatar();

    /**
     * Set Avatar
     *
     * @param $avatar
     * @return $this
     */
    public function setAvatar($avatar);
}