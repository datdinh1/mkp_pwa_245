<?php
namespace Wiki\VendorsNotification\Controller\Adminhtml\Notification;

use Wiki\VendorsNotification\Controller\Adminhtml\Notification;

class Delete extends Notification
{
    /**
     * @return void
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        if ( $id ){
            $model = $this->notificationFactory->create();
            $model->load($id);

            if ( !$model->getId() ){
                $this->messageManager->addError(__('This news no longer exists.'));
            } else {
                try {
                    $image = $model->getImage();
                    $model->delete();
                    if ( $image ){
                        $this->helperData->deleteImage($image);
                    }
                    $this->messageManager->addSuccess(__('The news has been deleted.'));
                    $this->_redirect('*/*/');
                    return;
                } catch ( \Exception $e ){
                    $this->messageManager->addError($e->getMessage());
                    $this->_redirect('*/*/edit', ['id' => $model->getId()]);
                }
            }
        }
        $this->_redirect('*/*/');
        return;
    }
}