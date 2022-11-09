<?php
namespace Wiki\VendorsNotification\Controller\Adminhtml\Notification;

use Wiki\VendorsNotification\Controller\Adminhtml\Notification;

class Edit extends Notification
{
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $model = $this->notificationFactory->create();
        if ( $id ){
            $model->load($id);
            if ( !$model->getId() ){
                $this->messageManager->addError(__('This news no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }
        }

        $this->_coreRegistry->register('wiki_notification', $model);
        $resultPage = $this->_resultPageFactory->create();
        $resultPage->setActiveMenu('Wiki_VendorsNotification::main_menu');
        $resultPage->getConfig()->getTitle()->prepend(__('Edit Notification'));

        return $resultPage;
    }
}
