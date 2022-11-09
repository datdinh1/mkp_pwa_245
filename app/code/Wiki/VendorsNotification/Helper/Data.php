<?php
namespace Wiki\VendorsNotification\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Driver\File as FileDriver;
use Magento\Framework\App\Filesystem\DirectoryList;
use Wiki\VendorsNotification\Model\NotificationFactory;

class Data extends AbstractHelper
{
    /**
	 * @var NotificationFactory
	 */
    protected $notificationFactory;

        /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * @var FileDriver
     */
    protected $fileDriver;

    public function __construct(
        Filesystem                  $filesystem,
        FileDriver                  $fileDriver,
        NotificationFactory         $notificationFactory
    ) {
        $this->notificationFactory  = $notificationFactory;
        $this->filesystem           = $filesystem;
        $this->fileDriver           = $fileDriver;
    }

    public function getNotification($attribute, $id, $notificationOf = null)
    {
        
        $value[] = 0;
        if ( $notificationOf ){
            $value[] = $notificationOf;
        }

        $collection = $this->notificationFactory->create()->getCollection();
        $collection->addFieldToFilter($attribute, array($id, array('null' => true)))
            ->addFieldToFilter(
                'message',
                array('neq' => false)
            )
            ->addFieldToFilter('notification_of', $value)
            ->setOrder('notification_id', 'DESC');
        return $collection->getData();
    }
    
    public function insertNotification($order, $message, $content = null)
    {
       
        $extensionAtrr  = $order->getExtensionAttributes()->getVendor();
        if( $extensionAtrr){
            $vendorId       =  $extensionAtrr->getId();
        } else{
            $vendorId       = $order->getAllItems()[0]->getVendorId();
        }
       
        $customerId     = $order->getCustomerId();
        $additionalInfo = ['id' => $order->getId()];

        $notification   = $this->notificationFactory->create();
        $notification->setData([
            'vendor_id'         => $vendorId,
            'type'              => 'sales',
            'message'           => $message,
            'additional_info'   => serialize($additionalInfo),
            'customer_id'       => $customerId,
            'noti_admin_id'     => 0,
            'content'           => $content
        ])->save();
    }

    public function checkNotification($message)
    {
        $collection = $this->notificationFactory->create()->getCollection();
        $collection->addFieldToFilter('message', $message);
        if ( $collection->getData() )
            return true;
        return false;
    }

    public function deleteImage($image)
    {
        $mediaDirectory = $this->filesystem->getDirectoryRead(DirectoryList::MEDIA);
        $mediaRootDir = $mediaDirectory->getAbsolutePath();
        if ( $image ){
            if ( $this->fileDriver->isExists($mediaRootDir . $image) ){
                $this->fileDriver->deleteFile($mediaRootDir . $image);
            }
        }
    }
}