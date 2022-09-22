<?php
namespace Wiki\VendorsSalesRule\Model\ResourceModel\CollectCoupon;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
	/**
	 * Define resource model
	 *
	 * @return void
	 */
	protected function _construct()
	{
		$this->_init('Wiki\VendorsSalesRule\Model\CollectCoupon', 'Wiki\VendorsSalesRule\Model\ResourceModel\CollectCoupon');
	}

}