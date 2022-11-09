<?php

namespace Wiki\VendorsChat\Model\ResourceModel\ChatAction;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * Define model & resource model
     */
    protected $_idFieldName = 'action_id';
    protected function _construct()
    {
        $this->_init(
            'Wiki\VendorsChat\Model\ChatAction', 'Wiki\VendorsChat\Model\ResourceModel\ChatAction'
        );
    }
}