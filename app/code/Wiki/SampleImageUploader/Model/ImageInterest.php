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
use Wiki\SampleImageUploader\Api\Data\ImageInterestInterface;

class ImageInterest extends AbstractModel implements ImageInterestInterface
{
    /**
     * Cache tag
     */
    const CACHE_TAG = 'wiki_interest_entity';

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
        $this->_init('Wiki\SampleImageUploader\Model\ResourceModel\ImageInterest');
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
     * Get customer id
     *
     * @return int
     */
    public function getCustomerId()
    {
        return $this->getData(ImageInterestInterface::CUSTOMER_ID);
    }

      /**
     * Get image id
     *
     * @return string
     */
    public function getImageId()
    {
        return $this->getData(ImageInterestInterface::IMAGE_ID);
    }


    /**
     * Get create at
     *
     * @return string
     */
    public function getCreateAt()
    {
        return $this->getData(ImageInterestInterface::CREATE_AT);
    }

            /**
     * Get update at 
     *
     * @return string
     */
    public function getUpdateAt()
    {
        return $this->getData(ImageInterestInterface::UPDATE_AT);
    }


    /**
     * Set title
     *
     * @param $customer
     * @return $this
     */
    public function setCustomerId($customer)
    {
        return $this->setData(ImageInterestInterface::CUSTOMER_ID, $customer);
    }

    /**
     * Set cateid
     *
     * @param $image
     * @return $this
     */
    public function setImageId($image)
    {
        return $this->setData(ImageInterestInterface::IMAGE_ID, $image);
    }


 


 /**
     * Set create
     *
     * @param $create
     * @return $this
     */
    public function setCreateAt($create)
    {
        return $this->setData(ImageInterestInterface::CREATE_AT, $create);
    }

     

    /**
     * Set update at
     *
     * @param $update
     * @return $this
     */
    public function setUpdateAt($update)
    {
        return $this->setData(ImageInterestInterface::UPDATE_AT, $update);
    }

  
}
