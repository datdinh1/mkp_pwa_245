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
interface ImageInterestInterface
{
    const ENTITY_ID          = 'entity_id';
    const CUSTOMER_ID        = 'customer_id';
    const IMAGE_ID           = 'image_id';

    const CREATE_AT          = 'created_at';
    const UPDATE_AT          = 'update_at';
    
    
     
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
    public function getCustomerId();

    /**
     * Get image
     *
     * @return string
     */
    public function getImageId();


    /**
     * @return string|null
     */
    public function getCreateAt();

            /**
     * @return string|null
     */
    public function getUpdateAt();


    /**
     * Set ID
     *
     * @param $id
     * @return $this
     */
    public function setId($id);

    /**
     * Set ID
     *
     * @param int $customer
     * @return $this
     */
    public function setCustomerId($customer);

     /**
     * Set ID
     *
     * @param  string $image
     * @return $this
     */
    public function setImageId($image);


    /**
     * Set image
     *
     * @param string $create
     * @return $this
     */
    public function setCreateAt($create);

        /**
     * Set image
     *
     * @param string $update
     * @return $this
     */
    public function setUpdateAt($update);

    
}
