<?php

namespace MGS\Brand\Api;

use Exception;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\NoSuchEntityException;

interface BrandManagementInterface
{
    /**
     * @return \MGS\Brand\Api\Data\BrandInterface[]
     */
    public function getAllBrand();
    /**
     * @param int $idGroup
     * @return \MGS\Brand\Api\Data\BrandInterface[]
     */
    public function getAllByBrandMallPage($idGroup);

    /**
     * @return \Magento\Catalog\Api\Data\CategoryInterface[]
     */
    public function getListCategory();

    /**
     * @param int $categoryId
     * @return \MGS\Brand\Api\Data\BrandInterface[]
     */
    public function getListBrandByCategory($categoryId);

    /**
     * @return \MGS\Brand\Api\Data\BrandInterface[]
     */
    public function getListBrand();

    /**
     * @param int $brandId
     * @return \Magento\Catalog\Api\Data\ProductInterface[]
     */
    public function getProductByBrand($brandId);

    /**
     * @param \MGS\Brand\Api\Data\BrandInterface $entity
     * @return boolean
     */
    public function create($entity);

    /**
     * @param \MGS\Brand\Api\Data\BrandInterface $entity
     * @return boolean
     */
    public function update( $entity);

     /**
     * @param int $id
     * @return boolean
     */
    public function delete( $id);
}
