<?php

namespace Wiki\VendorsHelpDesk\Model\ResourceModel\Ticket\Grid;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * Define model & resource model
     */
    protected $_idFieldName = 'chat_id';
    protected function _construct()
    {
        $this->_init(
            'Wiki\VendorsChat\Model\ChatRoom', 'Wiki\VendorsChat\Model\ResourceModel\ChatRoom\Grid'
        );
    }
}