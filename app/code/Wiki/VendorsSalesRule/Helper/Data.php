<?php
namespace Wiki\VendorsSalesRule\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Driver\File;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Stdlib\DateTime\Filter\Date;
use Magento\Catalog\Api\CategoryRepositoryInterface;
class Data extends AbstractHelper
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

    public function __construct(
        Filesystem                  $filesystem,
        File                        $file,
        DirectoryList               $directoryList,
        Date                        $dateFilter,
        CategoryRepositoryInterface $categoryRepository
    ) {
        $this->filesystem           = $filesystem;
        $this->file                 = $file;
        $this->directoryList        = $directoryList;
        $this->dateFilter           = $dateFilter;
        $this->categoryRepository   = $categoryRepository;
    }
    
    public function getUrlImage(){
        $mediaPath = '/pub/media/sampleimageuploader/images/image';
        return $mediaPath;
    }
    public function uploadImage($image)
    {
        // $mediaPath = $this->filesystem->getDirectoryRead($this->directoryList::MEDIA)->getAbsolutePath();
        // $mediaPath .= 'sampleimageuploader/images/image/';
        // if ( base64_decode($image, true) == true ){
        //     $dataBase64 = base64_decode($image);
        //     $f = finfo_open();
        //     $type = explode('/', finfo_buffer($f, $dataBase64, FILEINFO_MIME_TYPE))[1];
        //     $imageUrl = strtotime("now") . "-" . uniqid() . '.' . $type;
        //     file_put_contents($mediaPath . $imageUrl, $dataBase64);
        //     return '/' . $imageUrl;
        // }
        // return false;
        $mediaPath = $this->filesystem->getDirectoryRead($this->directoryList::MEDIA)->getAbsolutePath();
        $mediaPath .= 'sampleimageuploader/images/image/';
        if ( base64_decode($image['tmp_name'], true) == true ){
            $type = explode('/', $image["type"])[1];
            $imageUrl = strtotime("now") . "-" . uniqid() . '.' . $type;
            $mediaPath .= $imageUrl;
            move_uploaded_file($image['tmp_name'], $mediaPath);
            return '/' . $imageUrl;
        }
        return false;
    }

    public function deleteImage($image)
    {
        $mediaRootDir = $this->filesystem->getDirectoryRead($this->directoryList::MEDIA)->getAbsolutePath();
        $mediaRootDir .= "sampleimageuploader/images/image";
        if ( $image ){
            if ($this->file->isExists($mediaRootDir . $image) ){
                $this->file->deleteFile($mediaRootDir . $image);
            }
        }
    }

    public function validateDate($data)
    {
        try {
            if ( isset($data['from_date']) ){
                $filterValues = ['from_date' => $this->dateFilter];
            }
            if ( isset($data['to_date']) && $data['to_date'] ){
                $filterValues['to_date'] = $this->dateFilter;
            }
            if ( isset($filterValues) ){
                $inputFilter = new \Zend_Filter_Input(
                    $filterValues,
                    [],
                    $data
                );
                return $inputFilter->getUnescaped();
            }
            return $data;
        }
        catch ( \Exception $e ){
            return false;
        }
    }

    public function getCategoryById($id){
        return $this->categoryRepository->get($id);
    }

}