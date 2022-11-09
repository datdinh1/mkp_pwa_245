<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Wiki\VendorsReport\Model\Api\Data;

class ReportStoreData extends \Magento\Framework\Model\AbstractModel implements \Wiki\VendorsReport\Api\Data\ReportStoreDataInterface
{
     /**
     * Get Date
     *
     * @return string
     */
    public function getDate()
    {
        return $this->getData(self::DATE);
    }

    /**
     * Set Date
     *
     * @param string $date
     * @return $this
     */
    public function setDate($date)
    {
        return $this->setData(self::DATE, $date);
    }
    /**
     * Get Total
     *
     * @return int
     */
    public function getTotal()
    {
        return $this->getData(self::TOTAL);
    }

    /**
     * Set Total
     *
     * @param int $total
     * @return $this
     */
    public function setTotal($total)
    {
        return $this->setData(self::TOTAL, $total);
    }

}
