<?php

namespace Wiki\SmsNotification\Model\Resource;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class News extends AbstractDb
{
    /**
     * Define main table
     */
    protected function _construct()
    {
        $this->_init('wiki_smsnotification', 'id');
    }
}