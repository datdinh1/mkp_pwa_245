<?php
namespace Wiki\VendorsFollow\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class UpdateFollowers extends AbstractDb
{
    public function _construct()
    {
        $this->_init("ves_vendor_entity_varchar", "value_id");
    }
}
