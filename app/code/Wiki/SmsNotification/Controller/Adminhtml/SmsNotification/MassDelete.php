<?php

namespace Wiki\SmsNotification\Controller\Adminhtml\SmsNotification;

use Wiki\SmsNotification\Controller\Adminhtml\SmsNotification;

use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Wiki\SmsNotification\Model\NewsFactory;
class MassDelete extends  \Magento\Backend\App\Action{
   /**
    * @return void
    */
    protected $filter;
    protected $_newsFactory;

    public function __construct(
        Context $context, 
        Filter $filter,
        NewsFactory $newsFactory
       
    ){
        $this->filter = $filter;
        $this->_newsFactory = $newsFactory;
        
        parent::__construct($context);
    }
   public function execute()
   {
      // Get IDs of the selected news
      $collection = $this->filter->getCollection($this->_newsFactory->create());
    //     $collectionSize = $collection->getSize();
    //   foreach ($collection as $item) {
    //     $item->delete();
    // }
    //   $x =$this->_newsFactory->create();
    //   $collection = $this->filter;
    //   $collection = $this->filter->getCollection($x);
    //   var_dump($collection->getData());
      
    //   exit;
      

     

    //   $collectionSize = $collection->getSize();
    //   foreach ($collection as $item) 
    //   {
      
    //   $item->delete();
    //   }
     

        // foreach ($newsIds as $newsId) {
        //     try {
        //        /** @var $newsModel \Mageworld\SmsNotification\Model\News */
        //         $newsModel = $this->_newsFactory->create();
        //         $newsModel->load($newsId)->delete();
        //     } catch (\Exception $e) {
        //         $this->messageManager->addError($e->getMessage());
        //     }
        // }

        $this->messageManager->addSuccess(__('A total of %1 element(s) have been deleted.', $productDeleted));

        $this->_redirect('*/*/index');
   }
}