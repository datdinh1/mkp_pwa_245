<?php
namespace Wiki\VendorsNotification\Controller\Adminhtml\Notification;

use Magento\Framework\App\Filesystem\DirectoryList;
use Wiki\VendorsNotification\Controller\Adminhtml\Notification;

class Save extends Notification
{
    /**
     * @return void
     */
    public function execute()
    {
        $isPost = $this->getRequest()->getPost();
        
        if ( $isPost ){
            $model = $this->notificationFactory->create();
            $data = $this->getRequest()->getParam('params');
            if ( $id = isset($data['id']) ){
                $model->load($id);

                // change array key id to notification_id
                $keys = array_keys($data);
                $keys[array_search('id', $keys, true)] = 'notification_id';
                $data = array_combine($keys, $data);
            }

            if ( !$model->getId() && $id ){
                $this->messageManager->addErrorMessage(__('This Notification no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }
            
            $image = $this->saveImage();
            if ( isset($data['image']['value']) && $image || isset($data['image']['delete']) ){
                $this->helperData->deleteImage($data['image']['value']);
            }
            $data['image'] = $image ? $image : ((!isset($data['image']['value']) || isset($data['image']['delete'])) ? '' : $data['image']['value']);

            try {
                $model->setData($data);
                $model->setNotificationOf((int)$data['notification_of'])->save();

                $this->messageManager->addSuccess(__('The notification has been saved.'));
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', ['id' => $model->getId(), '_current' => true]);
                    return;
                }

                $this->_redirect('*/*/');
                return;
            } catch ( \Exception $e ){
                $this->messageManager->addError($e->getMessage());
            }
            $this->_redirect('*/*/edit', ['id' => $id]);
        }
    }

    protected function saveImage()
    {
        try {
            $imageAdapter = $this->adapterFactory->create();
            $uploader = $this->fileUploaderFactory->create(['fileId' => 'image']);
            $uploader->addValidateCallback('image', $imageAdapter, 'validateUploadFile');
            $uploader->setAllowedExtensions(['jpg', 'jpeg', 'png']);
            $uploader->setAllowCreateFolders(true);
            $uploader->setAllowRenameFiles(true);
            $uploader->setFilesDispersion(true);
    
            $path = $this->filesystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath('sampleimageuploader/tmp/images/image');
            $result = $uploader->save($path);
            return 'sampleimageuploader/tmp/images/image' . $result['file'];
        }
        catch ( \Exception $e ){
            return false;
        }
    }    
}