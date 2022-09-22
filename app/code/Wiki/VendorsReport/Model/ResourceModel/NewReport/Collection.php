<?php
namespace Wiki\VendorsReport\Model\ResourceModel\NewReport;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
	protected $_idFieldName = 'id';
	protected $_eventPrefix = 'wiki_report_sales_seller_collection';
	protected $_eventObject = 'report_sales_seller_collection';

	/**
	 * Define resource model
	 *
	 * @return void
	 */
	protected function _construct()
	{
		$this->_init('Wiki\VendorsReport\Model\NewReport', 'Wiki\VendorsReport\Model\ResourceModel\NewReport');
	}

}