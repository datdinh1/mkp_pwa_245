<?php

namespace Wiki\Vendors\Api\Data;

/**
 * Interface CommentInterface
 * @package Mageplaza\Blog\Api\Data
 */
interface CustomerInterface
{
    /**
     * Constants used as data array keys
     */
    const GENDER            = 'gender';
    const DOB           = 'dob';
    


    /**
     * Get gender
     *
     * @return boolean
     */
    public function getGender();

    /**
     * Set gender
     *
     * @param boolean $gender
     *
     * @return $this
     */
    public function setGender($gender);

    /**
     * Get dob
     *
     * @return string
     */
    public function getDob();

    /**
     * Set dob
     *
     * @param string $dob
     *
     * @return $this
     */
    public function setDob($dob);

    
}
