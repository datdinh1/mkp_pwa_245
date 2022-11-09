<?php
namespace Wiki\Vendors\Model;
class VendorConfig extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
	const CACHE_TAG = 'ves_vendor_config';

	protected $_cacheTag = 'ves_vendor_config';

	protected $_eventPrefix = 'ves_vendor_config';

	protected function _construct()
	{
		$this->_init('Wiki\Vendors\Model\ResourceModel\VendorConfig');
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
