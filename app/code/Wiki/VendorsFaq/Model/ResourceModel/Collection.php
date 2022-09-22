<?php 
namespace Wiki\VendorsFaq\Model\ResourceModel\Faq;
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection{
	public function _construct(){
		$this->_init("Wiki\VendorsFaq\Model\Faq","Wiki\VendorsFaq\Model\ResourceModel\Faq");
	}
}
 ?>