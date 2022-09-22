<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\StoreApi\Model;

class Setting extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Initialize resource model
     * 
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Wiki\StoreApi\Model\ResourceModel\Setting::class);
    }
}
