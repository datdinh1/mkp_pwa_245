<?php 
namespace Wiki\VendorsFaq\Model\ResourceModel\FaqDetail;
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection{
	public function _construct(){
		$this->_init("Wiki\VendorsFaq\Model\Api\Data\FaqDetail","Wiki\VendorsFaq\Model\ResourceModel\FaqDetail");
	}
}
 ?>