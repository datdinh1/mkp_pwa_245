<?php
namespace Wiki\VendorsProduct\Api\Data;

interface DataProductApiInterface
{
    /**
     * Constants used as data array keys
     */
    const PRODUCT               = 'product';
    const VENDOR_ID             = 'vendor_id';
    const DELETED_IMAGES        = 'deleted_images';
    const UPDATED_IMAGES        = 'uploaded_images';
    const SAVE_OPTIONS          = 'save_options';
    const CHILDREN              = 'children';
    /**
     * Get Product
     *
     * @return \Magento\Catalog\Api\Data\ProductInterface
     */
    public function getProduct();

    /**
     * Set Product
     *
     * @param \Magento\Catalog\Api\Data\ProductInterface $product
     *
     * @return $this
     */
    public function setProduct($product);

    /**
     * Get Vendor Id
     *
     * @return string $vendorId
     */
    public function getVendorId();

    /**
     * Set Vendor Id
     *
     * @param string $vendorId
     *
     * @return $this
     */
    public function setVendorId($vendorId);

    /**
     * Get Delete Image
     *
     * @return string[] $deletedImages
     */
    public function getDeletedImages();

    /**
     * Set Delete Image
     *
     * @param string[] $deletedImages
     *
     * @return $this
     */
    public function setDeletedImages($deletedImages);

    /**
     * Get Upload Image
     *
     * @return \Magento\Catalog\Api\Data\ProductAttributeMediaGalleryEntryInterface[] $uploadedImages
     */
    public function getUploadedImages();

    /**
     * Set Upload Image
     *
     * @param \Magento\Catalog\Api\Data\ProductAttributeMediaGalleryEntryInterface[] $uploadedImages
     *
     * @return $this
     */
    public function setUploadedImages($uploadedImages);

    /**
     * Get Save Options
     *
     * @return bool $saveOptions
     */
    public function getSaveOptions();

    /**
     * Set Save Options
     *
     * @param bool $saveOptions
     *
     * @return $this
     */
    public function setSaveOptions($saveOptions);

    /**
     * Get Children Product
     *
     * @return \Magento\Catalog\Api\Data\ProductInterface[] $product 
     */
    public function getChildren();

    /**
     * Set Children Product
     *
     * @param \Magento\Catalog\Api\Data\ProductInterface[] $product 
     *
     * @return $this
     */
    public function setChildren($product);
}