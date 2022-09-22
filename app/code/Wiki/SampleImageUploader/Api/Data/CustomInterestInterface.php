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
interface CustomInterestInterface
{
    const GENERAL          = 'general';
    const INFO             = 'info';
    
    /**
     * Get General
     *
     * @return \Wiki\SampleImageUploader\Api\Data\ImageInterestInterface
     */
    public function getGeneral();

     /**
     * Get Info
     *
     * @return \Wiki\SampleImageUploader\Api\Data\ImageInterface[]
     */
    public function getInfo();



    /**
     * @param \Wiki\SampleImageUploader\Api\Data\ImageInterestInterface $value
     *
     * @return $this
     */
    public function setGeneral($value);

    /**
     * Set ID
     *
     * @param \Wiki\SampleImageUploader\Api\Data\ImageInterface[] $id
     * @return $this
     */
    public function setInfo($id);


    
}
