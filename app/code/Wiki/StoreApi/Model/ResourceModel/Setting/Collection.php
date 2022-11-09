<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\StoreApi\Model\ResourceModel\Setting;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'setting_id';

    /**
     * Resource initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            \Wiki\StoreApi\Model\Setting::class, 
            \Wiki\StoreApi\Model\ResourceModel\Setting::class
        );
    }
}
