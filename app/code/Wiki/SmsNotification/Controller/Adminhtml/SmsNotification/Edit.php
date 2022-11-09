<?php

namespace Wiki\SmsNotification\Controller\Adminhtml\SmsNotification;

use Wiki\SmsNotification\Controller\Adminhtml\SmsNotification;

class Edit extends SmsNotification
{
   /**
     * @return void
     */
   public function execute()
   {
      $newsId = $this->getRequest()->getParam('id');
        /** @var \Wiki\SmsNotification\Model\News $model */
        $model = $this->_newsFactory->create();

        if ($newsId) {
            $model->load($newsId);
            if (!$model->getId()) {
                $this->messageManager->addError(__('This news no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }
        }

        // Restore previously entered form data from session
      
        $this->_coreRegistry->register('wiki_smsnotification', $model);

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->_resultPageFactory->create();
        $resultPage->setActiveMenu('Wiki_SmsNotification::main_menu');
        $resultPage->getConfig()->getTitle()->prepend(__('SMS Notification'));

        return $resultPage;
   }
}