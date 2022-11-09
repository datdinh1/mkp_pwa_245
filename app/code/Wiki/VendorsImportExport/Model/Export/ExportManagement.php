<?php
namespace Wiki\VendorsImportExport\Model\Export;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Store\Model\Store;
use Magento\CatalogImportExport\Model\Import\Product as ImportProduct;
use Magento\ImportExport\Model\Import;

use Wiki\VendorsImportExport\Model\Export\AbstractExport;

class ExportManagement extends AbstractExport
{
    private $userDefinedAttributes = [];

    /**
     * @inheritdoc
     */
    public function exportProductByVendorId($vendorId)
    {
        $vendor = $this->vendorsModel->loadByIdentifier($vendorId);
        if ( !$vendor->getId() ) return false;

        try {
            $list = $this->sellerManagement->getItemsByVendorId($vendorId);
            $name = md5(microtime());
            $file = $this->path . '/' . $name . '.csv';
            $this->directory->create($this->path);

            $stream = $this->directory->openFile($file, 'w+');
            $stream->lock();            

            $rawData = $this->rawData($list);
            $multirawData = $this->collectMultirawData();
            $stockItemRows = $this->prepareCatalogInventory(array_keys($rawData));
            $this->setColumnHeader($stockItemRows);
            
            $stream->writeCsv($this->_headerColumns);
            foreach ( $rawData as $data ){
                $rowData = array_merge($data, $stockItemRows[$data['product_id']]);
                $this->appendMultirowData($rowData, $multirawData);
                $stream->writeCsv( $this->_customFieldsMapping( $rowData ) );
            }

            $stream->unlock();
            $stream->close();
            $content = [
                "type" => "filename", // must keep filename
                "value" => $file,
                "rm" => true // remove csv from var folder
            ];
            $csvfilename = 'locator-export-' . $name . '.csv';
            return $this->fileFactory->create($csvfilename, $content, DirectoryList::VAR_DIR);
        } catch (\Exception $e) {
            return false;
        }
    }

    /* Header Columns */
    public function setColumnHeader($stockItemRows)
    {
        if ( !empty($stockItemRows) ){
            if ( reset($stockItemRows) ){
                $addData = array_keys(end($stockItemRows));
                foreach ( $addData as $key => $value ){
                    if ( is_numeric($value) ){
                        unset($addData[$key]);
                    }
                }
            }
        }
        if ( !$this->_headerColumns ){
            $this->_headerColumns = array_merge(
                [
                    self::COL_SKU,
                    self::COL_STORE,
                    self::COL_ATTR_SET,
                    self::COL_TYPE,
                    self::COL_CATEGORY,
                    self::COL_PRODUCT_WEBSITES,
                ],
                $this->_getExportMainAttrCodes(),
                [self::COL_ADDITIONAL_ATTRIBUTES],
                $addData,
                [
                    'related_skus',
                    'related_position',
                    'crosssell_skus',
                    'crosssell_position',
                    'upsell_skus',
                    'upsell_position',
                    'additional_images',
                    'additional_image_labels',
                    'hide_from_product_page',
                    'custom_options'
                ]
            );
            $this->_headerColumns = array_unique($this->_headerColumns);
            foreach ( $this->_headerColumns as $key => $code ){
                $fieldCode = isset($this->_fieldsMap[$code]) ? $this->_fieldsMap[$code] : null;
                if ( $fieldCode && $fieldCode != $code ){
                    $this->_headerColumns[$key] = $fieldCode;
                }
            }
        }
    }

    /**
     * @param array $rowData
     * @return array
     */
    protected function _customFieldsMapping($rowData)
    {
        $headerColumns = $this->_headerColumns;
        $rowData = parent::_customFieldsMapping($rowData);
        if ( count($headerColumns) != count(array_keys($rowData)) ){
            $newData = [];
            foreach ( $headerColumns as $code ){
                $fieldCode = isset($this->_fieldsMap[$code]) ? $this->_fieldsMap[$code] : null;
                if ( $fieldCode && isset($rowData[$fieldCode]) ){
                    $newData[$code] = $rowData[$fieldCode];
                } else {
                    if ( !isset($rowData[$code]) ){
                        $newData[$code] = '';
                    } else {
                        $newData[$code] = $rowData[$code];
                    }
                }
            }
            $rowData = $newData;
        }

        return $rowData;
    }

    protected function rawData($items)
    {
        $data = [];
        foreach ( $items as $item ){
            $itemId = $item->getId();
            $addtionalFields = [];
            $additionalAttributes = [];
            $productLinkId = $item->getData($this->getProductEntityLinkField());
            foreach ( $this->_getExportAttrCodes() as $attrCodes ){
                $attrValue = $item->getData($attrCodes);
                $attrValue = str_replace(array("\r\n", "\n\r", "\n", "\r"), '', $attrValue);
                if ( !$this->isValidAttributeValue($attrCodes, $attrValue) ){
                    continue;
                }

                if ( isset($this->_attributeValues[$attrCodes][$attrValue])
                    && !empty($this->_attributeValues[$attrCodes])
                ){
                    $attrValue = $this->_attributeValues[$attrCodes][$attrValue];
                }
                $fieldName = isset($this->_fieldsMap[$attrCodes]) ? $this->_fieldsMap[$attrCodes] : $attrCodes;

                if ( $this->_attributeTypes[$attrCodes] == 'datetime' ){
                    if ( in_array($attrCodes, $this->dateAttrCodes) || in_array($attrCodes, $this->userDefinedAttributes) ){
                        $attrValue = $this->_localeDate
                            ->formatDateTime(
                                new \DateTime($attrValue),
                                \IntlDateFormatter::SHORT,
                                \IntlDateFormatter::NONE,
                                null,
                                date_default_timezone_get()
                            );
                    } else {
                        $attrValue = $this->_localeDate
                            ->formatDateTime(
                                new \DateTime($attrValue),
                                \IntlDateFormatter::SHORT,
                                \IntlDateFormatter::SHORT
                            );
                    }
                }

                if ( $this->_attributeTypes[$attrCodes] !== 'multiselect' ){
                    if ( is_scalar($attrValue) ){
                        if ( !in_array($fieldName, $this->_getExportMainAttrCodes()) ){
                            $additionalAttributes[$fieldName] = $fieldName .
                                ImportProduct::PAIR_NAME_VALUE_SEPARATOR . $this->wrapValue($attrValue);
                        }
                        $data[$itemId][$fieldName] = htmlspecialchars_decode($attrValue);
                    }
                }
            }
            if ( !empty($additionalAttributes) ){
                $additionalAttributes = array_map('htmlspecialchars_decode', $additionalAttributes);
                $data[$itemId][self::COL_ADDITIONAL_ATTRIBUTES] =
                    implode(Import::DEFAULT_GLOBAL_MULTI_VALUE_SEPARATOR, $additionalAttributes);
            } else {
                unset($data[$itemId][self::COL_ADDITIONAL_ATTRIBUTES]);
            }

            if ( !empty($data[$itemId]) ){
                $attrSetId = $item->getAttributeSetId();
                $data[$itemId][self::COL_ATTR_SET] = $this->_attrSetIdToName[$attrSetId];
                $data[$itemId][self::COL_TYPE] = $item->getTypeId();
            }
            if ( !empty($addtionalFields) ){
                foreach ( $addtionalFields as $key => $value ){
                    $data[$itemId][$key] = $value;
                }
            }
            $data[$itemId][self::COL_SKU] = htmlspecialchars_decode($item->getSku());
            $data[$itemId]['product_id'] = $itemId;
            $data[$itemId]['store_id'] = 1;
            $data[$itemId]['product_link_id'] = $productLinkId;            
        }
        return $data;
    }

    private function wrapValue($value)
    {
        if ( !empty($this->_parameters[\Magento\ImportExport\Model\Export::FIELDS_ENCLOSURE]) ){
            $wrap = function ( $value ){
                return sprintf('"%s"', str_replace('"', '""', $value));
            };

            $value = is_array($value) ? array_map($wrap, $value) : $wrap($value);
        }

        return $value;
    }

    protected function appendMultirowData(&$dataRow, &$multiRawData)
    {
        $productId = $dataRow['product_id'];
        $productLinkId = $dataRow['product_link_id'];
        $storeId = $dataRow['store_id'];
        $sku = $dataRow[self::COL_SKU];

        unset($dataRow['product_link_id']);
        unset($dataRow['store_id']);
        unset($dataRow[self::COL_SKU]);
        unset($dataRow[self::COL_STORE]);

        $this->updateDataWithCategoryColumns($dataRow, $multiRawData['rowCategories'], $productId);
        if ( !empty($multiRawData['rowWebsites'][$productId]) ){
            $websiteCodes = [];
            foreach ( $multiRawData['rowWebsites'][$productId] as $productWebsite ){
                $websiteCodes[] = $this->_websiteIdToCode[$productWebsite];
            }
            $dataRow[self::COL_PRODUCT_WEBSITES] = implode(Import::DEFAULT_GLOBAL_MULTI_VALUE_SEPARATOR, $websiteCodes);
            $multiRawData['rowWebsites'][$productId] = [];
        }

        $multiRawData['mediaGalery'] = $this->getMediaGallery([$productLinkId]);
        if ( !empty($multiRawData['mediaGalery'][$productLinkId]) ){
            $additionalImages = [];
            $additionalLabels = [];
            $additionalImageIsDisabled = [];
            foreach ( $multiRawData['mediaGalery'][$productLinkId] as $mediaItem ){
                $additionalImages[] = $mediaItem['_media_image'];
                $additionalLabels[] = $mediaItem['_media_label'];
                if ( $mediaItem['_media_is_disabled'] == true ){
                    $additionalImageIsDisabled[] = $mediaItem['_media_image'];
                }
            }

            $dataRow['additional_images'] = implode(
                Import::DEFAULT_GLOBAL_MULTI_VALUE_SEPARATOR,
                $additionalImages
            );
            $dataRow['additional_image_labels'] = implode(
                Import::DEFAULT_GLOBAL_MULTI_VALUE_SEPARATOR,
                $additionalLabels
            );
            $dataRow['hide_from_product_page'] = implode(
                Import::DEFAULT_GLOBAL_MULTI_VALUE_SEPARATOR,
                $additionalImageIsDisabled
            );
            $multiRawData['mediaGalery'][$productLinkId] = [];
        }
        foreach ( $this->_linkTypeProvider->getLinkTypes() as $typeName => $linkId ){
            if ( !empty($multiRawData['linksRows'][$productLinkId][$linkId]) ){
                $colPrefix = $typeName . '_';
                $associations = [];
                foreach ( $multiRawData['linksRows'][$productLinkId][$linkId] as $linkData ){
                    if ( $linkData['default_qty'] !== null ){
                        $skuItem = $linkData['sku']
                            . ImportProduct::PAIR_NAME_VALUE_SEPARATOR
                            . $linkData['default_qty'];
                    } else {
                        $skuItem = $linkData['sku'];
                    }
                    $associations[$skuItem] = $linkData['position'];
                }
                $multiRawData['linksRows'][$productLinkId][$linkId] = [];
                asort($associations);
                $dataRow[$colPrefix . 'skus'] = implode(
                    Import::DEFAULT_GLOBAL_MULTI_VALUE_SEPARATOR,
                    array_keys($associations)
                );
                $dataRow[$colPrefix . 'position'] = implode(
                    Import::DEFAULT_GLOBAL_MULTI_VALUE_SEPARATOR,
                    array_values($associations)
                );
            }
        }
        $dataRow = $this->rowCustomizer->addData($dataRow, $productId);

        if ( !empty($this->collectedMultiselectsData[$storeId][$productLinkId]) ){
            foreach ( array_keys($this->collectedMultiselectsData[$storeId][$productLinkId]) as $attrKey ){
                if ( !empty($this->collectedMultiselectsData[$storeId][$productLinkId][$attrKey]) ){
                    $dataRow[$attrKey] =
                        implode(
                            Import::DEFAULT_GLOBAL_MULTI_VALUE_SEPARATOR,
                            $this->collectedMultiselectsData[$storeId][$productLinkId][$attrKey]
                        );
                }
            }
        }

        if ( !empty($multiRawData['customOptionsData'][$productLinkId][$storeId]) ){
            $customOptionsRows = $multiRawData['customOptionsData'][$productLinkId][$storeId];
            $multiRawData['customOptionsData'][$productLinkId][$storeId] = [];
            $customOptions = implode(ImportProduct::PSEUDO_MULTI_LINE_SEPARATOR, $customOptionsRows);

            $dataRow = array_merge(
                $dataRow,
                ['custom_options' => $customOptions]
            );
        }

        if ( empty($dataRow) ){
            return null;
        } elseif ( $storeId != Store::DEFAULT_STORE_ID ){
            $dataRow[self::COL_STORE] = $this->_storeIdToCode[$storeId];
        }
        $dataRow[self::COL_SKU] = $sku;

        return $dataRow;
    }

    protected function collectMultirawData()
    {
        $data = [];
        $productIds = [];
        $rowWebsites = [];
        $rowCategories = [];
        $productLinkIds = [];

        $entityCollection = $this->_getEntityCollection(true);
        $entityCollection->setStoreId(Store::DEFAULT_STORE_ID);
        $entityCollection->addCategoryIds()->addWebsiteNamesToResult();
        /** @var \Magento\Catalog\Model\Product $item */
        foreach ( $entityCollection as $item ){
            $productLinkIds[] = $item->getData($this->getProductEntityLinkField());
            $productIds[] = $item->getId();
            $rowWebsites[$item->getId()] = array_intersect(
                array_keys($this->_websiteIdToCode),
                $item->getWebsites()
            );
            $rowCategories[$item->getId()] = array_combine($item->getCategoryIds(), $item->getCategoryIds());
        }
        $entityCollection->clear();

        $categoryIds = array_merge(array_keys($this->_categories), array_keys($this->_rootCategories));
        $categoryIds = array_combine($categoryIds, $categoryIds);
        foreach ( $rowCategories as &$categories ){
            $categories = array_intersect_key($categories, $categoryIds);
        }

        $data['rowWebsites'] = $rowWebsites;
        $data['rowCategories'] = $rowCategories;
        $data['linksRows'] = $this->prepareLinks($productLinkIds);
        $data['customOptionsData'] = $this->getCustomOptionsData($productLinkIds);

        return $data;
    }
}
