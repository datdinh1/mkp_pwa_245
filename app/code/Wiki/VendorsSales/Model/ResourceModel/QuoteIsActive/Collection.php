<?php
namespace Wiki\VendorsSales\Model\ResourceModel\QuoteIsActive;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
	protected $_idFieldName = 'id';
	protected $_eventPrefix = 'wiki_quote_is_active_collection';
	protected $_eventObject = 'wiki_quote_is_active_collection';

	/**
	 * Define resource model
	 * @return void
	 */
	protected function _construct()
	{
		$this->_init(\Wiki\VendorsSales\Model\QuoteIsActive::class, \Wiki\VendorsSales\Model\ResourceModel\QuoteIsActive::class);
	}

}