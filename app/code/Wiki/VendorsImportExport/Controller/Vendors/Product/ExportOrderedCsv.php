<?php

namespace Wiki\VendorsImportExport\Controller\Vendors\Product;

use Magento\Framework\App\ResponseInterface;
use Magento\Framework\App\Filesystem\DirectoryList;

class ExportOrderedCsv extends \Wiki\Vendors\Controller\Vendors\Action
{

    /**
     * @var \Magento\Framework\App\Response\Http\FileFactory
     */
    protected $_fileFactory;

    /**
     * @param \Wiki\Vendors\App\Action\Context $context,
     * @param \Magento\Framework\App\Response\Http\FileFactory $fileFactory
     */
    public function __construct(
        \Wiki\Vendors\App\Action\Context $context,
        \Magento\Framework\App\Response\Http\FileFactory $fileFactory,
        \Magento\Framework\Filesystem $filesystem,
        \Magento\Framework\Filesystem\DirectoryList $directory,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \Magento\Catalog\Model\Product\Visibility $catalogProductVisibility,
        \Wiki\Vendors\Helper\Data $vendorHelper,
        \Wiki\VendorsProduct\Helper\Data $productHelper,
        \Magento\Catalog\Model\Product $collectionProduct,
        \Magento\Catalog\Model\CategoryFactory $categoryFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Catalog\Model\ProductRepository $productRepository,
        \Magento\Framework\App\ResourceConnection $resource
    ) {
        parent::__construct($context);
        $this->_fileFactory                 = $fileFactory;
        $this->_directory                   = $filesystem->getDirectoryWrite(DirectoryList::VAR_DIR);
        $this->_path                        = "export";
        $this->_productCollectionFactory    = $productCollectionFactory;
        $this->_catalogProductVisibility    = $catalogProductVisibility;
        $this->_vendorHelper                = $vendorHelper;
        $this->_productHelper               = $productHelper;
        $this->_collectionProduct           = $collectionProduct;
        $this->storeManager                 = $storeManager;
        $this->categoryFactory              = $categoryFactory;
        $this->_productRepository           = $productRepository;
        $this->_resource                    = $resource;
    }



    /**
     * Export low stock products report to CSV format
     *
     * @return ResponseInterface
     */
    public function execute()
    {
        $this->_view->loadLayout(false);
        $fileName = 'products_ordered.csv';
        $fileCsv = $this->getCsvFile();
        return $this->_fileFactory->create(
            $fileName,
            $fileCsv,
            DirectoryList::VAR_DIR
        );
    }

    /**
     * Retrieve a file container array by grid data as CSV
     *
     * Return array with keys type and value
     *
     * @return array
     */
    public function getCsvFile()
    {
        $name = md5(microtime());
        $file = $this->_path . '/' . $name . '.csv';
        $this->_directory->create($this->_path);
        $stream = $this->_directory->openFile($file, 'w+');
        $stream->writeCsv($this->_getExportHeaders());
        $stream->lock();

        $collection = $this->_productCollectionFactory->create();
        $collection->setVisibility($this->_catalogProductVisibility->getVisibleInCatalogIds());
        $notActiveVendorIds = $this->_vendorHelper->getNotActiveVendorIds();

        if($collection->isEnabledFlat()){
            $collection->getSelect()->where('approval IN (?)',$this->_productHelper->getAllowedApprovalStatus());
            if(sizeof($notActiveVendorIds)){
                $collection->getSelect()->where('vendor_id NOT IN('.implode(",", $notActiveVendorIds).')');
            }
        }else{
            $collection->addAttributeToFilter('approval',['in' => $this->_productHelper->getAllowedApprovalStatus()]);
            if(sizeof($notActiveVendorIds)){
                $collection->addAttributeToFilter('vendor_id',['nin' => $notActiveVendorIds]);
            }
        }
        foreach($collection as $item){
            if($item->getTypeId() == "configurable"){
                unset($product);
                $product = $this->_productRepository->getById($item->getId());
            }else{
                unset($product);
                $product = $this->_productRepository->getById($item->getId());
            }
            $itemData = [];
            $itemData['sku'] = $product->getSku();
            $storeData = $this->storeManager->getStore($product->getStoreId());
            $storeCode = (string)$storeData->getCode();
            $itemData['store_view_code'] = $storeCode;
            $itemData['attribute_set_code'] = "Default";
            $itemData['product_type'] = $product->getTypeId();
            $categoryIds = $product->getCategoryIds(); //Get Current CategoryIds
            $connection = $this->_resource->getConnection();
            $tableName = $this->_resource->getTableName('catalog_category_product');
            $query = "SELECT category_id FROM ". $tableName . " WHERE product_id= '" . $item->getId(). "'";
            $categoryIds = $connection->fetchAll($query);
            $count = count($categoryIds);
            $itemCategory = "";
            $i = 0;
            foreach ($categoryIds as $categoryId){
                $i++;
                $categoryPath = $this->getCategory($categoryId)->getPath();
                $arrayCategory = explode('/', $categoryPath);
                foreach($arrayCategory as $idCategory){
                    $categoryName = $this->getCategory($idCategory)->getName();
                    if($idCategory != 1){
                        $itemCategory .= $categoryName . "/";
                    }
                }
                $itemCategory = substr_replace($itemCategory ,"",-1);
                if($i != $count ){
                    $itemCategory .= ",";
                }
            }
            $itemData['categories'] = $itemCategory;
            $itemData['product_websites'] = "base";
            $itemData['name'] = $product->getName();
            $itemData['description'] = $product->getDescription();
            $itemData['short_description'] = $product->getShortDescription();
            $itemData['weight'] = (int)$product->getWeight();
            $itemData['product_online'] = 1;
            $itemData['tax_class_name'] = "Taxable Goods";
            $itemData['visibility'] = $product->getAttributeText('visibility')->getText();
            $itemData['price'] = $product->getPrice();
            $itemData['special_price'] = $product->getSpecialPrice();
            $itemData['special_price_from_date'] = $product->getSpecialFromDate();
            $itemData['special_price_to_date'] = $product->getSpecialToDate();
            $itemData['url_key'] = $product->getUrlKey();
            $itemData['meta_title'] = $product->getMetaTitle();
            $itemData['meta_keywords'] = $product->getMetaKeyword();
            $itemData['meta_description'] = $product->getMetaDescription();
            $itemData['base_image'] = $product->getSmallImage();
            $itemData['base_image_label'] = $product->getSmallImageLabel();
            $itemData['small_image'] = $product->getSmallImage();
            $itemData['small_image_label'] = $product->getSmallImageLabel();
            $itemData['thumbnail_image'] = $product->getThumbnail();
            $itemData['thumbnail_image_label'] = $product->getThumbnailLabel();
            $itemData['swatch_image'] = $product->getSwatchImage();
            $itemData['swatch_image_label'] = $product->getSwatchImageLabel();
            $itemData['created_at'] = $product->getCreatedAt();
            $itemData['updated_at'] = $product->getUpdatedAt();
            $itemData['new_from_date'] = $product->getNewsFromDate();
            $itemData['new_to_date'] = $product->getNewsToDate();
            if($product->getOptionsContainer() == "container2"){
                $displayProductOptionsIn = "Block after info column";
            }else{
                $displayProductOptionsIn = "Product info column";
            }
            $itemData['display_product_options_in'] = $displayProductOptionsIn;
            $itemData['map_price'] = "";
            $itemData['msrp_price'] = "";
            $itemData['map_enabled'] = "";
            $itemData['gift_message_available'] = $product->getGiftMessageAvailable();
            $itemData['custom_design'] = "";
            $itemData['custom_design_from'] = "";
            $itemData['custom_design_to'] = "";
            $itemData['custom_layout_update'] = "";
            $itemData['page_layout'] = "";
            $itemData['product_options_container'] = "";
            if($product->getMsrpDisplayActualPriceType() == "1"){
                $msrpDisplay = "On Gesture";
            }else if($product->getMsrpDisplayActualPriceType() == "2"){
                $msrpDisplay = "In Cart";
            }else if($product->getMsrpDisplayActualPriceType() == "3"){
                $msrpDisplay = "Before Order Confirmation";
            }else{
                $msrpDisplay = "Use config";
            }
            $itemData['msrp_display_actual_price_type'] = $msrpDisplay;
            $itemData['country_of_manufacture'] = $product->getAttributeText("country_of_manufacture");
            $additional_attributes = "approval=" . $product->getAttributeText("approval");
            $color = $product->getAttributeText("color");
            $linksPurchases = $product->getLinksPurchasedSeparately();
            $linksTitle = $product->getLinksTitle();
            $sampleTitle = $product->getSamplesTitle();
            if(isset($color)){
                $additional_attributes .= ",color=" . $color;
            }
            if(isset($linksPurchases)){
                $additional_attributes .= ",links_purchased_separately=" . $linksPurchases;
            }
            if(isset($linksTitle)){
                $additional_attributes .= ",links_title=" . $linksTitle;
            }
            if(isset($sampleTitle)){
                $additional_attributes .= ",samples_title=" . $sampleTitle;
            }
            $additional_attributes .= ",vendor_id=" . $product->getVendorId();
            $itemData['additional_attributes'] = $additional_attributes;
            $stockProduct = $product->getExtensionAttributes()->getStockItem();
            $itemData['qty'] = $stockProduct->getQty();
            $itemData['out_of_stock_qty']           = 0;
            $itemData['use_config_min_qty']         = (int) $stockProduct->getUseConfigMinQty();
            $itemData['is_qty_decimal']             = (int) $stockProduct->getIsQtyDecimal();
            $itemData['allow_backorders']           = (int) $stockProduct->getBackOrders();
            $itemData['use_config_backorders']      = (int) $stockProduct->getUseConfigBackorders();
            $itemData['min_cart_qty']               = (int) $stockProduct->getMinSaleQty();
            $itemData['use_config_min_sale_qty']    = (int) $stockProduct->getUseConfigMinSaleQty();
            $itemData['max_cart_qty']               = (int) $stockProduct->getMaxSaleQty();
            $itemData['use_config_max_sale_qty'] = (int) $stockProduct->getUseConfigMaxSaleQty();
            $itemData['is_in_stock'] = (int) $stockProduct->getIsInStock();
            $itemData['notify_on_stock_below'] = (int) $stockProduct->getNotifyStockQty();
            $itemData['use_config_notify_stock_qty'] = (int) $stockProduct->getUseConfigNotifyStockQty();
            $itemData['manage_stock'] = (int) $stockProduct->getManageStock();
            $itemData['use_config_manage_stock'] = (int) $stockProduct->getUseConfigManageStock();
            $itemData['use_config_qty_increments'] = (int) $stockProduct->getUseConfigQtyIncrements();
            $itemData['qty_increments'] = (int) $stockProduct->getQtyIncrements();
            $itemData['use_config_enable_qty_inc'] = (int) $stockProduct->getUseConfigEnableQtyInc();
            $itemData['enable_qty_increments'] = (int) $stockProduct->getEnableQtyIncrements();
            $itemData['is_decimal_divided'] = (int) $stockProduct->getIsDecimalDivided();
            $itemData['website_id'] = $stockProduct->getWebsiteId();
            $relatedCollection = $product->getRelatedProducts();
            $relatedSkus = "";
            $relatedPositions = "";
            foreach($relatedCollection as $related){
                $relatedSkus        .= $related->getSku() .",";
                $relatedPositions   .= $related->getPosition() .",";
            }
            $relatedSkus = substr_replace($relatedSkus ,"",-1);
            $relatedPositions = substr_replace($relatedPositions ,"",-1);
            $itemData['related_skus'] = $relatedSkus;
            $itemData['related_position'] = $relatedPositions;
            $crossSellProducts = $product->getCrossSellProducts();
            $crossSellSkus = "";
            $crossSellPosition = "";
            foreach($crossSellProducts as $crossSell){
                $crossSellSkus          .= $crossSell->getSku() .",";
                $crossSellPosition      .= $crossSell->getPosition() .",";
            }
            $crossSellSkus          = substr_replace($crossSellSkus ,"",-1);
            $crossSellPosition      = substr_replace($crossSellPosition ,"",-1);
            $itemData['crosssell_skus']     = $crossSellSkus;
            $itemData['crosssell_position'] = $crossSellPosition;
            $upSellProducts = $product->getUpSellProducts();
            $upSellSkus = "";
            $upSellPosition = "";
            foreach($upSellProducts as $upSell){
                $upSellSkus          .= $upSell->getSku() .",";
                $upSellPosition      .= $upSell->getPosition() .",";
            }
            $upSellSkus  = substr_replace($upSellSkus ,"",-1);
            $upSellPosition = substr_replace($upSellPosition ,"",-1);
            $itemData['upsell_skus'] = $upSellSkus;
            $itemData['upsell_position'] = $upSellPosition;
            $galleryImage = $product->getMediaGalleryImages();
            $additional_images = "";
            foreach ($galleryImage as $image){
                $additional_images .= $image->getFile() . ",";
            }
            $additional_images      = substr_replace($additional_images ,"",-1);
            $itemData['additional_images'] = $additional_images;
            $itemData['additional_image_labels'] = "";
            $itemData['hide_from_product_page'] = "";
            $customOptions = $product->getOptions();
            $custom_options ="";
            foreach ($customOptions as $option){
                $custom_options .= "name=" . $option->getDefaultTitle() .",type=" . $option->getType() . ",required=" . $option->getIsRequire() .",price=" . $option->getPrice()
                    . ",sku=" . $option->getSku() .",max_characters=" . $option->getMaxCharacters() .",file_extension=" . $option->getFileExtension() . ",image_size_x=" . $option->getImageSizeX()
                    . ",image_size_y=" . $option->getImageSizeY() . ",price_type=" . $option->getPriceType() ."|";
            }
            $custom_options      = substr_replace($custom_options ,"",-1);
            $itemData['custom_options'] = $custom_options;
            $itemData['bundle_price_type'] = $item[0];
            $itemData['bundle_sku_type'] = $item[0];
            $itemData['bundle_price_view'] = $item[0];
            $itemData['bundle_weight_type'] = $item[0];
            $itemData['bundle_values'] = $item[0];
            $itemData['bundle_shipment_type'] = $item[0];
            $itemData['associated_skus'] = $item[0];
            $downloadCollection = $product->getDownloadableLinks();
            $downloadable_links = "";
            if(isset($downloadCollection)){
                foreach($downloadCollection as $download){
                    $downloadable_links .= "link_id=" . $download->getLinkId() .",id=" . $download->getId() .",title=" . $download->getTitle() .",sort_order=" . $download->getSortOrder() .
                        ",sample_type=" . $download->getSampleType() . ",sample_file=" . $download->getSampleFile() . ",price=" .$download->getPrice() .
                        ",is_shareable=". $download->getIsShareable() .",link_type=". $download->getLinkType() .",link_file=" . $download->getLinkFile() .",group_title=Links|"
                    ;
                }
                $downloadable_links      = substr_replace($downloadable_links ,"",-1);
            }else{
                $downloadable_links      = "";
            }
            $itemData['downloadable_links'] = $downloadable_links;
            $itemData['downloadable_samples'] = $item[0];

            if($item->getTypeId() == "configurable"){
                $configurable_variations = "";
                $_children = $product->getTypeInstance()->getUsedProducts($product);

                foreach ($_children as $child){
                    $configurable_variations .= "sku=" . $child->getSku() . ",color=" . $child->getAttributeText("color") ."|";
                }
                $attr = $product->getResource()->getAttribute('color');
                $configurable_variations      = substr_replace($configurable_variations ,"",-1);
                $itemData['configurable_variations'] = $configurable_variations;
                $itemData['configurable_variation_labels'] = $product->getResource()->getAttribute('color')->getFrontendLabel();
            }else{
                $itemData['configurable_variations'] = "";
                $itemData['configurable_variation_labels'] = "";
            }
            $stream->writeCsv($itemData);
        }


        $stream->unlock();
        $stream->close();
        return [
            'type' => 'filename',
            'value' => $file,
            'rm' => true  // can delete file after use
        ];
    }
    /* Header Columns */
    public function getColumnHeader() {
        $headers = ['sku','store_view_code','attribute_set_code','product_type','categories','product_websites',
        'name','description','short_description','weight','product_online','tax_class_name','visibility',
        'price','special_price','special_price_from_date','special_price_to_date','url_key','meta_title','meta_keywords',
        'meta_description','base_image','base_image_label','small_image'
        ,'small_image_label','thumbnail_image','thumbnail_image_label','swatch_image','swatch_image_label','created_at','updated_at','new_from_date'
        ,'new_to_date','display_product_options_in','map_price','msrp_price','map_enabled','gift_message_available'
        ,'custom_design','custom_design_from','custom_design_to','custom_layout_update','page_layout','product_options_container'
        ,'msrp_display_actual_price_type','country_of_manufacture','additional_attributes','qty','out_of_stock_qty','use_config_min_qty',
        'is_qty_decimal','allow_backorders','use_config_backorders','min_cart_qty','use_config_min_sale_qty','max_cart_qty',
        'use_config_max_sale_qty','is_in_stock','notify_on_stock_below','use_config_notify_stock_qty','manage_stock','use_config_manage_stock',
        'use_config_qty_increments','qty_increments','use_config_enable_qty_inc','enable_qty_increments','is_decimal_divided',
        'website_id','related_skus','related_position','crosssell_skus','crosssell_position',
        'upsell_skus','upsell_position',
        'additional_images','additional_image_labels','hide_from_product_page','custom_options','bundle_price_type','bundle_sku_type',
        'bundle_price_view','bundle_weight_type','bundle_values','bundle_shipment_type','associated_skus','downloadable_links',
        'downloadable_samples','configurable_variations','configurable_variation_labels'
    ];
        return $headers;
    }

    /* Header Columns */
    public function _getExportHeaders() {
        $columns = $this->getColumnHeader();
        foreach ($columns as $column) {
            $header[] = $column;
        }
        return $header;
    }

    public function getCategory($categoryId)
    {
        $this->category = $this->categoryFactory->create();
        $this->category->load($categoryId);
        return $this->category;
    }
}
