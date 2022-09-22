<?php 
namespace Wiki\VendorsCustomerAccount\Model\ResourceModel\Block;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
	public function _construct(){
		$this->_init(
			\Wiki\VendorsCustomerAccount\Model\Block::class,
			\Wiki\VendorsCustomerAccount\Model\ResourceModel\Block::class
		);
	}
}