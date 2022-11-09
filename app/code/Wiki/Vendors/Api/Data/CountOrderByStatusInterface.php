<?php

namespace Wiki\Vendors\Api\Data;

interface CountOrderByStatusInterface
{
    /**
     * Constants used as data array keys
     */
    const WK_STATUS        = 'wk_status';
    const COUNT       = 'count';

    /**
     * Get Wiki Status
     *
     * @return string
     */
    public function getWkStatus();

    /**
     * Set Wiki Status
     *
     * @param string $status
     *
     * @return $this
     */
    public function setWkStatus($status);

    /**
     * Get Count Orders
     *
     * @return int
     */
    public function getCount();

    /**
     * Set Count Orders
     *
     * @param int $number
     *
     * @return $this
     */
    public function setCount($number);

}
