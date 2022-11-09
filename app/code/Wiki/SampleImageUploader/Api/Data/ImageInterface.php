<?php
/*
 * Wiki_SampleImageUploader

 * @category   Wiki
 * @package    Wiki_SampleImageUploader
 * @copyright  Copyright (c) 2017 Wiki
 * @license    https://github.com/Wiki/magento2-sample-imageuploader/blob/master/LICENSE.md
 * @version    1.0.0
 */
namespace Wiki\SampleImageUploader\Api\Data;

/**
 * @api
 */
interface ImageInterface
{
    const ID                = 'image_id';
    const TITLE             = 'title';
    const IMAGE             = 'image';
    const CATEGORY_ID       = 'category_id';
    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId();

     /**
     * Get ID
     *
     * @return int|null
     */
    public function getCategoryId();

    /**
     * Get image
     *
     * @return string
     */
    public function getImage();

    /**
     * @return string
     */
    public function getTitle();

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setTitle($value);

    /**
     * Set ID
     *
     * @param $id
     * @return ImageInterface
     */
    public function setId($id);

     /**
     * Set ID
     *
     * @param $cateid
     * @return $this
     */
    public function setCategoryId($cateid);

    /**
     * Set image
     *
     * @param $image
     * @return ImageInterface
     */
    public function setImage($image);

    
}
