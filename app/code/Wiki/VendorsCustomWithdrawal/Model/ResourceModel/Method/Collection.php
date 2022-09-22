<?php
namespace Wiki\VendorsCustomWithdrawal\Model\ResourceModel\Method;

use \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * App page collection
 */
class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'method_id';


    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Wiki\VendorsCustomWithdrawal\Model\Method', 'Wiki\VendorsCustomWithdrawal\Model\ResourceModel\Method');
    }

}
