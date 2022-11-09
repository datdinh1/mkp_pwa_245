<?php
/**
 * Copyright (c) 2017 Wiki Co ltd. All rights reserved.
 */

namespace Wiki\VendorsSubAccount\Model\ResourceModel\Role;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            'Wiki\VendorsSubAccount\Model\Role',
            'Wiki\VendorsSubAccount\Model\ResourceModel\Role'
        );
    }
}
