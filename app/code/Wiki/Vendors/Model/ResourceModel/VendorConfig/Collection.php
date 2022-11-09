<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\Vendors\Model\ResourceModel\VendorConfig;

use \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * App page collection
 */
class Collection extends AbstractCollection
{
    protected $_idFieldName = 'config_id';
	protected $_eventPrefix = 'ves_vendor_configcollection';
	protected $_eventObject = 'ves_vendor_config_collection';

	/**
	 * Define resource model
	 *
	 * @return void
	 */
	protected function _construct()
	{
		$this->_init('Wiki\Vendors\Model\VendorConfig', 'Wiki\Vendors\Model\ResourceModel\VendorConfig');
	}

}
