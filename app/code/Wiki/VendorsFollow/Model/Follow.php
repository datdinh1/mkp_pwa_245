<?php 
namespace Wiki\VendorsFollow\Model;

use Magento\Framework\Model\AbstractModel;

class Follow extends AbstractModel
{
    const CACHE_TAG = 'wiki_follow';
    
	public function _construct(){
		$this->_init(\Wiki\VendorsFollow\Model\ResourceModel\Follow::class);
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