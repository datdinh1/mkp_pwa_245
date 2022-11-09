<?php

namespace Wiki\VendorsImportExport\Controller\Vendors\Product;

use \Magento\ImportExport\Model\Import ;
use Magento\Framework\App\ObjectManager;

class ImportProduct extends \Wiki\Vendors\Controller\Vendors\Action
{
    public function __construct(
        \Wiki\Vendors\App\Action\Context $context,
        \Magento\Framework\File\Csv $csv,
        \Magento\ImportExport\Model\Import $importModel,
        \Magento\ImportExport\Model\Import\ImageDirectoryBaseProvider $imageDirectoryBaseProvider = null
    ){
        parent::__construct($context);
        $this->csv = $csv;
        $this->importModel = $importModel;
        $this->imagesDirProvider = $imageDirectoryBaseProvider
            ?? ObjectManager::getInstance()->get(\Magento\ImportExport\Model\Import\ImageDirectoryBaseProvider::class);
    }

    public function execute()
    {
        $a = $this->getRequest()->getPostValue();
        if ( (isset($_FILES['import_file']['name'])) && ($_FILES['import_file']['name'] != '') ) {
            $csvData = $this->csv->getData($_FILES['import_file']['tmp_name']);
            $bunch[] = array_combine($csvData[0], $csvData[1]);
            $i = 0;
            foreach($bunch as $index => $item){
                foreach($item as $key => $value){
                    if(is_string($value) & $key == "description"){
                        $bunch[$index][$key] = "";
                    }
                }
                $bunch[$index]["image"] = null;
                $bunch[$index]["image_label"] = null;
                $bunch[$index]["thumbnail"] = null;
                $bunch[$index]["thumbnail_label"] = null;
                $bunch[$index]["_media_image"] = null;
                $bunch[$index]["_media_image_label"] = null;
                $bunch[$index]["_media_is_disabled"] = null;
                $bunch[$index]["_store"] = null;
                $bunch[$index]["_attribute_set"] = "Default";
                $bunch[$index]["_product_websites"] = "base";
                $bunch[$index]["status"] = 1;
                $bunch[$index]["news_from_date"] = null;
                $bunch[$index]["news_to_date"] = null;
                $bunch[$index]["options_container"] = "Block after Info Column";
                $bunch[$index]["minimal_price"] = null;
                $bunch[$index]["msrp"] = null;
                $bunch[$index]["msrp_enabled"] = null;
                $bunch[$index]["special_from_date"] = null;
                $bunch[$index]["special_to_date"] = null;
                $bunch[$index]["min_qty"] = 0;
                $bunch[$index]["backorders"] = 0;
                $bunch[$index]["min_sale_qty"] = 1;
                $bunch[$index]["max_sale_qty"] = 10000;
                $bunch[$index]["notify_stock_qty"] = 1;
                $bunch[$index]["_related_sku"] = null;
                $bunch[$index]["_related_position"] = null;
                $bunch[$index]["_crosssell_sku"] = null;
                $bunch[$index]["_crosssell_position"] = null;
                $bunch[$index]["_upsell_sku"] = null;
                $bunch[$index]["_upsell_position"] = null;
                $bunch[$index]["meta_keyword"] = "test product category import";
                $bunch[$index]["price_type"] = null;
                $bunch[$index]["shipment_type"] = null;
                $bunch[$index]["price_view"] = null;
                $bunch[$index]["weight_type"] = null;
                $bunch[$index]["sku_type"] = null;
                $bunch[$index]["approval"] = "Approved";
                $bunch[$index]["vendor_id"] = "2";
            }
            $jsoncsvData = json_encode($bunch);
            $jsoncsvData1 = json_decode($jsoncsvData);
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
            $connection = $resource->getConnection();
            $tableName = $resource->getTableName('importexport_importdata');
            $sql = "TRUNCATE TABLE " . $tableName;
            $connection->query($sql);
            $sql = " INSERT INTO " . $tableName . " (entity , behavior, data) VALUES ('catalog_product', 'append' , '". $jsoncsvData ."')";
            $connection->query($sql);
            $data = [];
            $data['form_key'] = $_POST['form_key'];
            $data['entity'] = 'catalog_product';
            $data['behavior'] = 'append';
            $data['validation_strategy'] = 'validation-stop-on-errors';
            $data['allowed_error_count'] = '10';
            $data['_import_field_separator'] = ',';
            $data['_import_multiple_value_separator'] = ',';
            $data['_import_empty_attribute_value_constant'] = '__EMPTY__VALUE__';
            $data['import_images_file_dir'] = '';
            $this->importModel->setData($data);
            $this->importModel->setData('images_base_directory', $this->imagesDirProvider->getDirectory());
            $errorAggregator = $this->importModel->getErrorAggregator();
            $errorAggregator->initValidationStrategy(
                $this->importModel->getData(Import::FIELD_NAME_VALIDATION_STRATEGY),
                $this->importModel->getData(Import::FIELD_NAME_ALLOWED_ERROR_COUNT)
            );
            $this->importModel->importSource();
            $this->messageManager->addSuccess(__("Import product success."));
            $tableProduct = $resource->getTableName('catalog_product_entity');
            $sql = "Update " . $tableProduct . " Set vendor_id = 2 where sku = '". $bunch[$index]["sku"] . "'";
            $connection->query($sql);
            $this->_redirect('jobs/product/import');
            return;
       }
    }
}
