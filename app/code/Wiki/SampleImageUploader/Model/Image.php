<?php
/*
 * Wiki_SampleImageUploader

 * @category   Wiki
 * @package    Wiki_SampleImageUploader
 * @copyright  Copyright (c) 2017 Wiki
 * @license    https://github.com/Wiki/magento2-sample-imageuploader/blob/master/LICENSE.md
 * @version    1.0.0
 */
namespace Wiki\SampleImageUploader\Model;

use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;
use Magento\Framework\Exception\LocalizedException;
use Wiki\SampleImageUploader\Api\Data\ImageInterface;

class Image extends AbstractModel implements ImageInterface
{
    /**
     * Cache tag
     */
    const CACHE_TAG = 'Wiki_sampleimageuploader_image';

    /**
     * @var UploaderPool
     */
    protected $uploaderPool;

    /**
     * Sliders constructor.
     * @param Context $context
     * @param Registry $registry
     * @param UploaderPool $uploaderPool
     * @param AbstractResource|null $resource
     * @param AbstractDb|null $resourceCollection
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        UploaderPool $uploaderPool,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
        $this->uploaderPool    = $uploaderPool;
    }

    /**
     * Initialise resource model
     * @codingStandardsIgnoreStart
     */
    protected function _construct()
    {
        // @codingStandardsIgnoreEnd
        $this->_init('Wiki\SampleImageUploader\Model\ResourceModel\Image');
    }

    /**
     * Get cache identities
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->getData(ImageInterface::TITLE);
    }

      /**
     * Get title
     *
     * @return int
     */
    public function getCategoryId()
    {
        return $this->getData(ImageInterface::CATEGORY_ID);
    }

    /**
     * Set title
     *
     * @param $image
     * @return $this
     */
    public function setTitle($image)
    {
        return $this->setData(ImageInterface::TITLE, $image);
    }
 /**
     * Set cateid
     *
     * @param $cateid
     * @return $this
     */
    public function setCategoryId($cateid)
    {
        return $this->setData(self::CATEGORY_ID, $cateid);
    }


    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->getData(ImageInterface::IMAGE);
    }
     

    /**
     * Set image
     *
     * @param $image
     * @return $this
     */
    public function setImage($image)
    {
        return $this->setData(ImageInterface::IMAGE, $image);
    }

    /**
     * Get image URL
     *
     * @return bool|string
     * @throws LocalizedException
     */
    public function getImageUrl()
    {
        $url = false;
        $image = $this->getImage();
        if ($image) {
            if (is_string($image)) {
                $uploader = $this->uploaderPool->getUploader('image');
                $url = $uploader->getBaseUrl().$uploader->getBasePath().$image;
            } else {
                throw new LocalizedException(
                    __('Something went wrong while getting the image url.')
                );
            }
        }
        return $url;
    }
}
