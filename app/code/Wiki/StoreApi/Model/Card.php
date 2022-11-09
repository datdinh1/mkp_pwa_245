<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\StoreApi\Model;

use Wiki\StoreApi\Api\Data\CardInterface; 
use Magento\Framework\Model\AbstractModel;

class Card extends AbstractModel implements CardInterface
{
    /**
     * Initialize resource model
     * 
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Wiki\StoreApi\Model\ResourceModel\Card::class);
    } 

    /**
     * @inheritdoc
     */
    public function getCardId()
    {
        return $this->getData('card_id');
    }

    /**
     * @inheritdoc
     */
    public function setCardId($cardId)
    {
        return $this->setData('card_id', $cardId);
    }

    /**
     * @inheritdoc
     */
    public function getCustomerId()
    {
        return $this->getData('customer_id');
    }

    /**
     * @inheritdoc
     */
    public function setCustomerId($id)
    {
        $this->setData('customer_id', $id);
    }

    /**
     * @inheritdoc
     */
    public function getType()
    {
        return $this->getData('type');
    }

    /**
     * @inheritdoc
     */
    public function setType($type)
    {
        return $this->setData('type', $type);
    }

    /**
     * @inheritdoc
     */
    public function getToken()
    {
        return $this->getData('token');
    }

    /**
     * @inheritdoc
     */
    public function setToken($token)
    {
        return $this->setData('token', $token);
    }

    /**
     * @inheritdoc
     */
    public function getActive()
    {
        return $this->getData('active');
    }

    /**
     * @inheritdoc
     */
    public function setActive($active)
    {
        return $this->setData('active', $active);
    }
}
