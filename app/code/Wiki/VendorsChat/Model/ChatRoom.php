<?php

namespace Wiki\VendorsChat\Model;

use Magento\Framework\Model\AbstractModel;

class ChatRoom extends AbstractModel
{
    const CACHE_TAG = 'wk_chat_room';
    /**
     * Define resource model
     */
    protected function _construct()
    {
        $this->_init('Wiki\VendorsChat\Model\ResourceModel\ChatRoom');
    }
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getDefaultValues()
    {
        $values = [];

        return $values;
    }
}
