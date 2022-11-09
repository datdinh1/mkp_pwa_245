<?php

namespace Wiki\VendorsSalesRule\Api\Data;
interface CollectInterface
{
    /**
     * Constants used as data array keys
     */

    const CODE       = 'code';
    const CUSTOMER_ID    = 'customer_id';

    /**
     * Get Coupon Code 
     *
     * @return string
     */
    public function getId();

    /**
     * Set Coupon Code
     *
     * @param string $id
     *
     * @return $this
     */
    public function setId($id);

    /**
     * Get customer id
     *
     * @return int
     */
    public function getCustomerId();

    /**
     * Set customer Id
     *
     * @param int $customer_id
     *
     * @return $this
     */
    public function setCustomerId($customer_id);
}
