<?php 
namespace Wiki\VendorsFollow\Model\ResourceModel\Follow;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
	public function _construct(){
		$this->_init(
			\Wiki\VendorsFollow\Model\Follow::class,
			\Wiki\VendorsFollow\Model\ResourceModel\Follow::class
		);
	}
}