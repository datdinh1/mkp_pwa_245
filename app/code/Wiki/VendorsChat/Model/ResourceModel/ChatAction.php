<?php

namespace Wiki\VendorsChat\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class ChatAction extends AbstractDb
{
    /**
     * Define main table
     */
    protected function _construct()
    {
        $this->_init('wk_chat_room_action', 'action_id');
    }
}