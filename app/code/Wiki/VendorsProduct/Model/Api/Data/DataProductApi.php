<?php
namespace Wiki\VendorsProduct\Model\Api\Data;

use Wiki\VendorsProduct\Api\Data\DataProductApiInterface;
use Magento\Framework\Model\AbstractModel;

/**
 * DataProductApi model
 */
class DataProductApi extends AbstractModel implements DataProductApiInterface
{
    /**
     * @inheritdoc
     */
    public function getProduct()
    {
        return $this->getData(self::PRODUCT);
    }

    /**
     * @inheritdoc
     */
    public function setProduct($product)
    {
        return $this->setData(self::PRODUCT, $product);
    }

    /**
     * @inheritdoc
     */
    public function getVendorId()
    {
        return $this->getData(self::VENDOR_ID);
    }

    /**
     * @inheritdoc
     */
    public function setVendorId($vendorId)
    {
        return $this->setData(self::VENDOR_ID, $vendorId);
    }

    /**
     * @inheritdoc
     */
    public function getDeletedImages()
    {
        return $this->getData(self::DELETED_IMAGES);
    }

    /**
     * @inheritdoc
     */
    public function setDeletedImages($deletedImages)
    {
        return $this->setData(self::DELETED_IMAGES, $deletedImages);
    }

    /**
     * @inheritdoc
     */
    public function getUploadedImages()
    {
        return $this->getData(self::UPDATED_IMAGES);
    }

    /**
     * @inheritdoc
     */
    public function setUploadedImages($updatedImages)
    {
        return $this->setData(self::UPDATED_IMAGES, $updatedImages);
    }

    /**
     * @inheritdoc
     */
    public function getSaveOptions()
    {
        return $this->getData(self::SAVE_OPTIONS);
    }

    /**
     * @inheritdoc
     */
    public function setSaveOptions($saveOptions)
    {
        return $this->setData(self::SAVE_OPTIONS, $saveOptions);
    }

     /**
     * @inheritdoc
     */
    public function getChildren()
    {
        return $this->getData(self::CHILDREN);
    }

    /**
     * @inheritdoc
     */
    public function setChildren($product)
    {
        return $this->setData(self::CHILDREN, $product);
    }
}