<?php
namespace Wiki\VendorsReport\Model;
class NewReport extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
	const CACHE_TAG = 'wiki_report_sales_seller';

	protected $_cacheTag = 'wiki_report_sales_seller';

	protected $_eventPrefix = 'wiki_report_sales_seller';

	protected function _construct()
	{
		$this->_init('Wiki\VendorsReport\Model\ResourceModel\NewReport');
	}

	public function getIdentities()
	{
		return [self::CACHE_TAG . '_' . $this->getId()];
	}

	public function getDefaultValues()
	{
		$values = [];

		return $values;
	}
}