<?php

namespace Wiki\Vendors\Model\ResourceModel;

class VendorConfig extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    public function __construct(
		\Magento\Framework\Model\ResourceModel\Db\Context $context
	)
	{
		parent::__construct($context);
	}
	
	protected function _construct()
	{
		$this->_init('ves_vendor_config', 'config_id');
	}
}
