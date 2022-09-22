<?php

namespace Wiki\SmsNotification\Controller\Adminhtml\SmsNotification;

use Wiki\SmsNotification\Controller\Adminhtml\SmsNotification;

class Save extends SmsNotification
{
   /**
     * @return void
     */
   public function execute()
   {
      $isPost = $this->getRequest()->getPost();
      
      if ($isPost) {
         
         $newsModel = $this->_newsFactory->create();
         $newsId = $this->getRequest()->getParam('id');
         //$model = $this->initModel();
         if ($newsId) {
            $newsModel->load($newsId);
         }

         if (!$newsModel->getId() && $newsId) {
            $this->messageManager->addErrorMessage(__('This Notification no longer exists.'));

            return $resultRedirect->setPath('*/*/');
        }
         $formData = $this->getRequest()->getParam('news');
         $data = $this->getRequest()->getParams();
        
                  //$newsModel->setData($formData);
               // $model->addData($data);

               //$newsModel->addData($data);
               
               /**-----------------------------insert img to db-------------------------------- */
               $imagesFolder = $this->dir->getPath('media').'/wiki_notification/images';
               if ( ! file_exists($imagesFolder)) {
                  $this->file->mkdir($this->dir->getPath('media').'/wiki_notification/images', 0775);
               }
               // echo $this->dir->getPath('media'); exit;

               $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
               $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
               $connection = $resource->getConnection();
               
               
               // $timestamp = time();
               //$today = new DateTime();
             
               

               if(isset($_FILES['image_noti']) && $_FILES['image_noti']['name'] != ''){
                  $img_desktop = $_FILES['image_noti']['name'];
                  $formData['image'] = $img_desktop;
                  if(isset($newsId)){
                     
                        $uploader_desktop = $this->_fileUploaderFactory->create(['fileId' => 'image_noti']);
                        $uploader_desktop->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);
                        $uploader_desktop->setAllowRenameFiles(true);
                        $uploader_desktop->setFilesDispersion(false);
                        $path = $this->_filesystem->getDirectoryRead(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA)->getAbsolutePath('wiki_notification/images/');
                        
                     
                        $fileNameDesk = $img_desktop;
                        $fileNamePath = $path . $fileNameDesk;
                        //delete image old if namesake
                        if ($this->_fileDriver->isExists($fileNamePath) && $fileNameDesk != "" ) {

                           $this->_fileDriver->deleteFile($fileNamePath);
                           
                        }
                        
                        if ($this->_fileDriver->isExists($path . $img_desktop) == false) {
                           $resultupload = $uploader_desktop->save($path,$img_desktop);
                           
                        }
                     
                  }else {
                     $uploader_desktop = $this->_fileUploaderFactory->create(['fileId' => 'image_noti']);
                        $uploader_desktop->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);
                        $uploader_desktop->setAllowRenameFiles(false);
                        $uploader_desktop->setFilesDispersion(false);
                        $path = $this->_filesystem->getDirectoryRead(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA)->getAbsolutePath('wiki_notification/images/');
                        
                        if ($this->_fileDriver->isExists($path . $img_desktop) == false) {
                              $resultupload = $uploader_desktop->save($path,$img_desktop);
                        }
                  }
                 // $newsModel->addData($data_img);
                 $newsModel->setData($formData);
               } else {
                  if(isset($data['nameDesktop']) && $data['nameDesktop'] == '' ){
                     $this->messageManager->addErrorMessage(__('This Notification no longer exists.'));
                     $this->_redirect('*/*/');
                     return;
                  }
                 
                  $newsModel->setData($formData);
               }
               
              

     /**---------------------------- /insert img to db ------------------------------ */
         try {
              
               // Save news
               $newsModel->save();
               

               // Display success message
               $this->messageManager->addSuccess(__('The notification has been saved.'));
              

               // Check if 'Save and Continue'
               if ($this->getRequest()->getParam('back')) {
                  $this->_redirect('*/*/edit', ['id' => $newsModel->getId(), '_current' => true]);
                  return;
               }

               // Go to grid page
               $this->_redirect('*/*/');
               return;
         } catch (\Exception $e) {
            $this->messageManager->addError($e->getMessage());
         }

         //   $this->_getSession()->setFormData($formData);
         $this->_redirect('*/*/edit', ['id' => $newsId]);
      }
   }
}