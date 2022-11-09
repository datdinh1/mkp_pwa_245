<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Wiki\Vendors\Model\Api;

/**
 * Softprodigy Dailydeal date model
 */
class CountOrderByStatus extends \Magento\Framework\Model\AbstractModel implements \Wiki\Vendors\Api\Data\CountOrderByStatusInterface
{
    /**
     * Get Wiki Status
     *
     * @return string
     */
    public function getWkStatus()
    {
        return $this->getData(self::WK_STATUS);
    }

    /**
     * Set Wiki Status
     *
     * @param string $status
     * @return $this
     */
    public function setWkStatus($status)
    {
        return $this->setData(self::WK_STATUS, $status);
    }

    /**
     * Get Count Orders
     *
     * @return int
     */
    public function getCount()
    {
        return $this->getData(self::COUNT);
    }

    /**
     * Set Count Orders
     *
     * @param int $number
     * @return $this
     */
    public function setCount($number)
    {
        return $this->setData(self::COUNT, $number);
    }
}
