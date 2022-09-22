<?php

namespace Wiki\VendorsChat\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class ChatRoom extends AbstractDb
{
    /**
     * Define main table
     */
    protected function _construct()
    {
        $this->_init('wk_chat_room', 'chat_id');
    }
}