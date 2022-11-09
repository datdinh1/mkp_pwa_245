<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Wiki\Vendors\Model\Api;

/**
 * Softprodigy Dailydeal date model
 */
class OrdersSeller extends \Magento\Framework\Model\AbstractModel implements \Wiki\Vendors\Api\Data\OrdersSellerInterface
{
    /**
     * Get Items
     *
     * @return \Magento\Sales\Api\Data\OrderInterface[]
     */
    public function getItems()
    {
        return $this->getData(self::ITEMS);
    }

    /**
     * Set Items
     *
     * @param \Magento\Sales\Api\Data\OrderInterface[] $items
     * @return $this
     */
    public function setItems($items)
    {
        return $this->setData(self::ITEMS, $items);
    }

    /**
     * Get total account
     *
     * @return int
     */
    public function getTotalCount()
    {
        return $this->getData(self::TOTAL_COUNT);
    }

    /**
     * Set total account
     *
     * @param int $count
     * @return $this
     */
    public function setTotalCount($count)
    {
        return $this->setData(self::TOTAL_COUNT, $count);
    }
}
