<?php

namespace Wiki\VendorsSales\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class RequestReturnOrder extends AbstractDb
{
    /**
     * Define main table
     */
    protected function _construct()
    {
        $this->_init('wiki_request_return_order', 'id');
    }
}