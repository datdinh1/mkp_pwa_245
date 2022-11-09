<?php
/*
 * Wiki-Solution
 */
namespace Wiki\VendorsCredit\Model\ResourceModel\Image;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'id';

    /**
     * Collection initialisation
     */
    protected function _construct()
    {
        $this->_init(
            'Wiki\VendorsCredit\Model\Debit',
            'Wiki\VendorsCredit\Model\ResourceModel\Debit'
        );
    }
}
