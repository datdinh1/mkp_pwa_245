<?php 
namespace Wiki\VendorsFollow\Model\ResourceModel\UpdateFollowers;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
	public function _construct(){
		$this->_init(
			\Wiki\VendorsFollow\Model\UpdateFollowers::class,
			\Wiki\VendorsFollow\Model\ResourceModel\UpdateFollowers::class
		);
	}
}