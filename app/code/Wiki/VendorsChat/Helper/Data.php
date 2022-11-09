<?php

namespace Wiki\VendorsChat\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Driver\File;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Stdlib\DateTime\Filter\Date;
use Magento\Framework\Filesystem\Io\File as FileIo;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;

class Data extends AbstractHelper
{
    const XML_PATH_CHAT = 'chat/';
    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * @var File
     */
    protected $file;

    /**
     * @var DirectoryList
     */
    protected $directoryList;

    /**
     * @var Date
     */
    protected $dateFilter;

    /**
     * @var FileIo
     */
    protected $io;

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    public function __construct(
        ScopeConfigInterface        $scopeConfig,
        Filesystem                  $filesystem,
        File                        $file,
        DirectoryList               $directoryList,
        Date                        $dateFilter,
        FileIo                        $io
    ) {
        $this->scopeConfig          = $scopeConfig;
        $this->io                   = $io;
        $this->filesystem           = $filesystem;
        $this->file                 = $file;
        $this->directoryList        = $directoryList;
        $this->dateFilter           = $dateFilter;
    }

    public function uploadImage($image)
    {
        $path =  $this->checkCreateFolderURL('chat/images/');
        if (base64_decode($image, true) == true) {
            $dataBase64 = base64_decode($image);
            $f = finfo_open();
            $type = explode('/', finfo_buffer($f, $dataBase64, FILEINFO_MIME_TYPE))[1];
            $imageUrl = strtotime("now") . "-" . uniqid() . '.' . $type;
            file_put_contents($path . $imageUrl, $dataBase64);
            return '/chat/images/' . $imageUrl;
        }
        return false;
    }

    public function deleteImage($image)
    {
        $mediaRootDir = $this->filesystem->getDirectoryRead($this->directoryList::MEDIA)->getAbsolutePath();
        $mediaRootDir .= "sampleimageuploader/images/image";
        if ($image) {
            if ($this->file->isExists($mediaRootDir . $image)) {
                $this->file->deleteFile($mediaRootDir . $image);
            }
        }
    }

    public function checkExitsImage($image)
    {
        $mediaRootDir = $this->filesystem->getDirectoryRead($this->directoryList::MEDIA)->getAbsolutePath();
        return ($this->file->isExists($mediaRootDir . $image)) ? true : false;
    }

    public function checkCreateFolderURL($url)
    {
        $mediaPath = $this->filesystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath();
        $uploadPath = $mediaPath . $url;
        if (!is_dir($uploadPath)) {
            $this->io->mkdir($uploadPath, 0777);
        }
        return  $uploadPath;
    }

    public function getConfigValue($field, $storeId = null)
    {
        return $this->scopeConfig->getValue(
            $field,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    public function getGeneralConfig($code, $storeId = null)
    {
        return  $this->getConfigValue(self::XML_PATH_CHAT . 'general/' . $code, $storeId);
    }

    public function connectPusher()
    {
        try {
            $app_id = $this->getGeneralConfig('app_id');
            $app_key = $this->getGeneralConfig('key');
            $app_secret = $this->getGeneralConfig('secret');
            $app_cluster = $this->getGeneralConfig('cluster');
            $enable = $this->getGeneralConfig('server_enable');
            if ($enable == 1) {
                $host = $this->getGeneralConfig('host');
                $port =  $this->getGeneralConfig('port');
                $pusher = new \Pusher\Pusher($app_key, $app_secret, $app_id, array('cluster' => $app_cluster),  $host,  $port);
            } else {
                $pusher =  new \Pusher\Pusher($app_key, $app_secret, $app_id, array('cluster' => $app_cluster, 'useTLS' => true));
            }

            return  $pusher;
        } catch (\Exception $e) {
            return false;
        }
        return true;
    }
    public function useChatPusher($chatId, $message, $type)
    {
        try {
            $channel = $this->getGeneralConfig('channel');
            $pusher = $this->connectPusher();
            if (!$pusher) return false;

            $pusher->trigger($channel, $type . '-' . $chatId, $message);
        } catch (\Exception $e) {
            return false;
        }
        return true;
    }

    public function deleteImageByFilePath($image, $filePath)
    {
        $mediaRootDir = $this->filesystem->getDirectoryRead($this->directoryList::MEDIA)->getAbsolutePath();
        $mediaRootDir .= $filePath;
        if ($image) {
            if ($this->file->isExists($mediaRootDir . $image)) {
                $this->file->deleteFile($mediaRootDir . $image);
            }
        }
    }

    public function sendReloadChat($customerId, $vendorId)
    {
        try {
            $channel = $this->getGeneralConfig('channel');
            $pusher = $this->connectPusher();
            if (!$pusher) return false;

            $message = ['Reload'];
            $pusher->trigger($channel,  'chat-reload-' . $customerId.'-'.$vendorId, $message);
        } catch (\Exception $e) {
            return false;
        }
        return true;
    }
}
