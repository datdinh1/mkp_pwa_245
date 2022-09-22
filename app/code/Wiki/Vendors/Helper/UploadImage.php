<?php

namespace Wiki\Vendors\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Driver\File;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Stdlib\DateTime\Filter\Date;
use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Framework\Filesystem\Io\File as FileIo;
use Wiki\SampleImageUploader\Model\ImageFactory;


class UploadImage extends AbstractHelper
{
    /**
     * @var CategoryRepositoryInterface
     */
    protected $categoryRepository;

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
     * @var ImageFactory
     */
    protected $imageFactory;

    public function __construct(
        FileIo                      $io,
        Filesystem                  $filesystem,
        ImageFactory                $imageFactory,
        File                        $file,
        DirectoryList               $directoryList,
        Date                        $dateFilter,
        CategoryRepositoryInterface $categoryRepository
    ) {
        $this->io                   = $io;
        $this->imageFactory         = $imageFactory;
        $this->filesystem           = $filesystem;
        $this->file                 = $file;
        $this->directoryList        = $directoryList;
        $this->dateFilter           = $dateFilter;
        $this->categoryRepository   = $categoryRepository;
    }

    public function uploadImage($image, $filePath)
    {
        $mediaPath = $this->filesystem->getDirectoryRead($this->directoryList::MEDIA)->getAbsolutePath();
        $mediaPath .= $filePath;
        if (!is_dir($mediaPath)) {
            $this->io->mkdir($mediaPath, 0777);
        }
        if (base64_decode($image, true) == true) {
            $dataBase64 = base64_decode($image);
            $f = finfo_open();
            $type = explode('/', finfo_buffer($f, $dataBase64, FILEINFO_MIME_TYPE))[1];
            $imageUrl = strtotime("now") . "-" . uniqid() . '.' . $type;
            file_put_contents($mediaPath . $imageUrl, $dataBase64);
            return  $imageUrl;
        }
        return false;
    }

    public function deleteImage($image, $filePath)
    {
        $mediaRootDir = $this->filesystem->getDirectoryRead($this->directoryList::MEDIA)->getAbsolutePath();
        $mediaRootDir .= $filePath;
        if ($image) {
            if ($this->file->isExists($mediaRootDir . $image)) {
                $this->file->deleteFile($mediaRootDir . $image);
            }
        }
    }

    public function uploadBanners($image, $filePath,$url)
    {
        $mediaPath = $this->filesystem->getDirectoryRead($this->directoryList::MEDIA)->getAbsolutePath();
        $mediaPath .= $filePath;
        if (!is_dir($mediaPath)) {
            $this->io->mkdir($mediaPath, 0777);
        }
        if (base64_decode($image, true) == true) {
            $dataBase64 = base64_decode($image);
            $f = finfo_open();
            $type = explode('/', finfo_buffer($f, $dataBase64, FILEINFO_MIME_TYPE))[1];
            $imageUrl = strtotime("now") . "-" . uniqid() . '.' . $type;
            file_put_contents($mediaPath . $imageUrl, $dataBase64);

            /*save data image*/
            $data = [
                'title'=>$url,
                'image'=>$imageUrl
            ];
            $imageFactory = $this->imageFactory->create();
            $imageFactory->setData($data)->save();
            return   $imageFactory->getId();
        }
        return false;
    }
    
    public function deleteBanner($idImage,$path){

        $imageFactory = $this->imageFactory->create()->load($idImage);
        if(!empty($imageFactory->getId())){
            $this->deleteImage($imageFactory->getImage(),$path);
            $imageFactory->delete();
        }
    }

    public function getBannerByIdImage($id){
        $imageFactory = $this->imageFactory->create()->load($id);
        if(!empty($imageFactory->getId())){
            return  $imageFactory;
        }
        return null;
    }
}
