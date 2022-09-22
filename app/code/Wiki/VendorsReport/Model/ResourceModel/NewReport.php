<?php
namespace Wiki\VendorsReport\Model\ResourceModel;


class NewReport extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

	public function __construct(
		\Magento\Framework\Model\ResourceModel\Db\Context $context
	)
	{
		parent::__construct($context);
	}

	protected function _construct()
	{
		$this->_init('wiki_report_sales_seller', 'id');
	}

}