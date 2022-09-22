<?php 
namespace Wiki\VendorsFollow\Model;

use Magento\Framework\Model\AbstractModel;

class UpdateFollowers extends AbstractModel
{
    const CACHE_TAG = 'ves_vendor_entity_varchar';
    
	public function _construct(){
		$this->_init(\Wiki\VendorsFollow\Model\ResourceModel\UpdateFollowers::class);
    }
    
	public function getIdentities()
	{
		return [self::CACHE_TAG . '_' . $this->getValueId()];
	}

    public function getDefaultValues()
	{
		$values = [];
		return $values;
	}
}