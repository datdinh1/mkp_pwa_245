<?php
namespace Wiki\VendorsImportExport\Model\Import;

use Magento\Framework\Stdlib\DateTime;
use Magento\Store\Model\Store;
use Magento\Catalog\Model\Product\Attribute\Backend\Sku;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\ImportExport\Model\Import\ErrorProcessing\ProcessingError;
use Magento\ImportExport\Model\Import\Entity\AbstractEntity;
use Magento\Eav\Model\Entity\Attribute\AbstractAttribute;

use Wiki\VendorsImportExport\Model\Import\AbstractImport;

class ImportManagement extends AbstractImport
{
    protected $productEntityLinkField;

    public function importProductByVendorId($vendorId)
    {
        $this->csv = $this->prepareCsvData($vendorId);
        $this->prepareProductEntity();
        $this->__saveProductEntity($this->entityRowsIn, $this->entityRowsUp);
        $this->_saveProductCategories($this->categoriesCache);
        $this->_saveProductWebsites($this->websitesCache);
        $this->_saveMediaGallery($this->mediaGallery);
        $this->_saveProductAttributes($this->attributes);
        $this->__saveStockItem();
        if ( !empty($this->configurableData) ){
            $this->saveConfigurationVariations($this->configurableData);
        }
        $this->reindexProducts();
    }

    protected function prepareCsvData($vendorId)
    {
        $data = $csvFileData = [];
        $vendor = $this->vendor->loadByIdentifier($vendorId);
        $vendorId = $vendor->getId();
        if ( !$vendorId ){
            throw new \Magento\Framework\Exception\LocalizedException(__('Seller does not exist.'));
        }
        
        if ( !count($_FILES) ){
            throw new \Magento\Framework\Exception\LocalizedException(__('Upload file does not exist.'));
        }
        foreach ( $_FILES as $file ){
            if ( isset($file['tmp_name']) && $file['type'] == "text/csv" ){
                $csvFileData[] = $this->csv->getData($file['tmp_name']);
            }
        }
        if ( !$csvFileData ){
            throw new \Magento\Framework\Exception\LocalizedException(__('Invalid file upload attempt.'));
        }
        try {
            foreach ( $csvFileData as $csvData ){
                foreach ( $csvData as $row => $rowData ){
                    if ( $row > 0 ){
                        $data[$row] = array_combine($csvData[0], $rowData);
                        $data[$row]["vendor_id"] = $vendorId;
                        if ( !isset($data[$row]["product_websites"]) ){
                            $data[$row]["_product_websites"] = $data[$row]["product_websites"];
                        }
                        else {
                            $data[$row]["_product_websites"] = "base";
                        }
                        if ( !isset($data[$row]["_attribute_set"]) ){
                            $data[$row]["_attribute_set"] = $data[$row]["attribute_set_code"];
                        }
                        if ( isset($data[$row]["additional_images"]) && !empty($data[$row]["additional_images"]) ){
                            $mediaImage = $data[$row]["additional_images"];
                        } elseif ( isset($data[$row]["base_image"]) && !empty($data[$row]["base_image"]) ){
                            $mediaImage = $data[$row]["base_image"];
                        } elseif ( isset($data[$row]["image"]) && !empty($data[$row]["image"]) ){
                            $mediaImage = $data[$row]["image"];
                        }
                        elseif ( isset($data[$row]["thumbnail"]) && !empty($data[$row]["thumbnail"]) ){
                            $mediaImage = $data[$row]["thumbnail"];
                        }
                        
                        $data[$row]["_media_image"] = isset($mediaImage) ? $mediaImage : "";
                        $data[$row]["image"] = isset($data[$row]["base_image"]) ? $data[$row]["base_image"] : "";
                        $data[$row]["thumbnail"] = isset($data[$row]["thumbnail_image"]) ? $data[$row]["thumbnail_image"] : "";
                    }
                }
            }
        }
        catch ( \Exception $e ){}

        if ( !$data ){
            throw new \Magento\Framework\Exception\LocalizedException(__('Invalid file upload attempt.'));
        }

        return $data;
    }

    protected function prepareProductEntity()
    {
        $entityLinkField = $this->getProductEntityLinkField();
        $productLimit = $productsQty = null;
        $this->entityRowsIn = $this->entityRowsUp = $this->configurableData = [];
        $this->websitesCache = $this->categoriesCache = $this->mediaGallery = $this->uploadedImages = $this->attributes = [];

        foreach ( $this->csv as $rowNum => $rowData ){
            $rowScope = $this->getRowScope($rowData);
            $rowSku = $this->getCorrectSkuAsPerLength($rowData);
            $checkSku = strtolower($rowSku);
            $rowData[self::URL_KEY] = $this->getUrlKey($rowData);

            $this->validateRow($rowData, $rowNum);

            if ( !$rowSku ){
                // $this->getErrorAggregator()->addRowToSkip($rowNum);
                continue;
            } elseif ( self::SCOPE_STORE == $rowScope ){
                // set necessary data from SCOPE_DEFAULT row
                $rowData[self::COL_TYPE] = $this->skuProcessor->getNewSku($checkSku)['type_id'];
                $rowData['attribute_set_id'] = $this->skuProcessor->getNewSku($checkSku)['attr_set_id'];
                $rowData[self::COL_ATTR_SET] = $this->skuProcessor->getNewSku($checkSku)['attr_set_code'];
            }

            if ( isset($rowData['attribute_set_code']) && isset($this->_attrSetNameToId[$rowData['attribute_set_code']]) ){
                $this->skuProcessor->setNewSkuData(
                    $this->getCorrectSkuAsPerLength($rowData),
                    'attr_set_id',
                    $this->_attrSetNameToId[$rowData['attribute_set_code']]
                );
            }

            $productType = isset($rowData[self::COL_TYPE]) ? strtolower($rowData[self::COL_TYPE]) :
                    $this->skuProcessor->getNewSku($this->getCorrectSkuAsPerLength($rowData))['type_id'];
            
            if ( !isset($this->_oldSku[$checkSku]) ){
                // new row
                if ( !$productLimit || $productsQty < $productLimit ){
                    if ( isset($rowData['has_options']) ){
                        $hasOptions = $rowData['has_options'];
                    } else {
                        $hasOptions = 0;
                    }
                    $this->entityRowsIn[$rowSku] = [
                        'attribute_set_id' => $this->skuProcessor->getNewSku($checkSku)['attr_set_id'],
                        'type_id' => $this->skuProcessor->getNewSku($checkSku)['type_id'],
                        'vendor_id' => $rowData["vendor_id"],
                        'sku' => $rowSku,
                        'has_options' => $hasOptions,
                        'created_at' => $this->_localeDate->date()->format(DateTime::DATETIME_PHP_FORMAT),
                        'updated_at' => $this->_localeDate->date()->format(DateTime::DATETIME_PHP_FORMAT),
                    ];
                    $productsQty++;
                } else {
                    $rowSku = null;
                    continue;
                }
            } else {
                $array = [
                    'updated_at' => $this->_localeDate->date()->format(DateTime::DATETIME_PHP_FORMAT),
                    $entityLinkField => $this->_oldSku[$checkSku][$entityLinkField],
                ];
                $array['attribute_set_id'] = $this->skuProcessor->getNewSku($checkSku)['attr_set_id'];
                $array['type_id'] = $productType;
                // existing row
                $this->entityRowsUp[] = $array;
            }

            // Product-to-Website
            $this->prepareRowDataProductWebsite($rowSku, $rowData);

            // Categories
            $this->prepareRowDataCategories($rowSku, $rowData);

            // MediaGallery
            $this->prepareRowDataMediaGallery($rowSku, $rowData);

            // ProductAttributes
            $this->prepareRowDataProductAttributes($rowSku, $rowData);

            // ConfigurableData
            $this->prepareConfigurableData($rowData);
        }
    }

    protected function prepareRowDataProductWebsite($rowSku, $rowData)
    {
        if (!array_key_exists($rowSku, $this->websitesCache)) {
            $this->websitesCache[$rowSku] = [];
        }

        if ( !empty($rowData[self::COL_PRODUCT_WEBSITES]) ){
            $websiteCodes = explode($this->getMultipleValueSeparator(), $rowData[self::COL_PRODUCT_WEBSITES]);
            foreach ( $websiteCodes as $websiteCode ){
                $websiteId = $this->storeResolver->getWebsiteCodeToId($websiteCode);
                $this->websitesCache[$rowSku][$websiteId] = true;
            }
        }
    }

    protected function prepareRowDataCategories($rowSku, $rowData)
    {
        if ( !array_key_exists($rowSku, $this->categoriesCache) ){
            $this->categoriesCache[$rowSku] = [];
        }
        $categoryIds = $this->getCategories($rowData);
        if ( isset($rowData['category_ids']) ){
            $catIds = \explode($this->getMultipleValueSeparator(), $rowData['category_ids']);
            $finalCatId = [];
            foreach ( $catIds as $catId ){
                $catId = (int)$catId;
                $existingCat = $this->categoryProcessor->getCategoryById($catId);
                if ( \is_int($catId) && $catId > 0 && $existingCat && $existingCat->getId() ){
                    $finalCatId[] = $catId;
                }
            }
            $categoryIds = \array_merge($categoryIds, $finalCatId);
        }
        foreach ( $categoryIds as $id ){
            $this->categoriesCache[$rowSku][$id] = true;
        }
    }

    protected function prepareRowDataMediaGallery($rowSku, &$rowData)
    {
        $existingImages = $this->getExistingImages($rowData);
        $storeIds = $this->getStoreIds();
        list($rowImages, $rowLabels) = $this->getImagesFromRow($rowData);
        $storeId = !empty($rowData[self::COL_STORE]) ? $this->getStoreIdByCode($rowData[self::COL_STORE]) : Store::DEFAULT_STORE_ID;
        $rowData[self::COL_MEDIA_IMAGE] = [];

        foreach ( $rowImages as $column => $columnImages ){
            foreach ( $columnImages as $position => $columnImage ){
                if ( isset($this->uploadedImages[$columnImage]) ){
                    $uploadedFile = $this->uploadedImages[$columnImage];
                } else {
                    $uploadedFile = $this->uploadMediaFiles(trim($columnImage), true);

                    if ( $uploadedFile ){
                        $this->uploadedImages[$columnImage] = $uploadedFile;
                    }
                }

                if ( $uploadedFile && $column !== self::COL_MEDIA_IMAGE ){
                    $rowData[$column] = $uploadedFile;
                }

                $imageNotAssigned = !isset($existingImages[$rowSku][$uploadedFile]);

                if ( $uploadedFile && $imageNotAssigned ){
                    if ( $column == self::COL_MEDIA_IMAGE ){
                        $rowData[$column][] = $uploadedFile;
                    }

                    foreach ( $storeIds as $storeId ){
                        $this->mediaGallery[$storeId][$rowSku][] = [
                            'attribute_id' => $this->getMediaGalleryAttributeId(),
                            'label' => isset($rowLabels[$column][$position]) ? $rowLabels[$column][$position] : '',
                            'position' => $position + 1,
                            'disabled' => isset($disabledImages[$columnImage]) ? '1' : '0',
                            'value' => $uploadedFile,
                        ];
                    }
                    $existingImages[$rowSku][$uploadedFile] = true;
                }
            }
        }
    }

    protected function prepareRowDataProductAttributes($rowSku, $rowData)
    {
        $rowScope = $this->getRowScope($rowData);
        $checkSku = strtolower($rowSku);
        
        $productType = isset($rowData[self::COL_TYPE]) ? strtolower($rowData[self::COL_TYPE]) :
                    $this->skuProcessor->getNewSku($this->getCorrectSkuAsPerLength($rowData))['type_id'];
        if ( !$productType ){
            $tempProduct = $this->skuProcessor->getNewSku($checkSku);
            if ( isset($tempProduct['type_id']) ){
                $productType = $tempProduct['type_id'];
            }
        }
        if ( $productType ){
            $productTypeModel = $this->_productTypeModels[$productType];
        }
        $rowData = $productTypeModel->prepareAttributesWithDefaultValueForSave(
            $rowData,
            !isset($this->_oldSku[$checkSku])
        );

        $rowStore = (self::SCOPE_STORE == $rowScope)
                    ? $this->storeResolver->getStoreCodeToId($rowData[self::COL_STORE])
                    : 0;

        foreach ( $rowData as $attrCode => $attrValue ){
            $attribute = $this->retrieveAttributeByCode($attrCode);
            $tempStore = $rowStore;
            if ( 'multiselect' != $attribute->getFrontendInput() && self::SCOPE_NULL == $rowScope ){
                // skip attribute processing for SCOPE_NULL rows
                continue;
            }
            $attrId = $attribute->getId();
            $backModel = $attribute->getBackendModel();
            $attrTable = $attribute->getBackend()->getTable();
            $storeIds = [0];

            if ( 'datetime' == $attribute->getBackendType() && strtotime($attrValue) ){
                $attrValue = $this->dateTime->gmDate(
                    'Y-m-d H:i:s',
                    $this->_localeDate->date($attrValue)->getTimestamp()
                );
            }

            $defaultValue = $this->getDefaultAttrValue($attribute, $rowSku);
            if ( $defaultValue && ($defaultValue == $attrValue) ){
                continue;
            }

            if ( self::SCOPE_STORE == $rowScope ){
                if ( self::SCOPE_WEBSITE == $attribute->getIsGlobal() ){
                    // check website defaults already set
                    if ( !isset($this->attributes[$attrTable][$rowSku][$attrId][$tempStore]) ){
                        $storeIds = $this->storeResolver->getStoreIdToWebsiteStoreIds($tempStore);
                    }
                } elseif ( self::SCOPE_STORE == $attribute->getIsGlobal() ){
                    $storeIds = [$tempStore];
                }

                if ( !isset($this->_oldSku[$checkSku]) ){
                    $storeIds[] = 0;
                }
            }
            sort($storeIds);

            foreach ( $storeIds as $storeId ){
                if (
                    isset($this->attributes[$attrTable][$rowSku][$attrId][0]) &&
                    ($this->attributes[$attrTable][$rowSku][$attrId][0] == $attrValue)
                ){
                    continue;
                }

                if ( !isset($this->attributes[$attrTable][$rowSku][$attrId][$storeId]) ){
                    $this->attributes[$attrTable][$rowSku][$attrId][$storeId] = $attrValue;
                }
            }
            // restore 'backend_model' to avoid 'default' setting
            $attribute->setBackendModel($backModel);
            $attributes = $this->attributes;
        }
    }

    protected function prepareConfigurableData($rowData)
    {
        if ( isset($rowData['product_type']) && ($rowData['product_type'] == 'simple' || $rowData['product_type'] == 'virtual') ){
            $field = "configurable_parent_sku";
            $configurableParentSku = null;
            if ( isset($rowData[$field]) && $rowData[$field] ){
                $configurableParentSku = $rowData[$field];
            }

            if ( $configurableParentSku ){
                $arrayConfigurable = [];
                if ( isset($rowData['configurable_variations']) && $rowData['configurable_variations'] ){
                    $explode = explode(",", preg_replace("/\s+/", "", $rowData['configurable_variations']));
                    foreach ( $explode as $attributeField ){
                        if ( isset($rowData[$attributeField]) && $rowData[$attributeField] ){
                            $arrayConfigurable[$attributeField] = $rowData[$attributeField];
                        }
                    }
                }

                if ( !empty($arrayConfigurable) ){
                    $arrayConfigurable['sku'] = $rowData['sku'];
                    $this->configurableData[$configurableParentSku][] = $arrayConfigurable;
                }
            }
        }
    }

    /**
     * @param array $entityRowsIn
     */
    protected function __saveProductEntity(array $entityRowsIn, array $entityRowsUp)
    {
        static $entityTable = null;
        if ( !$entityTable ){
            $entityTable = $this->_resourceFactory->create()->getEntityTable();
        }
        if ( $entityRowsUp ){
            $this->countItemsUpdated += count($entityRowsUp);
            $this->_connection->insertOnDuplicate($entityTable, $entityRowsUp,
                ['type_id', 'updated_at', 'attribute_set_id']);
        }

        $entityRowsUp = [];

        try {
            $this->_connection->beginTransaction();
            $result = parent::saveProductEntity($entityRowsIn, $entityRowsUp);
            $this->_connection->commit();
            return $result;
        } catch (\Exception $e) {
            $this->_connection->rollBack();
            throw $e;
        }
        return $this;
    }

    /**
     * @param array $websiteData
     * @param null $productId
     * @param bool $config
     *
     * @return $this|\Magento\CatalogImportExport\Model\Import\Product
     */
    protected function _saveProductWebsites(array $websiteData, $productId = null, $config = false)
    {
        static $productWebsiteTable = null;
        $removeWebsite = 0;
        if ( $removeWebsite || $productId ){
            if ( !$productWebsiteTable ){
                $productWebsiteTable = $this->_resourceFactory->create()->getProductWebsiteTable();
            }
            if ( $websiteData ){
                $newWebsiteData = [];
                $deletedProductIds = [];

                foreach ( $websiteData as $productSku => $productWebsites ){
                    if ( !$config ){
                        $productId = $this->skuProcessor->getNewSku($productSku)['entity_id'];
                    }
                    $deletedProductIds[] = $productId;
                    if ( $config ){
                        foreach ( $productWebsites as $websiteId ){
                            $newWebsiteData[] = ['product_id' => $productId, 'website_id' => $websiteId];
                        }
                    } else {
                        foreach ( array_keys($productWebsites) as $websiteId ){
                            $newWebsiteData[] = ['product_id' => $productId, 'website_id' => $websiteId];
                        }
                    }

                }
                $this->_connection->delete(
                    $productWebsiteTable,
                    $this->_connection->quoteInto('product_id IN (?)', $deletedProductIds)
                );

                if ( $newWebsiteData ){
                    $this->_connection->insertOnDuplicate($productWebsiteTable, $newWebsiteData);
                }
            }
            return $this;
        }
        return parent::_saveProductWebsites($websiteData);
    }

    /**
     * Stock item saving.
     *
     * @return $this
     */
    protected function __saveStockItem()
    {
        $this->productIdsToReindex = $stockData = [];
        // Format bunch to stock data rows
        foreach ( $this->csv as $rowNum => $rowData ){
            if ( !$this->isRowAllowedToImport($rowData, $rowNum) ){
                continue;
            }

            $row = [];
            $sku = $rowData[self::COL_SKU];
            if ( $this->skuProcessor->getNewSku($sku) !== null ){
                $row = $this->formatStockDataForRow($rowData);
                $this->productIdsToReindex[] = $row['product_id'];
            }

            if ( !isset($stockData[$sku]) ){
                $stockData[$sku] = $row;
            }
        }

        // Insert rows
        if ( !empty($stockData) ){
            $this->stockItemImporter->import($stockData);
        }

        return $this;
    }

    protected function saveConfigurationVariations($data)
    {
        foreach ( $data as $skuConf => $elements ){
            if ( count($elements) < 2 ){
                continue;
            }

            $websites = $additionalRows = $changeAttributes = [];
            $storeIds = $this->getStoreIds();
            $product = null;
            try {
                $collection = $this->collectionFactory->create()
                    ->addFieldToFilter('sku', $skuConf)
                    ->addFieldToFilter('type_id', 'configurable')
                    ->addAttributeToSelect('*');
                if ( $collection->getSize() ){
                    $product = $collection->getFirstItem();
                    if ( $product->getName() == $skuConf ){
                        $collectionChild = $this->collectionFactory->create();
                        $collectionChild->addFieldToFilter('sku', $elements[0][self::COL_SKU])->addAttributeToSelect('*');
                        $child = $collectionChild->getFirstItem();
                        $websites[$skuConf] = $child->getWebsiteIds();
                    }
                    if ( $product->getTypeId() != 'configurable' ){
                        $product->setTypeId('configurable');
                        $product = $this->productRepository->save($product);
                    }
                }

                $vars = $attributes = [];
                $attributeChange = $this->retrieveAttributeByCode('visibility');
                $attrTable = $attributeChange->getBackend()->getTable();
                $attrValue = 1;
                $attrId = $attributeChange->getId();
                foreach ( $elements as $element ){
                    $position = 0;
                    foreach ( $element as $key => $field ){
                        if ( $key != 'sku' && !empty($field) ){
                            if ( !in_array($key, $attributes) ){
                                $attributes[] = $key;
                            }
                            $vars['fields'][] = [
                                'code' => $key,
                                'value' => $field,
                            ];
                        } else {
                            $vars[$key] = $field;
                            if ( $key == 'sku' ){
                                foreach ( $storeIds as $storeId ){
                                    if ( !isset($changeAttributes[$attrTable][$field][$attrId][$storeId]) ){
                                        $changeAttributes[$attrTable][$field][$attrId][$storeId] = $attrValue;
                                    }
                                }
                            }
                        }
                    }
                    $vars['position'] = $position;
                    $position++;
                    $additionalRows[] = $vars;
                }

                $attributeValues = $ids = $configurableAttributesData = [];
                $position = 0;
                foreach ( $attributes as $attribute ){
                    foreach ( $additionalRows as $list ){
                        $attributeCollection = $this->attributeFactory->create()->getCollection();
                        $attributeCollection->addFieldToFilter('attribute_code', $attribute);
                        $value = [];
                        if ( isset($list['fields']) ){
                            foreach ( $list['fields'] as $item ){
                                if ( $item['code'] == $attribute ){
                                    $value = $item['value'];
                                    $collection = $this->collectionFactory->create();
                                    $collection->addFieldToFilter('sku', $list['sku']);
                                    if ( !in_array($collection->getFirstItem()->getId(), $ids) ){
                                        $ids[] = $collection->getFirstItem()->getId();
                                    }
                                }
                            }
                        }
                        if ( $attributeCollection->getSize() ){
                            $attributeValues[$attribute][] = [
                                'label' => $attribute,
                                'attribute_id' => $attributeCollection->getFirstItem()->getId(),
                                'value_index' => $value,
                            ];
                        }
                    }
                    if ( $attributeCollection->getSize() ){
                        $attr = $attributeCollection->getFirstItem();
                        $configurableAttributesData[] =
                            [
                                'attribute_id' => $attr->getId(),
                                'code' => $attr->getAttributeCode(),
                                'label' => $attr->getStoreLabel(),
                                'position' => $position++,
                                'values' => $attributeValues[$attribute],
                            ];
                    }

                    /**
                     * Check if attributes was added to target attribute set.
                     */
                    if ( isset($product) && $product->getAttributeSetId() > 0 ){
                        $invalidAttributes = [];
                        $attributeSetId = $product->getAttributeSetId();
                        foreach ( $configurableAttributesData as $attribute ){
                            $attributeId = $attribute['attribute_id'];
                            $select = $this->_connection->select()
                                ->from(
                                    $this->getResource()->getTable('eav_entity_attribute'),
                                    'attribute_id'
                                )->where(
                                    'attribute_set_id = ?',
                                    $attributeSetId
                                )->where(
                                    'attribute_id = ?',
                                    $attributeId
                                );
                            $result = $this->_connection->fetchCol($select);
                            if ( empty($result) ){
                                $invalidAttributes[] = $attribute['code'];
                            }
                        }
                        // if ( !empty($invalidAttributes) ){
                        //     throw new \Magento\Framework\Exception\LocalizedException(
                        //         __("Attributes '%1' is not attached to related attribute set.",
                        //             implode(', ', $invalidAttributes))
                        //     );
                        // }
                    }

                    if ( !empty($websites) ){
                        $this->_saveProductWebsites($websites, $product->getId(), true);
                    }
                    if ( !empty($changeAttributes) ){
                        $this->_saveProductAttributes($changeAttributes);
                    }
                    $this->saveCollectData($product, $configurableAttributesData, $ids);
                }
            }
            catch ( \Exception $e ){}
        }
        return $this;
    }

    public function saveCollectData($product, $configurableAttributesData, $ids)
    {
        $productId = ($product->getRowId()) ? $product->getRowId() : $product->getId();

        $connection = $this->_connection;
        $resource = $this->_resourceFactory->create();
        $table = $resource->getTable('catalog_product_super_attribute');
        $labelTable = $resource->getTable('catalog_product_super_attribute_label');
        $linkTable = $resource->getTable('catalog_product_super_link');
        $relationTable = $resource->getTable('catalog_product_relation');

        $select = $connection->select()->from(
            ['m' => $table],
            ['product_id', 'attribute_id', 'product_super_attribute_id']
        )->where(
            'm.product_id IN ( ? )',
            [$productId]
        );
        $counts = count($connection->fetchAll($select));
        if ( !$counts ){
            foreach ( $configurableAttributesData as $elem ){
                $data = [
                    'product_id' => $productId,
                    'attribute_id' => $elem['attribute_id'],
                    'position' => $elem['position'],
                ];
                $connection->insertOnDuplicate($table, $data);
            }


            foreach ( $connection->fetchAll($select) as $row ){
                $attrId = $row['attribute_id'];
                $superId = $row['product_super_attribute_id'];
                foreach ( $configurableAttributesData as $elem ){
                    if ( $elem['attribute_id'] == $attrId ){
                        $data = ['product_super_attribute_id' => $superId, 'value' => $elem['label']];
                        $connection->insertOnDuplicate($labelTable, $data);
                    }
                }
            }
        }
        foreach ( $ids as $id ){
            $data = ['product_id' => $id, 'parent_id' => $productId];
            $connection->insertOnDuplicate($linkTable, $data);
            $relData = ['child_id' => $id, 'parent_id' => $productId];
            $connection->insertOnDuplicate($relationTable, $relData);
        }
    }

    protected function reindexProducts()
    {
        if ( $this->productIdsToReindex ){
            foreach ($this->indexersFactory as $indexer) {
                $indexer->reindexList($this->productIdsToReindex);
            }
        }
    }

    /**
     * Format row data to DB compatible values.
     *
     * @param array $rowData
     * @return array
     */
    protected function formatStockDataForRow(array $rowData): array
    {
        $sku = $rowData[self::COL_SKU];
        $row['product_id'] = $this->skuProcessor->getNewSku($sku)['entity_id'];
        $row['website_id'] = $this->stockConfiguration->getDefaultScopeId();
        $row['stock_id'] = $this->stockRegistry->getStock($row['website_id'])->getStockId();

        $stockItemDo = $this->stockRegistry->getStockItem($row['product_id'], $row['website_id']);
        $existStockData = $stockItemDo->getData();

        if ( isset($rowData['qty']) && $rowData['qty'] == 0 && !isset($rowData['is_in_stock']) ){
            $rowData['is_in_stock'] = 0;
        }

        $row = array_merge(
            $this->defaultStockData,
            array_intersect_key($existStockData, $this->defaultStockData),
            array_intersect_key($rowData, $this->defaultStockData),
            $row
        );

        if ( $this->stockConfiguration->isQty($this->skuProcessor->getNewSku($sku)['type_id']) ){
            $stockItemDo->setData($row);
            $row['is_in_stock'] = $row['is_in_stock'] ?? $this->stockStateProvider->verifyStock($stockItemDo);
            if ( $this->stockStateProvider->verifyNotification($stockItemDo) ){
                $date = $this->dateTimeFactory->create('now', new \DateTimeZone('UTC'));
                $row['low_stock_date'] = $date->format(DateTime::DATETIME_PHP_FORMAT);
            }
            $row['stock_status_changed_auto'] = (int)!$this->stockStateProvider->verifyStock($stockItemDo);
        } else {
            $row['qty'] = 0;
        }

        return $row;
    }

    /**
     * @param array $rowData
     * @return mixed
     */
    protected function getCorrectSkuAsPerLength(array $rowData)
    {
        return $rowData[self::COL_SKU];
        // wrong character utf-8
        return \strlen($rowData[self::COL_SKU]) > Sku::SKU_MAX_LENGTH ?
            \substr($rowData[self::COL_SKU], 0,
                Sku::SKU_MAX_LENGTH) : $rowData[self::COL_SKU];
    }

    /**
     * Get product entity link field
     * @return string
     */
    protected function getProductEntityLinkField()
    {
        if ( !$this->productEntityLinkField ){
            $this->productEntityLinkField = $this->getMetadataPool()
                ->getMetadata(ProductInterface::class)
                ->getLinkField();
        }
        return $this->productEntityLinkField;
    }

    protected function getCategories($rowData)
    {
        if ( isset($rowData[self::COL_STORE]) ){
            $this->customCategoryProcessor->setStoreId($this->storeResolver->getStoreCodeToId($rowData[self::COL_STORE]));
        }
        $ids = $this->customCategoryProcessor->getRowCategories($rowData, ",");
        // foreach ( $this->customCategoryProcessor->getFailedCategories() as $error ){
        //     $this->errorAggregator->addError(
        //         AbstractEntity::ERROR_CODE_CATEGORY_NOT_VALID,
        //         ProcessingError::ERROR_LEVEL_NOT_CRITICAL,
        //         $rowData['rowNum'],
        //         self::COL_CATEGORY,
        //         __('Category "%1" has not been created.', $error['category'])
        //         . ' ' . $error['exception']->getMessage()
        //     );
        // }

        return $ids;
    }

    /**
     * @param array $rowData
     *
     * @return string
     */
    protected function getUrlKey($rowData)
    {
        $url = '';
        if ( !empty($rowData[self::URL_KEY]) ){
            $url = strtolower($rowData[self::URL_KEY]);
        } elseif ( !empty($rowData[self::COL_NAME]) ){
            $url = strtolower($rowData[self::COL_NAME]);
        }
        $url = $this->productUrl->formatUrlKey($url);

        return $url;
    }

    /**
     * @return array
     */
    protected function getStoreIds()
    {
        $storeIds = \array_merge(\array_keys($this->storeManager->getStores()), [0]);
        return $storeIds;
    }

    /**
     * Retrieve default attribute value (where store_id = 0)
     *
     * @param AbstractAttribute $attribute
     * @param string $sku
     *
     * @return bool|string
     */
    protected function getDefaultAttrValue(AbstractAttribute $attribute, $sku)
    {
        if ( !isset($this->_oldSku[strtolower($sku)]) ){
            return false;
        }

        $linkField = $this->getProductEntityLinkField();
        $linkId = $this->_oldSku[strtolower($sku)][$linkField];

        $bind = [
            'attribute_id' => $attribute->getId(),
            'store_id' => 0,
            $linkField => $linkId,
        ];

        $select = $this->_connection->select()
            ->from($attribute->getBackend()->getTable(), 'value')
            ->where('attribute_id = :attribute_id')
            ->where('store_id = :store_id')
            ->where($linkField . ' = :' . $linkField);

        return $this->_connection->fetchOne($select, $bind);
    }
}