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

use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\StateException;
use Magento\Framework\Exception\ValidatorException;
use Magento\Framework\Exception\NoSuchEntityException;
use Wiki\SampleImageUploader\Api\ImageRepositoryInterface;
use Wiki\SampleImageUploader\Api\Data\ImageInterface;
use Wiki\SampleImageUploader\Api\Data\ImageInterfaceFactory;
use Wiki\SampleImageUploader\Model\ResourceModel\Image as ResourceImage;
use Wiki\SampleImageUploader\Model\ResourceModel\Image\CollectionFactory as ImageCollectionFactory;
use Wiki\SampleImageUploader\Api\Data\ImageInterestInterface;
use Wiki\SampleImageUploader\Model\ResourceModel\ImageInterest as ResourceImageInterest;
use Wiki\SampleImageUploader\Model\ImageInterestFactory;
use Wiki\SampleImageUploader\Model\Api\Data\CustomInterestFactory;

class ImageRepository implements ImageRepositoryInterface
{
    /**
     * @var array
     */
    protected $instances = [];
    /**
     * @var ResourceImage
     */
    protected $resource;

    /**
     * @var ResourceImageInterest
     */
    protected $resourceInterest;

    /**
     * @var ImageCollectionFactory
     */
    protected $imageCollectionFactory;

    /**
     * @var ImageInterfaceFactory
     */
    protected $imageInterfaceFactory;

    /**
     * @var ImageInterestFactory
     */
    protected $imageInterestFactory;
    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;


    protected $customerModel;

    public function __construct(
        ResourceImage $resource,
        ResourceImageInterest $resourceInterest,
        ImageCollectionFactory $imageCollectionFactory,
        ImageInterfaceFactory $imageInterfaceFactory,
        ImageInterestFactory $imageInterestFactory,
        DataObjectHelper $dataObjectHelper,
        \Magento\Customer\Model\Customer $customerModel,
        \Wiki\Vendors\Model\Vendor $vendorsModel,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        CustomInterestFactory $customInterest
    ) {
        $this->_vendorsModel                = $vendorsModel;
        $this->resource = $resource;
        $this->resourceInterest = $resourceInterest;
        $this->imageCollectionFactory = $imageCollectionFactory;
        $this->imageInterfaceFactory = $imageInterfaceFactory;
        $this->imageInterestFactory = $imageInterestFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->_storeManager = $storeManager;
        $this->_customerModel               = $customerModel;
        $this->customInterest               = $customInterest;
    }

    /**
     * @param ImageInterface $image
     * @return ImageInterface
     * @throws CouldNotSaveException
     */
    public function save(ImageInterface $image)
    {
        try {
            /** @var ImageInterface|\Magento\Framework\Model\AbstractModel $image */
            $this->resource->save($image);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the image: %1',
                $exception->getMessage()
            ));
        }
        return $image;
    }

    /**
     * Get image record
     *
     * @param $imageId
     * @return mixed
     * @throws NoSuchEntityException
     */
    public function getById($imageId)
    {
        if (!isset($this->instances[$imageId])) {
            $image = $this->imageInterfaceFactory->create();
            $this->resource->load($image, $imageId);
            if (!$image->getId()) {
                throw new NoSuchEntityException(__('Requested image doesn\'t exist'));
            }
            $this->instances[$imageId] = $image;
        }
        return $this->instances[$imageId];
    }

    /**
     * @param ImageInterface $image
     * @return bool
     * @throws CouldNotSaveException
     * @throws StateException
     */
    public function delete(ImageInterface $image)
    {
        /** @var \Wiki\SampleImageUploader\Api\Data\ImageInterface|\Magento\Framework\Model\AbstractModel $image */
        $id = $image->getId();
        try {
            unset($this->instances[$id]);
            $this->resource->delete($image);
        } catch (ValidatorException $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        } catch (\Exception $e) {
            throw new StateException(
                __('Unable to remove image %1', $id)
            );
        }
        unset($this->instances[$id]);
        return true;
    }

    /**
     * @param $imageId
     * @return bool
     */
    public function deleteById($imageId)
    {
        $image = $this->getById($imageId);
        return $this->delete($image);
    }

    /**
     *
     * @return \Wiki\SampleImageUploader\Api\Data\ImageInterface
     */
    public function getDataImage()
    {
        try {
            $image = $this->imageInterfaceFactory->create();
            $array = $image->getCollection()->getData();

            if (count($array) == 0) {
                return "This is not image.";
            } else {
                $mediaUrl = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
                $result =  $array;
                $mediaUrl = $mediaUrl . 'sampleimageuploader/images/image';

                foreach ($result as $key => $value) {
                    foreach ($value as $k => $v)
                        if ($k == 'image') {
                            $result[$key][$k] =  $mediaUrl . $v;
                        }
                }
                return $result;
            }
        } catch (AuthenticationException $e) {
            return "Invalid image.";
        }
    }

    /**
     * @param ImageInterestInterface $entity
     * @return ImageInterestInterface
     * @throws CouldNotSaveException
     * @throws StateException
     */
    public function apply(ImageInterestInterface $entity)
    {
        try {
            /** @var ImageInterestInterface|\Magento\Framework\Model\AbstractModel $image */
            $this->resourceInterest->save($entity);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the image interest: %1',
                $exception->getMessage()
            ));
        }
        return $entity;
    }

    /**
     * @param ImageInterestInterface $inter
     * @return bool
     * @throws CouldNotSaveException
     * @throws StateException
     */
    public function deleteInterestInterface(ImageInterestInterface $inter)
    {
        /** @var \Wiki\SampleImageUploader\Api\Data\ImageInterestInterface|\Magento\Framework\Model\AbstractModel $inter */
        $id = $inter->getId();
        try {
            unset($this->instances[$id]);
            $this->resourceInterest->delete($inter);
        } catch (ValidatorException $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        } catch (\Exception $e) {
            throw new StateException(
                __('Unable to remove image %1', $id)
            );
        }
        unset($this->instances[$id]);
        return true;
    }
    
    /**
     * @param $cusid
     * @return bool
     */
    public function deleteInterest($cusid)
    {
        $interest = $this->getInterestBycustomerId($cusid);
        return $this->deleteInterestInterface($interest);
    }

    public function renderInterfaceInterest($arr)
    {
        if (count($arr) > 0) {
            $customInter = $this->customInterest->create();
            $customInter->setGeneral($arr['general']);
            $customInter->setInfo($arr['info']);
            return $customInter;
        }
        return null;
    }

    /**
     * @inheritdoc
     */
    public function getInterestBycustomerId($cusid)
    {
        try {
            $tmp = [];
            $customer               = $this->_customerModel->load($cusid);
            if (count($customer->getData()) == 0) {
                return false;
            } else {
                if (!isset($this->instances[$cusid])) {
                    $interest   = $this->imageInterestFactory->create()->load($cusid, 'customer_id');;
                    $strImageId = $interest->getImageId();
                    $arrImageId = json_decode($strImageId, true);
                    $tmp["general"] =  $interest;
                    if (count($arrImageId) > 0) {
                        foreach ($arrImageId as $idImage) {

                            $infoImage =  $this->getById($idImage);
                            $tmp['info'][] =  $infoImage->getData();
                        }
                    } else {
                        return false;
                    }
                }
                return  $this->renderInterfaceInterest($tmp);
            }
        } catch (AuthenticationException $e) {
            return "Invalid login or password.";
        }
    }
}
