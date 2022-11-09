<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Wiki\VendorsReport\Model\Api\Data;

class ReportStore extends \Magento\Framework\Model\AbstractModel implements \Wiki\VendorsReport\Api\Data\ReportStoreInterface
{
    /**
     * Get Sales
     *
     * @return \Wiki\VendorsReport\Api\Data\ReportStoreDataInterface[]
     */
    public function getSales()
    {
        return $this->getData(self::SALES);
    }

    /**
     * Set Sales
     *
     * @param \Wiki\VendorsReport\Api\Data\ReportStoreDataInterface[] $sales
     * @return $this
     */
    public function setSales($sales)
    {
        return $this->setData(self::SALES, $sales);
    }

    /**
     * Get Order
     *
     * @return \Wiki\VendorsReport\Api\Data\ReportStoreDataInterface[]
     */
    public function getOrders()
    {
        return $this->getData(self::ORDERS);
    }

    /**
     * Set Order
     *
     * @param \Wiki\VendorsReport\Api\Data\ReportStoreDataInterface[] $orders
     * @return $this
     */
    public function setOrders($orders)
    {
        return $this->setData(self::ORDERS, $orders);
    }

    /**
     * Get Total Buyers
     *
     * @return \Wiki\VendorsReport\Api\Data\ReportStoreDataInterface[]
     */
    public function getTotalBuyers()
    {
        return $this->getData(self::TOTAL_BUYERS);
    }

    /**
     * Set Total Buyers
     * @param \Wiki\VendorsReport\Api\Data\ReportStoreDataInterface[] $customer
     * @return $this
     */
    public function setTotalBuyers($customer)
    {
        return $this->setData(self::TOTAL_BUYERS, $customer);
    }

    /**
     * Get New Buyers
     *
     * @return \Wiki\VendorsReport\Api\Data\ReportStoreDataInterface[]
     */
    public function getNewBuyers()
    {
        return $this->getData(self::NEW_BUYERS);
    }

    /**
     * Set New Buyers
     * @param \Wiki\VendorsReport\Api\Data\ReportStoreDataInterface[] $customer
     * @return $this
     */
    public function setNewBuyers($customer)
    {
        return $this->setData(self::NEW_BUYERS, $customer);
    }
}
