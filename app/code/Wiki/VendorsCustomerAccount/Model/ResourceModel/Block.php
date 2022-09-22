<?php
namespace Wiki\VendorsCustomerAccount\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Block extends AbstractDb
{
    public function _construct()
    {
        $this->_init("wiki_block_customer_account", "id");
    }
}
