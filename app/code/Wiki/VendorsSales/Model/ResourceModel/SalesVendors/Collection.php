<?php
namespace Wiki\VendorsSales\Model\ResourceModel\SalesVendors;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
	protected $_idFieldName = 'entity_id';
	protected $_eventPrefix = 'sales_order_collection';
	protected $_eventObject = 'sales_vendors_collection';

	/**
	 * Define resource model
	 *
	 * @return void
	 */
	protected function _construct()
	{
		$this->_init('Wiki\VendorsSales\Model\SalesVendors', 'Wiki\VendorsSales\Model\ResourceModel\SalesVendors');
	}

}