<?php
namespace Wiki\VendorsSalesRule\Model\ResourceModel;


class VarcharCode extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
	
	public function __construct(
		\Magento\Framework\Model\ResourceModel\Db\Context $context
	)
	{
		parent::__construct($context);
	}
	
	protected function _construct()
	{
		$this->_init('wiki_generate_varchar_code', 'id');
	}
	
}