<?php
namespace Wiki\VendorsSales\Model;

use \Magento\Framework\Model\AbstractModel;
use \Magento\Framework\DataObject\IdentityInterface;

class QuoteIsActive extends AbstractModel implements IdentityInterface
{
	const CACHE_TAG = 'wiki_quote_is_active';
	protected $_cacheTag = 'wiki_quote_is_active';
	protected $_eventPrefix = 'wiki_quote_is_active';

	protected function _construct()
	{
		$this->_init(\Wiki\VendorsSales\Model\ResourceModel\QuoteIsActive::class);
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