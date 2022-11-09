<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\StoreApi\Model\ResourceModel;

class Card extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{ 
    /**
     * Initialize table nad PK name
     * 
     * @return void
     */
    protected function _construct()
    {
        $this->_init('wiki_card_token', 'card_id');
    }
}
