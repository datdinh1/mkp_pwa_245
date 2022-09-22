<?php
namespace Wiki\VendorsSalesRule\Model\ResourceModel\VarcharCode;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
	/**
	 * Define resource model
	 *
	 * @return void
	 */
	protected function _construct()
	{
		$this->_init(
			\Wiki\VendorsSalesRule\Model\VarcharCode::class,
			\Wiki\VendorsSalesRule\Model\ResourceModel\VarcharCode::class
		);
	}
}