<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Wiki\VendorsChat\Model\Api;

class InfoRoom extends \Magento\Framework\Model\AbstractModel implements \Wiki\VendorsChat\Api\Data\InfoRoomInterface
{
    /**
     * @inheritdoc
     */
    public function getSeller()
    {
        return $this->getData(self::SELLER);
    }

    /**
     * @inheritdoc
     */
    public function setSeller($seller)
    {
        return $this->setData(self::SELLER, $seller);
    }

    /**
     * @inheritdoc
     */
    public function getBuyer()
    {
        return $this->getData(self::BUYER);
    }

    /**
     * @inheritdoc
     */
    public function setBuyer($customer)
    {
        return $this->setData(self::BUYER, $customer);
    }

    /**
     * @inheritdoc
     */
    public function getRoom()
    {
        return $this->getData(self::ROOM);
    }

    /**
     * @inheritdoc
     */
    public function setRoom($room)
    {
        return $this->setData(self::ROOM, $room);
    }
}
