<?php

/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Wiki\VendorsProduct\Api;

use Magento\Framework\Exception\InputException;

/**
 * Interface for managing customers accounts.
 * @api
 * @since 100.0.2
 */
interface ProductManagementInterface
{
    /**
     * @param int $entity_id
     * @param int $value
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function setHideProduct($entity_id, $value);

    /**
     * @param int $entity_id
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function showProduct($entity_id);

    /**
     * Create product
     * @param \Wiki\VendorsProduct\Api\Data\DataProductApiInterface $data
     * @param bool $reindex
     * @return bool
     * @throws \Exception
     */
    public function save($data , $reindex = true);

    /**
     * Update product
     * @param string $sku
     * @param \Wiki\VendorsProduct\Api\Data\DataProductApiInterface $data
     * @return bool
     * @throws \Exception
     */
    public function update($sku, $data);

    /**
     * @param string $sku
     * @return bool
     * @throws \Exception
     */
    public function delete($sku);

    /**
     * @return \Magento\Catalog\Api\Data\ProductSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getAllBrand();

    /**
     * @param int $userId
     * @return \Magento\Catalog\Api\Data\ProductInterface[]
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function productBestSellerRecomend($userId);

    /**
     * 
     * @return \Wiki\VendorsProduct\Api\Data\CustomBestSellerInterface[]
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function listProductBestSellerByCategory();

    /**
     * @param int $idGroup
     * @param int|null $pageSize
     * @param int|null $currenPage
     * @param string|null $sortAlphaName
     * @param string|null $sortPrice
     * @return \Magento\Catalog\Api\Data\ProductInterface[]
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getProductMallPage($idGroup, $pageSize = null, $currenPage = null, $sortAlphaName = null, $sortPrice = null);

    /**
     * @param string $atrributeCode
     * @param int|null $pageSize
     * @param int|null $currenPage
     * @param string|null $sortAlphaName
     * @param string|null $sortPrice
     * @return \Magento\Catalog\Api\Data\ProductInterface[]
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getProductArrivalPage($atrributeCode, $pageSize = null, $currenPage = null, $sortAlphaName = null, $sortPrice = null);

    /**
     * Retrieve list of attribute options
     *
     * @param mixed $attributeCode
     * @return \Magento\Catalog\Api\Data\ProductAttributeInterface[]
     */
    public function getListAttributeCode($attributeCode);

    /**
     * Retrieve list of attribute options
     *
     * @param string $pre
     * @return \Magento\Catalog\Api\Data\ProductAttributeInterface[]
     */
    public function getListAttrsByPre($pre);

    /**
     * @param  int $size
     * @return \Magento\Catalog\Api\Data\ProductInterface[]
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function listProductBestSeller($size = null);

    /**
     * @param string|int $vendorId
     * @param string[] $skus
     * @return bool
     * @throws \Exception
     */
    public function massDelete($vendorId, array $skus);

    /**
     * Save attribute data
     *
     * @param string $frontendLabel
     * @param string $attributeCode
     * @param \Wiki\VendorsProduct\Api\Data\AttributeProductInterface[] $options
     *
     * @return \Magento\Catalog\Api\Data\ProductAttributeInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Exception\StateException
     */
    public function createAttribute($frontendLabel,$attributeCode, $options);

    
        /**
     * Create product configurable
     * @param \Wiki\VendorsProduct\Api\Data\DataProductApiInterface $data
     * @return bool
     * @throws \Exception
     */
    public function createProductConfigurable($data);

    /**
     * Create product configurable
     * @param \Wiki\VendorsProduct\Api\Data\DataProductApiInterface $data
     * @return bool
     * @throws \Exception
     */
    public function updateConfigurableProduct($data);

    /**
     * Create product configurable
     * @param int $productId
     * @param string $attributeCode
     * @param string $optionId
     * @return bool
     * @throws \Exception
     */
    public function deleteOptions($productId, $attributeCode, $optionId);
}
