<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\Credit\Model\Credit;

use Magento\Framework\Exception\LocalizedException;

class Transaction extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Wiki\Credit\Model\ResourceModel\Credit\Transaction');
    }
}
