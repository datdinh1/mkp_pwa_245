<?php
/*
 * Wiki_SampleImageUploader
 * @category   Wiki
 * @package    Wiki_SampleImageUploader
 */

namespace Wiki\SampleImageUploader\Api;

use Wiki\SampleImageUploader\Api\Data\ImageInterface;

use Magento\Framework\Exception\InputException;
use Wiki\SampleImageUploader\Api\Data\ImageInterestInterface;

/**
 * @api
 */
interface ImageRepositoryInterface
{
    /**
     * Save page.
     *
     * @param ImageInterface $image
     * @return ImageInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(ImageInterface $image);

    /**
     * Retrieve Image.
     *
     * @param int $imageId
     * @return ImageInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($imageId);

    /**
     * Delete image.
     *
     * @param ImageInterface $image
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(ImageInterface $image);

    /**
     * Delete image by ID.
     *
     * @param int $imageId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($imageId);


    /**
     * 
     * @return \Wiki\SampleImageUploader\Api\Data\ImageInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */

    public function getDataImage();

    /**
     * @param ImageInterestInterface $entity
     * @return \Wiki\SampleImageUploader\Api\Data\ImageInterestInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */

    public function apply(ImageInterestInterface $entity);

    /**
     * Delete interests by ID.
     *
     * @param int $interestId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteInterest($interestId);

    /**
     * @param int $customerId
     * @return \Wiki\SampleImageUploader\Api\Data\CustomInterestInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getInterestBycustomerId($customerId);
}
