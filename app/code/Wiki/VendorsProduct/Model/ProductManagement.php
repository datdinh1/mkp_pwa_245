<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Wiki\VendorsProduct\Model;

use Wiki\VendorsProduct\Api\ProductManagementInterface;
use Magento\Framework\App\ObjectManager;
use Wiki\VendorsProduct\Model\Source\Approval;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Model\Product\Gallery\GalleryManagement;

use Magento\Sales\Api\Data\OrderItemSearchResultInterfaceFactory;
use Magento\Catalog\Model\ProductRepository;
use Wiki\SampleImageUploader\Model\ImageRepository;
use Magento\Catalog\Model\CategoryRepository;
use Magento\Catalog\Model\CategoryLinkManagement;

use Magento\Catalog\Model\Product\Attribute\Repository;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Wiki\VendorsProduct\Api\Data\DataProductApiInterface;
use Magento\ConfigurableProduct\Model\ResourceModel\Product\Type\Configurable;
use Wiki\Vendors\Model\VendorFactory;
use Wiki\VendorsProduct\Helper\Data;

use Magento\Eav\Api\Data\AttributeSetInterfaceFactory;
use Magento\Indexer\Model\IndexerFactory;
use Magento\Eav\Model\Config;
use Magento\Eav\Api\AttributeOptionManagementInterface;

/**
 * Handle various customer account actions
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @SuppressWarnings(PHPMD.TooManyFields)
 * @SuppressWarnings(PHPMD.ExcessiveClassComplexity)
 * @SuppressWarnings(PHPMD.CookieAndSessionMisuse)
 */
class ProductManagement implements ProductManagementInterface
{
    protected $eavConfig;

    /**
     * @var \Magento\Indexer\Model\IndexerFactory
     */
    protected $indexerFactory;

    /**
     * @var AttributeSetInterfaceFactory
     */
    protected $attributeSetInterfaceFactory;

    protected $vendorFactory;

    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @param ResourceModel\Product\CollectionFactory $collectionFactory */

    /**
     * @var \Magento\Catalog\Api\Data\ProductSearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;

    /**
     * @var OrderItemSearchResultInterfaceFactory
     */
    protected $orderItemFactory;

    protected $productRepo;

    protected $_customerRepositoryInterface;

    /**
     * @var Repository
     */
    protected $attributeRepository;

    /**
     * @var GalleryManagement
     */
    private $galleryManagement;

    protected $customBestSellerFactory;

    protected $collectionCateFactory;

    /** @var SearchCriteriaBuilder */
    protected $searchCriteriaBuilder;
    protected $productFactory;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @var Configurable
     */
    protected $configurableProduct;

    /**
     * @var AttributeOptionManagementInterface
     */
    protected $eavOptionManagement;

    protected $helperData;
    /** *
     * @param \Magento\Indexer\Model\IndexerFactory $resultLayoutFactory
     * @param \Magento\Catalog\Api\Data\ProductSearchResultsInterfaceFactory $searchResultsFactory
     * @param ProductInterface|Product $product
     * @param OrderItemSearchResultInterfaceFactory $orderItemFactory
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param CollectionProcessorInterface $collectionProcessor [optional]
     */
    public function __construct(
        Config $eavConfig,
        IndexerFactory $indexerFactory,
        AttributeSetInterfaceFactory $attributeSetInterfaceFactory,
        Data $helperData,
        VendorFactory $vendorFactory,
        \Magento\Catalog\Model\ProductFactory $productFactory,
        \Wiki\Vendors\Model\Vendor $vendorsModel,
        \Magento\Customer\Model\Customer $customerModel,
        \Magento\Indexer\Model\Indexer\CollectionFactory $indexersFactory,
        \Magento\Catalog\Model\Product $productModel,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \MGS\Brand\Model\Brand $brand,
        \Magento\Catalog\Api\Data\ProductSearchResultsInterfaceFactory $searchResultsFactory,
        OrderItemSearchResultInterfaceFactory $orderItemFactory,
        ProductRepository $productRepository,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepositoryInterface,
        ImageRepository $interest,
        CategoryRepository $categoryRepo,
        CategoryLinkManagement $categoryLink,
        GalleryManagement $galleryManagement,
        Repository $attributeRepository,
        \Wiki\VendorsProduct\Model\Api\Data\CustomBestSellerFactory $customBestSellerFactory,
        \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $collectionCateFactory,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        Configurable $configurableProduct,
        CollectionProcessorInterface $collectionProcessor = null,
        AttributeOptionManagementInterface  $eavOptionManagement
    ) {
        $this->eavConfig                    = $eavConfig;
        $this->indexerFactory               = $indexerFactory;
        $this->attributeSetInterfaceFactory = $attributeSetInterfaceFactory;
        $this->helperData                   = $helperData;
        $this->vendorFactory                = $vendorFactory;
        $this->_vendorsModel                = $vendorsModel;
        $this->_customerModel               = $customerModel;
        $this->productModel                 = $productModel;
        $this->productRepository            = $productRepository;
        $this->productCollectionFactory     = $productCollectionFactory;
        $this->searchResultsFactory         = $searchResultsFactory;
        $this->_brand                       = $brand;
        $this->indexersFactory              = $indexersFactory;
        $this->orderItemFactory             = $orderItemFactory;
        $this->_customerRepositoryInterface = $customerRepositoryInterface;
        $this->interest                     = $interest;
        $this->categoryRepo                 = $categoryRepo;
        $this->categoryLink                 = $categoryLink;
        $this->galleryManagement            = $galleryManagement;
        $this->attributeRepository          = $attributeRepository;
        $this->customBestSellerFactory      = $customBestSellerFactory;
        $this->collectionCateFactory        = $collectionCateFactory;
        $this->searchCriteriaBuilder        = $searchCriteriaBuilder;
        $this->collectionProcessor          = $collectionProcessor ?: $this->getCollectionProcessor();
        $this->configurableProduct          = $configurableProduct;
        $this->productFactory               = $productFactory;
        $this->eavOptionManagement          = $eavOptionManagement;
    }

    public function renConfigurableNewArrival($listProductNewArrival)
    {
        $result = [];
        $configurableProductId = [];
        if (count($listProductNewArrival) <= 0) return null;
        foreach ($listProductNewArrival as $product) {
            $productLinks = $product->getExtensionAttributes()->getConfigurableProductLinks();
            if ($productLinks) {
                foreach ($productLinks as $productLink) {
                    $configurableProductId[] = $productLink;
                }
            }
        }

        foreach ($listProductNewArrival as $product) {
            //set price parent product configurable  = first child configurable product  because it's price default = 0 
            if (!in_array($product->getId(), $configurableProductId)) {
                if ($product->getPrice() == 0) {

                    $productLinks = $product->getExtensionAttributes()->getConfigurableProductLinks();
                    $firstProductLinkId = array_values($productLinks)[0];

                    //get price of first child product 
                    $priceFirst = $this->productModel->load($firstProductLinkId)->getPrice();

                    $data = $product->getData();
                    unset($data['type_id']);

                    $setProduct = $this->productFactory->create();
                    $setProduct->setData($data);
                    $setProduct->setPrice($priceFirst);
                    $result[] = $setProduct;
                } else {
                    $result[] = $product;
                }
            }
        }
        return $result;
    }

    /**
     * @inheritdoc
     */
    public function customPaginate($collection, $pageSize = null, $currentPage = null)
    {
        /// $pageSize = null; $currentPage = null;
        $searchCriteria = $this->searchCriteriaBuilder->create();
        if ($pageSize && $currentPage) {
            $searchCriteria->setPageSize($pageSize)->setCurrentPage($currentPage);
        }


        $this->collectionProcessor->process($searchCriteria, $collection);

        $collection->load();


        $searchResult = $this->searchResultsFactory->create();

        $searchResult->setSearchCriteria($searchCriteria);

        $searchResult->setItems($collection->getItems());

        $result = [];
        foreach ($searchResult->getItems() as $item) {
            $sku = $item->getSku();
            $productOfSku = $this->productRepository->get($sku);
            $result[] = $productOfSku;
        }
        return $result;
    }

    public function setHideProduct($entity_id, $value)
    {
        try {
            $product = $this->productFactory->create()->load($entity_id);
            $product->setVisibility($value);
            $product->save();
            $indexers = $this->indexersFactory->create()->getItems();
            foreach ($indexers as $indexer) {
                $indexer->reindexList([$product->getId()]);
            }
        } catch (\Exception $e) {
            return false;
        }
        return true;
    }

    public function showProduct($entity_id)
    {
        $product = $this->productRepository->getById($entity_id, false, 0);
        $product->setStatus(\Magento\Catalog\Model\Product\Attribute\Source\Status::STATUS_ENABLED);
        $product->save();
        return true;
    }

    public function getListbyVendor($namestore)
    {
        try {
            $vendor = $this->_vendorsModel->loadByIdentifier($namestore);
            $id = $vendor->getId();
            $customer = $this->_customerModel->setWebsiteId(1)->loadByEmail($vendor->getEmail());
            $customerVendor = $this->_vendorsModel->loadByCustomer($customer);
            if (count($customerVendor->getData()) == 0) {
                // "This is not account Seller"
                return false;
            } else {
                /** @var \Magento\Catalog\Model\ResourceModel\Product\Collection $collection */
                $collection = $this->productCollectionFactory->create()->addAttributeToSelect('*')->addAttributeToFilter('vendor_id', $id);
                $result = [];
                foreach ($collection->getItems() as $item) {
                    $sku = $item->getSku();
                    $productOfSku = $this->productRepository->get($sku);
                    $result[] = $productOfSku;
                }
                return $result;
            }
        } catch (\Exception $e) {
            return $e;
        }
    }

    /**
     * @param DataProductApiInterface
     * @return bool
     */
    public function save($data, $reindex = true)
    {
        try {
            $product = $data->getProduct();
            $vendorId = $data->getVendorId();

            $checkProduct = $this->productModel->getIdBySku($product->getSku());
            if ($checkProduct || empty($product->getData())) {
                $this->log("Create-Product: 'Duplicate Sku: " . $product->getSku() . "'");
                throw new \Magento\Framework\Webapi\Exception(
                    __("Create-Product: 'Duplicate Sku: " . $product->getSku() . "'"),
                    400
                );
            }
            $vendor = $this->_vendorsModel->loadByIdentifier($vendorId);
            $id = $vendor->getId();
            if (!isset($id)) {
                // "This is not account Seller"
                $this->log("Create-Product: 'Not found Seller: " . $vendorId . "'");
                throw new \Magento\Framework\Webapi\Exception(
                    __("Create-Product: 'Not found Seller: " . $vendorId . "'"),
                    400
                );
            } else {
                //add new product magento default
                $product->setVendorId($id);
                $product->setApproval(Approval::STATUS_APPROVED);
                $product = $this->productRepository->save($product);
                if (!empty($updateImg)) {
                    foreach ($updateImg as $img) {
                        $this->galleryManagement->create($product->getSku(), $img);
                    }
                }
                if ($reindex) {
                    $indexers = $this->indexersFactory->create()->getItems();
                    foreach ($indexers as $indexer) {
                        $indexer->reindexList([$product->getId()]);
                    }
                }

                return true;
            }
        } catch (\Exception $e) {
            $this->log("Create-Product");
            $this->log($e->getMessage());
            throw new \Magento\Framework\Webapi\Exception(__($e->getMessage()), 400);
        }
    }

    /**
     * @param string $sku
     * @param DataProductApiInterface $data
     * @return bool
     */
    public function update($sku, $data, $indexer = true)
    {
        try {
            $product = $data->getProduct();
            $vendorId = $data->getVendorId();
            $deleteImg = $data->getDeletedImages();
            $uploadImg = $data->getUploadedImages();

            if ($product->getId() == $this->productModel->getIdBySku($sku)) {
                $vendor = $this->_vendorsModel->loadByIdentifier($vendorId);
                $id = $vendor->getId();
                if (!isset($id)) {
                    // "This is not account Seller"
                    $this->log("Update-Product: 'Duplicate Sku: " . $product->getSku() . "'");
                    throw new \Magento\Framework\Webapi\Exception(
                        __("Update-Product: 'Duplicate Sku: " . $product->getSku() . "'"),
                        400
                    );
                } else {
                    $getImage = $this->productRepository->get($sku)->getMediaGalleryEntries();
                    $product->setMediaGalleryEntries($getImage);
                    $product = $this->productRepository->save($product);
                    if (is_array($deleteImg) && !empty($deleteImg)) {
                        foreach ($deleteImg as $fileImg) {
                            $mediaGalleryEntries = $product->getMediaGalleryEntries();
                            foreach ($mediaGalleryEntries as $img) {
                                if ($img->getFile() == $fileImg) {
                                    $this->galleryManagement->remove($product->getSku(), $img->getId());
                                    break;
                                }
                            }
                        }
                    }
                    if (!empty($uploadImg)) {
                        foreach ($uploadImg as $img) {
                            $this->galleryManagement->create($product->getSku(), $img);
                        }
                    }
                    if ( $indexer ){
                        $indexers = $this->indexersFactory->create()->getItems();
                        foreach ($indexers as $indexer) {
                            $indexer->reindexList([$product->getId()]);
                        }
                    }
                    return true;
                }
            } else {
                $this->log("Update-Product: 'Not found Seller: " . $vendorId . "'");
                throw new \Magento\Framework\Webapi\Exception(
                    __("Update-Product: 'Not found Seller: " . $vendorId . "'"),
                    400
                );
            }
        } catch (\Exception $e) {
            $this->log("Update-Product");
            $this->log($e->getMessage());
            throw new \Magento\Framework\Webapi\Exception(__($e->getMessage()), 400);
        }
    }

    public function delete($sku)
    {
        try {
            $product = $this->productRepository->get($sku);
            if (method_exists($product->getTypeInstance(), 'getUsedProducts')) {
                $childProducts = $product->getTypeInstance()->getUsedProductIds($product);
                foreach ($childProducts as $productId) {
                    $child = $this->productRepository->getById($productId);
                    $this->productRepository->deleteById($child->getSku());
                    $ids[] = $child->getId();
                }
                $attributeOptions = $product->getTypeInstance()->getConfigurableAttributesAsArray($product);
            }

            $ids[] = $product->getId();
            $parentProductId = $this->configurableProduct->getParentIdsByChild($product->getId());
            if ($parentProductId) {
                $ids = array_merge($ids, $parentProductId);
            }

            $this->productRepository->deleteById($sku);

            /** clear attributes option custom */
            if ( isset($attributeOptions) && !empty($attributeOptions) && $product->getVendorId() != "0" ){
                foreach ( $attributeOptions as $attribute ){
                    if ( strpos($attribute["attribute_code"], "v_") === 0 ){
                        $this->attributeRepository->deleteById($attribute["attribute_code"]);
                    }
                }
            }

            $indexers = $this->indexersFactory->create()->getItems();
            foreach ($indexers as $indexer) {
                $indexer->reindexList($ids);
            }
            return true;
        } catch (\Exception $e) {
            $this->log("Delete-Product");
            $this->log($e->getMessage());
            throw new \Magento\Framework\Webapi\Exception(__($e->getMessage()), 400);
        }
    }

    public function log($data)
    {
        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/vendors_product.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        $logger->info($data);
    }

    public function getAllBrand()
    {
        $arrayBrand = [];
        $collection = $this->_brand->getCollection();
        foreach ($collection as $item) {
            $arrayBrand[] = $item->getData();
        }
        return $arrayBrand;
    }

    public function getListBestSelling()
    {
        /** @var \Magento\Sales\Model\ResourceModel\Order\Item\Collection $searchResult */
        $searchResult = $this->orderItemFactory->create();
        $listItemOrder = $searchResult->getData();

        //get current day and get day by today -1 week
        $today = date("Y-m-d ");
        $todayInt = strtotime($today);
        $beginInt = strtotime(date("Y-m-d", $todayInt) . " -1 week");

        //get list order item = [today - 7, today] (at 0h00m00s)
        $filterOderItem = [];
        foreach ($listItemOrder as $item) {
            $createdInt = strtotime($item["created_at"]);
            if ($createdInt >= $beginInt && $createdInt <= $todayInt) {
                $filterOderItem[] = $item;
            }
        }
        //array key:id_product/ value:total qty ordered
        $listProductId = [];
        foreach ($filterOderItem as $itemFilter) {

            if (!$this->helperData->checkAuctionProduct($itemFilter["sku"])) {
                $qty = ($itemFilter["qty_ordered"]);
                if (isset($listProductId[$itemFilter["sku"]])) {
                    $listProductId[$itemFilter["sku"]] += (int)($qty);
                } else {
                    $listProductId[$itemFilter["sku"]] = (int)($qty);
                }
            }
        }

        //sort high to low by total qty
        arsort($listProductId);

        //key to value of array list id
        $listProductFlip = array_keys($listProductId);
        return $listProductFlip;
    }
    /**
     * $arr: list product
     * $sort: "DESC" Or "ASC"
     */
    public function sortArrayProductByTime($result, $sortType)
    {
        if (count($result) > 0) {
            foreach ($result as $key => $val) {
                $time[$key] = $val['created_at'];
            }

            if ($sortType == "DESC") {
                $tmp  = array_multisort($time, SORT_DESC, $result);
            } else  $tmp  = array_multisort($time, SORT_ASC, $result);

            return $result;
        } else return null;
    }

    public function productBestSellerRecomend($userId)
    {
        $customer = $this->_customerRepositoryInterface->getById($userId);
        if (!$customer) {
            return false;
        }
        $listProductFlip = $this->getListBestSelling();
        $interCate = $this->interest->getInterestBycustomerId($userId);
        $listCateInterest = [];
        if (!$interCate) return null;
        //get category from interest customer
        foreach ($interCate->getInfo() as $image) {
            $listCateInterest[] = $image['category_id'];
        }
        $result = [];

        // check category id of product best selling and category product of interest customer
        foreach ($listProductFlip as $idProduct) {
            $product = $this->productRepository->get($idProduct);
            if ($product->getStatus() == 1) {
                $cateOfId = $product->getCategoryIds();
                foreach ($listCateInterest as $key => $cateInter) {
                    if (in_array($cateInter, $cateOfId)) {
                        $result[] = $product;
                        break;
                    }
                }
            }
        }
        $sort_result = $this->sortArrayProductByTime($result, "DESC");
        return $sort_result;
    }

    public function getCategoryFromArrayId($cateOfId)
    {
        //merge array list category
        $listCateID = [];
        foreach ($cateOfId as $idArr) {
            if (count($idArr) > 0) {
                foreach ($idArr as $val) {
                    $listCateID[] = $val;
                }
            }
        }
        //remove overlap element in arrays
        $listCateID = array_unique($listCateID);

        if (count($listCateID) >= 100) {
            $chunk = array_chunk($listCateID, 100);
            $listCateID = $chunk[0];
        }
        $result = [];
        //get category by ids
        foreach ($listCateID as $ids) {
            $result[] = $this->categoryRepo->get($ids);
        }
        return $result;
    }

    public function categoryOfProductBestSeller()
    {
        $listProductFlip = $this->getListBestSelling();

        $cateOfId = [];
        foreach ($listProductFlip as $idProduct) {
            $product = $this->productRepository->get($idProduct);
            $cateOfId[] = $product->getCategoryIds();
        }
        $result = $this->getCategoryFromArrayId($cateOfId);

        return $result;
    }

    public function getIdByCategoryName($categoryTitle)
    {
        $collection = $this->collectionCateFactory->create()->addAttributeToFilter('name', $categoryTitle)->setPageSize(1);

        if ($collection->getSize()) {
            $categoryId = $collection->getFirstItem()->getId();
            return $categoryId;
        }
        return null;
    }

    public function renderApiData($arr)
    {
        $result = [];
        if (count($arr) > 0) {
            foreach ($arr as $key => $listProduct) {
                $response = $this->customBestSellerFactory->create();
                $cateId = $this->getIdByCategoryName($key);
                $response->setCategory($this->categoryRepo->get($cateId));
                $response->setListProduct($listProduct);
                $result[] = $response;
            }
        }

        return $result;
    }

    public function listProductBestSellerByCategory()
    {
        $tmp = [];
        $listCateBestSeller = $this->categoryOfProductBestSeller();
        $listCateId = [];
        foreach ($listCateBestSeller as $cate) {
            $name = $cate->getName();
            $listCateId[$name] = $cate->getEntityId();
        }

        //get list product of category by id cate
        $listSkuProduct = [];
        foreach ($listCateId as $name => $idCate) {
            $listSkuProduct[$name] = $this->categoryLink->getAssignedProducts($idCate);
        }
        $tmp[] = $listSkuProduct;

        $listProductId = $this->getListBestSelling();

        foreach ($listSkuProduct as $key => $item) {
            foreach ($item as $key2 => $product) {
                $sku = $product->getSku();
                $productOfSku = $this->productRepository->get($sku);

                if (!in_array($sku, $listProductId)) {
                    unset($listSkuProduct[$key][$key2]);
                }
            }
        }
        $result = [];
        $resultTmp = [];

        foreach ($listSkuProduct as $key => $item) {
            foreach ($item as $key2 => $product) {
                if ($product->getStatus() == 1) {
                    $sku = $product->getSku();
                    $resultTmp[] = $sku;
                    $productOfSku = $this->productRepository->get($sku);

                    $result[$key][] = $productOfSku;
                }
            }
        }
        foreach ($result as $key => $cat) {
            $result[$key] = $this->sortArrayProductByTime($result[$key], "DESC");
        }
        $kamaha = $this->renderApiData($result);

        return $kamaha;
    }

    public function getListSellerByGroupId($idGroup)
    {
        //get all seller have id group
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $connection = $objectManager->get('Magento\Framework\App\ResourceConnection')->getConnection('\Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION');
        $listSellerByGroupId = $connection->fetchAll("SELECT vendor_id FROM `ves_vendor_entity` WHERE group_id = $idGroup");

        return $listSellerByGroupId;
    }
    public function getVendorIdNumberByGroupId($idGroup)
    {
        //get all seller have id group
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $connection = $objectManager->get('Magento\Framework\App\ResourceConnection')->getConnection('\Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION');
        $listSellerByGroupId = $connection->fetchAll("SELECT entity_id FROM `ves_vendor_entity` WHERE group_id = $idGroup");

        $listSeller = [];
        foreach ($listSellerByGroupId as $val) {
            $listSeller[] = $val['entity_id'];
        }
        return $listSeller;
    }

    public function getProductMallPage($idGroup,  $pageSize = null, $currenPage = null, $sortAlphaName = null, $sortPrice = null)
    {

        // //get all seller have id group
        $listVendorId = $this->getVendorIdNumberByGroupId($idGroup);
        if (count($listVendorId) == 0) return null;

        $collection = $this->productCollectionFactory->create();

        $sort = ['DESC', 'ASC'];
        $success = 0;
        $filterList = [];
        if ($sortAlphaName != null) {
            if (in_array($sortAlphaName, $sort)) {
                $filterList = $collection->addAttributeToSelect('*')
                    ->addAttributeToSort('name', $sortAlphaName)
                    ->addAttributeToFilter('vendor_id', array('in' => $listVendorId));
                $success = 1;
            }
        } else  if ($sortPrice != null) {
            if (in_array($sortPrice, $sort)) {
                $filterList = $collection->addAttributeToSelect('*')
                    ->addAttributeToSort('price', $sortPrice)
                    ->addAttributeToFilter('vendor_id', array('in' => $listVendorId));
                $success = 1;
            }
        } else {
            $filterList = $collection->addAttributeToSelect('*')
                ->addAttributeToSort('created_at', 'DESC')
                ->addFieldToFilter('vendor_id', array('in' => $listVendorId));
            $success = 1;
        }

        if ($success == 0) {
            return null;
        }
        return  $this->customPaginate($filterList, $pageSize, $currenPage);
    }

    public function getProductCollectionByCategories($ids)
    {
        $collection = $this->productCollectionFactory->create();
        $collection->addAttributeToSelect('*');
        $collection->addCategoriesFilter(['in' => $ids]);
        return $collection;
    }

    //get list id product by cate id from interest of customer id - recommend
    public function getListProductIdByInterest($cusid)
    {
        //get list cate id by id customer recommend/interest
        $test = $this->interest->getInterestBycustomerId($cusid);
        if (!$test) return null;
        $listCateInterest = [];
        foreach ($test->getInfo() as $interest) {
            $listCateInterest[] = $interest['category_id'];
        }
        // get all product from list cate id
        $productByCateId = [];
        if (count($listCateInterest) > 0) {
            foreach ($listCateInterest as $id) {

                $productByCateId_tmp = $this->getProductCollectionByCategories($id)->getData();
                if (count($productByCateId_tmp) > 0) {
                    $productByCateId[] = $productByCateId_tmp;
                }
            }
        }
        $listProductId = [];
        if (count($productByCateId) > 0) {
            foreach ($productByCateId as $product) {
                foreach ($product as $val) {
                    $listProductId[] = $val['sku'];
                }
            }
        }
        $listProductId_unique = array_unique($listProductId);

        return $listProductId_unique;
    }

    public function recommendProductProductPage($cusId)
    {
        $result = [];
        $listProductId_recommend = $this->getListProductIdByInterest($cusId);
        if (count($listProductId_recommend)) {
            foreach ($listProductId_recommend as $id) {
                $product = $this->productRepository->get($id);
                $result[] = $product;
            }
        }
        $sort_result = $this->sortArrayProductByTime($result, "DESC");
        return $sort_result;
    }

    public function getProductArrivalPage($attributeCode, $pageSize = null, $currenPage = null, $sortAlphaName = null, $sortPrice = null)
    {
        $collection = $this->productCollectionFactory->create();

        $sort = ['DESC', 'ASC'];
        $success = 0;
        $list = $collection->addAttributeToSelect('*')->addAttributeToFilter('status', 1);
        if ($sortAlphaName != null) {
            if (in_array($sortAlphaName, $sort)) {
                $filterList =  $list->addAttributeToSort('name', $sortAlphaName)
                    ->addAttributeToFilter($attributeCode, 1);
                $success = 1;
            }
        } else  if ($sortPrice != null) {
            if (in_array($sortPrice, $sort)) {
                $filterList = $list->addAttributeToSort('price', $sortPrice)
                    ->addAttributeToFilter($attributeCode, 1);
                $success = 1;
            }
        } else {
            $filterList = $list->addAttributeToSort('created_at', 'DESC')
                ->addAttributeToFilter($attributeCode, 1);
            $success = 1;
        }

        if ($success == 0) {
            return null;
        }
        $listArrivalProduct = $this->customPaginate($filterList, $pageSize, $currenPage);

        return $this->renConfigurableNewArrival($listArrivalProduct);
    }

    /**
     * @param array $attributeCode
     * @return array
     */
    public function getListAttributeCode($attributeCode)
    {
        if (!is_array($attributeCode)) {
            $attributeCode = explode(", ", $attributeCode);
        }
        foreach ($attributeCode as $code) {
            if ($code) {
                $data[] = $this->attributeRepository->get($code);
            }
        }
        return isset($data) ? $data : [];
    }

    public function getListAttrsByPre($pre)
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $connection = $objectManager->get('Magento\Framework\App\ResourceConnection')->getConnection('\Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION');
        $listAttr = $connection->fetchAll("SELECT attribute_code FROM `eav_attribute` WHERE entity_type_id = 4 and attribute_code like '$pre%'");
        $attrCode = [];
        foreach ($listAttr as $attr) {
            $attrCode[] = $attr['attribute_code'];
        }
        return $this->getListAttributeCode($attrCode);
    }

    /**
     * Retrieve collection processor
     *
     * @deprecated 102.0.0
     * @return CollectionProcessorInterface
     */
    private function getCollectionProcessor()
    {
        if (!$this->collectionProcessor) {
            $this->collectionProcessor = \Magento\Framework\App\ObjectManager::getInstance()->get(
                \Magento\Catalog\Model\Api\SearchCriteria\ProductCollectionProcessor::class
            );
        }
        return $this->collectionProcessor;
    }

    public function listProductBestSeller($size = null)
    {
        $result = [];
        try {
            $listProductFlip = $this->getListBestSelling();
            for ($i = 0; $i < count($listProductFlip); $i++) {
                if ($size && $i >= $size) break;
                $productOfSku = $this->productRepository->get($listProductFlip[$i]);
                if ($productOfSku->getStatus() == 1) {
                    $result[] = $productOfSku;
                }
            }
        } catch (\Exception $e) {
            // WRITE LOG
        }
        return $result;
    }

    /**
     * {@inheritDoc}
     */
    public function massDelete($vendorId, array $skus)
    {
        try {
            $vendor = $this->vendorFactory->create()->loadByIdentifier($vendorId);
            $id = $vendor->getId();
            if ($id) {
                // DELETE MULTI
                $ids = [];
                foreach ($skus as $sku) {
                    $product = $this->productRepository->get($sku);
                    if ($product->getVendorId() == $id) {
                        array_push($ids, $product->getId());
                        $this->productRepository->deleteById($sku);
                    }
                    if ( method_exists($product->getTypeInstance(), 'getUsedProducts') ){
                        $attributeOptions = $product->getTypeInstance()->getConfigurableAttributesAsArray($product);
                    }
                }

                /** clear attributes option custom */
                if ( isset($attributeOptions) && !empty($attributeOptions) ){
                    foreach ( $attributeOptions as $attribute ){
                        if ( strpos($attribute["attribute_code"], "v_") === 0 ){
                            $this->attributeRepository->deleteById($attribute["attribute_code"]);
                        }
                    }
                }

                // INDEXER DATA
                if (!empty($ids)) {
                    $indexers = $this->indexersFactory->create()->getItems();
                    foreach ($indexers as $indexer) {
                        $indexer->reindexList($ids);
                    }
                    return true;
                }
            }
        } catch (\Exception $e) {
            // WRITE LOG
        }
        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function createAttribute($frontendLabel, $attributeCode, $options)
    {
        if ($attributeCode == trim($attributeCode) && strpos($attributeCode, ' ') !== false) {
            /* has spaces, but not at beginning or end*/
            return false;
        }
        try {
            /*create attribute*/
            $dataAttribute = $this->helperData->setJsonAttributeProduct($frontendLabel, $attributeCode, $options);
            $attributeSave = $this->attributeRepository->save($dataAttribute);

            /* Attribute assign logic */
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $eavSetup = $objectManager->create(\Magento\Eav\Setup\EavSetup::class);
            $config = $objectManager->get(\Magento\Catalog\Model\Config::class);
            $attributeManagement = $objectManager->get(\Magento\Eav\Api\AttributeManagementInterface::class);
            $attributeSetId = $eavSetup->getAttributeSetId('catalog_product', 'Default');
            $ATTRIBUTE_GROUP = 'Product Details';
            $ATTRIBUTE_CODE = $attributeSave->getAttributeCode();

            /* map attribute to group 'default' and put into group attribute of product 'Custom Attribute'*/
            $group_id = $config->getAttributeGroupId($attributeSetId, $ATTRIBUTE_GROUP);
            $attributeManagement->assign(
                'catalog_product',
                $attributeSetId,
                $group_id,
                $ATTRIBUTE_CODE,
                999
            );
            // $listIndexer = ['catalog_product_attribute', 'vsbridge_attribute_indexer'];
            // foreach ($listIndexer as $indexerId) {
            //     $indexer = $this->indexerFactory->create()->load($indexerId);
            //     $indexer->reindexAll();
            // }
            return $attributeSave;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function createProductConfigurable($data)
    {
        $vendorId = $data['vendorId'];
        $listIdProduct = $listSkuProduct = $listAttribute = [];

        /* save product configurable - parent*/
        $this->save($data, false);
        $listSkuProduct[] = $skuProductConfig = $data['product']->getSku();

        /* create Attribute product*/
        $productVariants = $data['product']->getExtensionAttributes();
        foreach ($productVariants->getProductVariants() as $productVariant) {
            $att = $this->createAttribute($productVariant->getFrontendLabel(), $productVariant->getAttributeCode(), $productVariant->getOptions());
            if (!$att) {
                throw new \Magento\Framework\Webapi\Exception(__("An error occurred while creating the attribute."), 400);
            }
            /** use to assign product attribute id */
            $listAttribute[] = $att->getAttributeId();
        }

        /*save product children -- simple */
        foreach ($data['children'] as $productChild) {

            $data->setProduct($productChild);
            $this->save($data, false);

            $productVariants = $productChild->getExtensionAttributes()->getProductVariants();
            $listSkuProduct[] = $sku = $productChild->getSku();

            /** set attribute value index(int) for product children */
            $product = $this->helperData->setAttributeValueToProduct($sku, $productVariants);
           
            if (!$product) {
                // DELETE PRODUCT ERROR
                $this->massDelete($vendorId, $listSkuProduct);
                throw new \Magento\Framework\Webapi\Exception(__("An error occurred while creating the product."), 400);
            }
            $listIdProduct[] = $product->getId();
        }
        /** set config product configurable */
        $configProduct = $this->helperData->setConfigProductConfigurable($skuProductConfig, $listAttribute, $listIdProduct);

        if (!$configProduct) {
            // DELETE PRODUCT ERROR
            $this->massDelete($vendorId, $listSkuProduct);
            throw new \Magento\Framework\Webapi\Exception(__("An error occurred while creating the product configurable."), 400);
        }

        $listIdProduct[] = $configProduct->getId();

        $indexers = $this->indexersFactory->create()->getItems();
        foreach ($indexers as $indexer) {
            $indexer->reindexList($listIdProduct);
        }
        return true;
    }

    public function updateConfigurableProduct($data)
    {
        $vendorId = $data->getVendorId();
        $parentProduct = $data->getProduct();
        $childrenProducts = $data->getChildren();

        /** update Configurable product */
        $this->update($data->getProduct()->getSku(), $data, false);

        /** get children ids */
        $product = $this->productRepository->get($data->getProduct()->getSku());
        if ( method_exists($product->getTypeInstance(), 'getUsedProducts') ){
            $childProductIds = $product->getTypeInstance()->getUsedProductIds($product);
        }
        
        /** update and create attribute */
        $attributeVariants = $parentProduct->getExtensionAttributes()->getProductVariants();
        foreach ( $attributeVariants as $attribute ){
            if ( $attribute->getAttributeId() ){
                $attributeModel = $this->attributeRepository->get($attribute->getAttributeCode());
                $attributeModel->setFrontendLable($attribute->getFrontendLable());
                $attributeModel->setOptions($attribute->getOptions());
                $this->attributeRepository->save($attributeModel);
            }
            else {
                $attribute = $this->createAttribute($attribute->getFrontendLabel(), $attribute->getAttributeCode(), $attribute->getOptions());
            }
            $attributeIds[] = $attribute->getAttributeId();
        }
        
        /** update and create children product */
        if ( !empty($childrenProducts) ){
            foreach ( $childrenProducts as $childProduct ){
                if ( $childProduct->getId() ){
                    /** overwrite product */
                    $this->productRepository->save($childProduct);
                }
                else {
                    $data->setProduct($childProduct);
                    $this->save($data, false);
    
                    $productVariants = $childProduct->getExtensionAttributes()->getProductVariants();
                    /** set attribute value index(int) for product children */
                    $childProduct = $this->helperData->setAttributeValueToProduct($childProduct->getSku(), $productVariants);
                    if ( $childProduct === false ){
                        $this->productRepository->deleteById($data->getProduct()->getSku());
                        continue;
                    }
                }
                $childIds[] = $childProduct->getId();
            }
        }

        if ( isset($childProductIds) ){
            $childIds = isset($childIds) ? array_merge($childProductIds, $childIds) : $childProductIds;
        }
        /** set config product configurable */
        $this->helperData->setConfigProductConfigurable($parentProduct->getSku(), $attributeIds, $childIds);

        $productIds = array_merge([$parentProduct->getId()], $childIds);
        $indexers = $this->indexersFactory->create()->getItems();
        foreach ($indexers as $indexer) {
            $indexer->reindexList($productIds);
        }
        return true;
    }

    public function deleteOptions($productId, $attributeCode, $optionId)
    {
        if ( empty($optionId) ){
            throw new InputException(__('Invalid option id %1', $optionId));
        }

        $result = $this->eavOptionManagement->delete(
            \Magento\Catalog\Api\Data\ProductAttributeInterface::ENTITY_TYPE_CODE,
            $attributeCode,
            $optionId
        );

        if ( $result === true ){
            $indexers = $this->indexersFactory->create()->getItems();
            foreach ( $indexers as $indexer ){
                $indexer->reindexList([$productId]);
            }
        }

        return $result;
    }
}
