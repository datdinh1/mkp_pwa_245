<?php

namespace Wiki\VendorsChat\Model\ResourceModel\ChatImage;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * Define model & resource model
     */
    protected $_idFieldName = 'id';
    protected function _construct()
    {
        $this->_init(
            'Wiki\VendorsChat\Model\ChatImage', 'Wiki\VendorsChat\Model\ResourceModel\ChatImage'
        );
    }
}