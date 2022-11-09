<?php

namespace Wiki\SmsNotification\Controller\Adminhtml\SmsNotification;

use Wiki\SmsNotification\Controller\Adminhtml\SmsNotification;

class Delete extends SmsNotification
{
   /**
    * @return void
    */
   public function execute()
   {
      $newsId = (int) $this->getRequest()->getParam('id');

      if ($newsId) {
         /** @var $newsModel \Mageworld\SmsNotification\Model\News */
         $newsModel = $this->_newsFactory->create();
         $newsModel->load($newsId);

         // Check this news exists or not
         if (!$newsModel->getId()) {
            $this->messageManager->addError(__('This news no longer exists.'));
         } else {
               try {
                  $notification = $this->_notificationFactory->create();
                  $listNotiDel = $notification->getCollection();

                  foreach($listNotiDel->getData() as $notiDel){
                     if($notiDel['noti_admin_id'] == $newsId){
                        
                        $notiTmp = $this->_notificationFactory->create();
                        $notiTmp->load($notiDel['notification_id']);
                        $notiTmp->delete();
                     }
                  }
                ;

                  /**--------------------- */
                  // Delete news
                  $newsModel->delete();
                  $this->messageManager->addSuccess(__('The news has been deleted.'));

                  // Redirect to grid page
                  $this->_redirect('*/*/');
                  return;
               } catch (\Exception $e) {
                   $this->messageManager->addError($e->getMessage());
                   $this->_redirect('*/*/edit', ['id' => $newsModel->getId()]);
               }
            }
      }
   }
}