<?php

namespace Wiki\SmsNotification\Model\Resource\News;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * Define model & resource model
     */
    protected function _construct()
    {
        $this->_init(
            'Wiki\SmsNotification\Model\News',
            'Wiki\SmsNotification\Model\Resource\News'
        );
    }
}