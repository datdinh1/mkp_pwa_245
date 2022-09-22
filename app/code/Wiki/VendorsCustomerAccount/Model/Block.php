<?php 
namespace Wiki\VendorsCustomerAccount\Model;

use Magento\Framework\Model\AbstractModel;

class Block extends AbstractModel
{
	const CACHE_TAG 			= 'wiki_block_customer_account';
	const BLOCKED_BY_CUSTOMERS 	= 1;
	const BLOCKED_BY_VENDORS 	= 2;
    
	public function _construct(){
		$this->_init(\Wiki\VendorsCustomerAccount\Model\ResourceModel\Block::class);
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