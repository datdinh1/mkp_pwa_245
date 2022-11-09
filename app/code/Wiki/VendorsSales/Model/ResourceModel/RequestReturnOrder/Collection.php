<?php
namespace wiki\VendorsSales\Model\ResourceModel\RequestReturnOrder;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
	protected $_idFieldName = 'id';
	protected $_eventPrefix = 'wiki_request_return_order_collection';
	protected $_eventObject = 'request_return_order_collection';

	/**
	 * Define resource model
	 *
	 * @return void
	 */
	protected function _construct()
	{
		$this->_init('Wiki\VendorsSales\Model\RequestReturnOrder', 'Wiki\VendorsSales\Model\ResourceModel\RequestReturnOrder');
	}

}