<?php 
namespace Wiki\VendorsNotification\Controller\Index;  

class DetailNoti extends \Wiki\VendorsNotification\Controller\Index\Index { 
  

    
	

	public function execute()
	{
		
         $resultPage = $this->_pageFactory->create();
		 
		 $this->blockDisplay->flushCache();
        return $resultPage;
    
	}
} 
?>