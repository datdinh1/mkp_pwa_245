<?php

namespace MGS\Brand\Model\Api;

use MGS\Brand\Api\BrandManagementInterface;
use MGS\Brand\Model\Resource\Brand\CollectionFactory as BrandCollectionFactory;
use MGS\Brand\Model\Resource\Product\CollectionFactory as ProductCollectionFactory;
use MGS\Brand\Model\Brand;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Catalog\Model\Product\Url;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Driver\File;
use Magento\Framework\App\Filesystem\DirectoryList;
use Wiki\VendorsProduct\Model\ProductManagement;
use Magento\Framework\Exception\ValidatorException;
use MGS\Brand\Controller\Adminhtml\Brand\Save;
use Magento\Framework\Filesystem\Io\File as FileIo;

class BrandManagement implements BrandManagementInterface
{
    public $acceptTypes = array("png", "jpeg", "jpg", "pdf");

    /**
     * @var FileIo
     */
    protected $io;

    protected $brandCollectionFactory;
    protected $productCollectionFactory;
    protected $collectionFactory;
    protected $productManagement;
    protected $brand;
    protected $urlKey;
    protected $directoryList;
    protected $filesystem;
    protected $file;

    protected $resource;
    protected $categoryCollectionFactory;
    protected $saveBrand;

    public function __construct(
        FileIo $io,
        Save $saveBrand,
        BrandCollectionFactory $brandCollectionFactory,
        ProductCollectionFactory $productCollectionFactory,
        CollectionFactory $collectionFactory,
        ProductManagement $productManagement,
        Brand $brand,
        Url $urlKey,
        DirectoryList $directoryList,
        Filesystem $filesystem,
        File $file,

        \Magento\Framework\App\ResourceConnection $resource,
        \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoryCollectionFactory
    ) {
        $this->io                           = $io;
        $this->saveBrand                    = $saveBrand;
        $this->brandCollectionFactory       = $brandCollectionFactory;
        $this->productCollectionFactory     = $productCollectionFactory;
        $this->collectionFactory            = $collectionFactory;
        $this->productManagement            = $productManagement;
        $this->resource                     = $resource;
        $this->categoryCollectionFactory    = $categoryCollectionFactory;
        $this->brand                        = $brand;
        $this->urlKey                       = $urlKey;
        $this->directoryList                = $directoryList;
        $this->filesystem                   = $filesystem;
        $this->file                         = $file;
    }

    /**
     * @inheritDoc
     */
    public function getAllBrand()
    {
        return $this->brandCollectionFactory->create()->getItems();
    }

    /**
     * @inheritDoc
     */
    public function getAllByBrandMallPage($idGroup)
    {

        //get list id brand of product from mall page have id group
        $brandID = [];
        $listProductMall     = $this->productManagement->getProductMallPage($idGroup);
        foreach ($listProductMall as $productMall) {

            if (isset($productMall['mgs_brand']) && $productMall['mgs_brand'] != 0) {
                $brandID[] = $productMall['mgs_brand'];
            }
        }

        //get brand by id
        $result = [];
        if (count($brandID) > 0) {
            foreach ($brandID as $id) {
                $result[] =  $this->brandCollectionFactory->create()->getItemByColumnValue('option_id', $id)->getData();
            }
        }

        return $result;
    }

    /**
     * @inheritDoc
     */
    public function getListCategory()
    {
        $tableName = $this->resource->getTableName('mgs_brand_category');
        $connection = $this->resource->getConnection();

        $select = $connection->select()->distinct(true)->from($tableName, 'category_id');
        $categoryIds = $connection->fetchCol($select);
        if ($categoryIds) {
            $collection = $this->categoryCollectionFactory->create()->addAttributeToSelect('*');
            $collection->addIsActiveFilter();
            $collection->addAttributeToFilter('entity_id', $categoryIds);
            return $collection->getItems();
        }
        return [];
    }

    /**
     * @inheritDoc
     */
    public function getListBrandByCategory($categoryId)
    {
        $tableName = $this->resource->getTableName('mgs_brand_category');
        $connection = $this->resource->getConnection();

        $select = $connection->select()->from($tableName, 'brand_id')->where(
            "category_id = ?",
            (int)$categoryId
        );
        $brandIds = $connection->fetchCol($select);
        if ($brandIds) {
            $collection = $this->brandCollectionFactory->create()->addFieldToSelect('*');
            $collection->addFieldToFilter('brand_id', ['in' => $brandIds]);
            $collection->addFieldToFilter('status', 1);
            return $collection->getItems();
        }
        return [];
    }

    /**
     * @inheritDoc
     */
    public function getListBrand()
    {
        $collection = $this->brandCollectionFactory->create()->addFieldToSelect('*');
        $collection->addFieldToFilter('status', 1);
        $item = $collection->getItems();
        return  $item;
    }

    /**
     * @inheritDoc
     */
    public function getProductByBrand($brandId)
    {
        $tableName = $this->resource->getTableName('mgs_brand_product');
        $connection = $this->resource->getConnection();
        $select = $connection->select()->from($tableName, 'product_id')->where(
            "brand_id = ?",
            (int)$brandId
        );
        $productIds = $connection->fetchCol($select);
        if ($productIds) {
            $collection = $this->collectionFactory->create()->addAttributeToSelect('*');
            $collection->addFieldToFilter('entity_id', ['in' => $productIds]);
            $collection->joinAttribute('status', 'catalog_product/status', 'entity_id', null, 'inner');
            $collection->joinAttribute('visibility', 'catalog_product/visibility', 'entity_id', null, 'inner');
            return $collection->getItems();
        }
        return [];
    }

    public function checkBrandName($name)
    {
        $model = $this->brandCollectionFactory->create();
        $filter = $model->addFieldToFilter('name', $name);

        if ($filter->getSize() > 0) return true;
        return false;
    }
    public function create($entity)
    {
        /** check brand name exist */
        if ($this->checkBrandName($entity->getName())) {
            return false;
        }

        try {
            /** save image */
            if (!empty($entity->getImage())) {
                $mediaImage = $this->uploadImage($entity->getImage());
                $entity->setImage($mediaImage);
            }
            /** save small image */
            if ($entity->getSmallImage()) {
                $mediaSmallImage = $this->uploadImage($entity->getSmallImage());
                $entity->setSmallImage($mediaSmallImage);
            }
            $entity->save();
            $optionId = $this->saveBrand->saveOption('mgs_brand', $entity->getName(), (int)$entity->getOptionId());
            $entity->setOptionId($optionId);

            $entity->save();
        } catch (\Exception $e) {
            return false;
        }
        return true;
    }

    public function update($entity)
    {
        if (empty($entity->getName())) {
            return false;
        }

        if (is_array($entity->getProductIds())) {
            foreach ($entity->getProductIds() as $productId) {
                $productIds[$productId]['position'] = 0;
            }
            $entity->setProductIds($productIds);
        }
        $brand = $this->brand->load($entity->getId());
       
        if ($entity->getSmallImage() && $entity->getSmallImage() != '') {
            $mediaSmallImage = $this->uploadImage($entity->getSmallImage());
            if ($mediaSmallImage) {
                $this->deleteImage($brand->getSmallImage());
                $brand->setSmallImage($mediaSmallImage);
            }
        } else if ($entity->getSmallImage() && $entity->getSmallImage() == "") {
            $this->deleteImage($brand->getSmallImage());
            $brand->setSmallImage(null);
        }
        if ($entity->getImage()) {
            $image = $this->uploadImage($entity->getImage());
            if ($image) {
                $this->deleteImage($brand->getImage());
                $brand->setImage($image);
            }
        } else if ($entity->getImage() && $entity->getImage() == "") {
            $this->deleteImage($brand->getImage());
            $brand->setImage(null);
        }

        try {
            $brand->save();
        } catch (\Exception $e) {
            return false;
        }
        return true;
    }

    protected function uploadImage($image)
    {
        try {
            $base64 = base64_decode($image);
            $type = explode('/', finfo_buffer(finfo_open(), $base64, FILEINFO_MIME_TYPE))[1];
            $imageUrl =  strtotime("now") . "-" . uniqid() . '.' . $type;
            $path = $this->filesystem->getDirectoryRead($this->directoryList::MEDIA)->getAbsolutePath();
            if (!in_array($type, $this->acceptTypes)) {
                return false;
            }
            $media = 'mgs_brand/' . $imageUrl;

            file_put_contents($path . $media, $base64);
            return  $media;
        } catch (\Exception $e) {
            return false;
        }
    }

    protected function deleteImage($image)
    {
        $mediaDirectory = $this->filesystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath();
        $mediaDirectory .= "mgs_brand/";
        if ($image) {
            if ($this->file->isExists($mediaDirectory . $image)) {
                $this->file->deleteFile($mediaDirectory . $image);
            }
        }
    }

    public function delete($id)
    {

        try {
            $listProdut = $this->getProductByBrand($id);
            if (count($listProdut) > 0) return false;
            $brand = $this->brand->load($id);
            $brand->delete();
        } catch (ValidatorException $e) {
            return false;
        }
        return true;
    }
}
