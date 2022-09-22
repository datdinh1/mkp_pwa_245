<?php

namespace Wiki\VendorsReport\Api\Data;

interface ReportStoreDataInterface
{
    /**
     * Constants used as data array keys
     */
    const DATE = 'date';
    const TOTAL = 'total';

    /**
     * Get Date
     *
     * @return string
     */
    public function getDate();

    /**
     * Set Date
     *
     * @param string $date
     *
     * @return $this
     */
    public function setDate($date);

    /**
     * Get Total
     *
     * @return int
     */
    public function getTotal();

    /**
     * Set Total
     *
     * @param int $total
     *
     * @return $this
     */
    public function setTotal($total);
}
