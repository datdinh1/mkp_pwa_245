<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Wiki\Vendors\Model;

use Wiki\Vendors\Api\SellerManagementInterface;
use Magento\Customer\Api\AccountManagementInterface;
use Magento\Framework\Exception\AuthenticationException;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Api\CategoryLinkRepositoryInterface;
use Magento\Catalog\Api\Data\CategoryProductLinkInterfaceFactory;
use Magento\Framework\Registry;
use Wiki\Credit\Model\CreditFactory;
use Magento\Framework\App\ObjectManager;
use Wiki\SampleImageUploader\Model\ImageInterestFactory;
use Wiki\VendorsSales\Model\OrderFactory;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Sales\Api\Data\OrderSearchResultInterfaceFactory as SearchResultFactory;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use Wiki\Vendors\Model\Api\CountOrderByStatusFactory;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory;
use Wiki\Vendors\Model\VendorConfigFactory;


/**
 * Handle various customer account actions
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @SuppressWarnings(PHPMD.TooManyFields)
 * @SuppressWarnings(PHPMD.ExcessiveClassComplexity)
 * @SuppressWarnings(PHPMD.CookieAndSessionMisuse)
 */
class SellerManagement implements SellerManagementInterface
{
    protected $orderCollectionFactory;

    protected $vendorUpload;

    /**
     * @var SearchResultFactory
     */
    protected $searchResultFactory = null;
    protected $sellerFactory;
    protected $orderMagento;
    protected $bannerFactory;
    protected $countOrderByStatus;

    /**
     * \Magento\Framework\Controller\Result\JsonFactory
     */
    private $resultJson;

    /**
     * @var \Magento\Customer\Api\AccountManagementInterface
     */
    protected $customerAccountManagement;

    /**        $this->searchCriteriaBuilder = $searchCriteriaBuilder;ndorFactory
     */
    protected $_vendorFactory;

    /**
     * @var \Wiki\ \Wiki\VendorsSales\Api\SalesManagementInterfaceVendors\Helper\Data
     */
    protected $_vendorHelper;

    /**
     * News model factory
     *
     * @var \Wiki\Credit\Model\CreditFactory
     */
    protected $_creditFactory;

    protected $interest;

    /**
     * @var SalesManagementInterface
     */
    private $path;

    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepositoryInterface;

    /**
     * @var CategoryLinkRepositoryInterface
     */
    protected $categoryLinkRepositoryInterface;

    /**
     * @var CategoryProductLinkInterfaceFactory
     */
    protected $categoryProductLinkFactory;

    protected $_orderFactory;
    protected $groupCollectionFactory;
    protected $vendorCollectionFactory;
    protected $ordersSellerFactory;

    /** @var SearchCriteriaBuilder */
    protected $searchCriteriaBuilder;
    /**
     * @var JoinProcessorInterface
     */
    private $extensionAttributesJoinProcessor;
    /**
     * @var \Magento\Catalog\Api\Data\ProductSearchResultsInterfaceFactory
     */

    protected $searchResultsFactory;
    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    protected $vendorConfig;
    /**
     * @param SearchResultFactory $searchResultFactory
     * @param AccountManagementInterface $customerAccountManagement
     * @param \Magento\Framework\Controller\Result\JsonFactory $resultJson
     * @param \Magento\Framework\Stdlib\DateTime\DateTime $date
     * @param SalesManagementInterface $path
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param JoinProcessorInterface $extensionAttributesJoinProcessor
     * @param \Magento\Catalog\Api\Data\ProductSearchResultsInterfaceFactory $searchResultsFactory
     */
    public function __construct(
        VendorConfigFactory $vendorConfig,
        CollectionFactory $orderCollectionFactory,
        CountOrderByStatusFactory $countOrderByStatus,
        \Wiki\Vendors\Helper\UploadImage $vendorUpload,
        JoinProcessorInterface $extensionAttributesJoinProcessor = null,
        SearchResultFactory $searchResultFactory,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \Magento\Sales\Model\OrderRepository $orderMagento,
        OrderFactory $orderFactory,
        \Wiki\Vendors\Model\Api\SellerPageFactory $sellerPageOfSellFactory,
        \Wiki\Vendors\Model\Api\CustomerFactory $customerOfSellFactory,
        \Wiki\Vendors\Model\Api\GeneralFactory $generalOfSellFactory,
        \Wiki\Vendors\Model\Api\SellerFactory $sellerFactory,
        AccountManagementInterface $customerAccountManagement,
        \Wiki\Vendors\Model\VendorFactory $vendorFactory,
        \Wiki\Vendors\Helper\Data $vendorHelper,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Customer\Model\CustomerFactory $customerFactory,
        Registry $coreRegistry,
        CreditFactory $creditFactory,
        \Magento\Customer\Model\Customer $customerModel,
        \Wiki\Vendors\Model\Vendor $vendorsModel,
        \Magento\Framework\App\ResourceConnection $resource,
        \Wiki\VendorsConfig\Helper\Data $configHelper,
        \Magento\Catalog\Model\ProductRepository $productRepository,
        \Magento\Catalog\Model\Product $productModel,
        \Magento\Catalog\Model\Category $category,
        \Magento\Framework\App\Filesystem\DirectoryList $directoryList,
        \Magento\Framework\Filesystem\Driver\File $file,
        \Magento\Framework\Filesystem $filesystem,
        \Magento\Catalog\Model\CategoryFactory $categoryFactory,
        \Magento\Catalog\Model\CategoryRepository $categoryRepository,
        \Magento\Catalog\Model\CategoryLinkRepository $categoryLink,
        \Magento\Catalog\Api\CategoryLinkManagementInterface $categoryLinkManagementInterface,
        \Magento\Framework\Filesystem\Io\File $io,
        \Magento\Theme\Block\Html\Header\Logo $logo,
        ImageInterestFactory $interest,
        \Magento\Framework\Stdlib\DateTime\DateTime $date,
        ProductRepositoryInterface $productRepositoryInterface,
        CategoryLinkRepositoryInterface $categoryLinkRepositoryInterface,
        CategoryProductLinkInterfaceFactory $categoryProductLinkFactory,
        \Wiki\Vendors\Model\ResourceModel\Group\CollectionFactory $groupCollectionFactory,
        \Wiki\Vendors\Model\ResourceModel\Vendor\CollectionFactory $vendorCollectionFactory,
        CollectionProcessorInterface $collectionProcessor = null,
        \Magento\Catalog\Api\Data\ProductSearchResultsInterfaceFactory $searchResultsFactory,
        \Wiki\Vendors\Model\Api\OrdersSellerFactory $ordersSellerFactory,
        \Wiki\Vendors\Model\Api\BannerFactory $bannerFactory
    ) {
        $this->extensionAttributesJoinProcessor = $extensionAttributesJoinProcessor
            ?: ObjectManager::getInstance()->get(JoinProcessorInterface::class);
        $this->searchResultFactory          = $searchResultFactory;
        $this->ordersSellerFactory          = $ordersSellerFactory;
        $this->searchResultsFactory         = $searchResultsFactory;
        $this->searchCriteriaBuilder        = $searchCriteriaBuilder;
        $this->productCollectionFactory     = $productCollectionFactory;
        $this->orderMagento                 = $orderMagento;
        $this->_orderFactory                = $orderFactory;
        $this->sellerPageOfSellFactory      = $sellerPageOfSellFactory;
        $this->generalOfSellFactory         = $generalOfSellFactory;
        $this->customerOfSellFactory        = $customerOfSellFactory;
        $this->sellerFactory                = $sellerFactory;
        $this->_customerAccountManagement   = $customerAccountManagement;
        $this->_vendorFactory               = $vendorFactory;
        $this->_vendorHelper                = $vendorHelper;
        $this->_storeManager                = $storeManager;
        $this->_customerFactory             = $customerFactory;
        $this->_coreRegistry                = $coreRegistry;
        $this->_creditFactory               = $creditFactory;
        $this->_customerModel               = $customerModel;
        $this->_vendorsModel                = $vendorsModel;
        $this->_resource                    = $resource;
        $this->_configHelper                = $configHelper;
        $this->_productRepository           = $productRepository;
        $this->_productModel                = $productModel;
        $this->_category                    = $category;
        $this->_directoryList               = $directoryList;
        $this->_filesystem                  = $filesystem;
        $this->_file                        = $file;
        $this->_categoryFactory             = $categoryFactory;
        $this->_io                          = $io;
        $this->_categoryRepository          = $categoryRepository;
        $this->_categoryLink                = $categoryLink;
        $this->_categoryLinkManagement      = $categoryLinkManagementInterface;
        $this->interest                     = $interest;
        $this->_logo                        = $logo;
        $this->date                         = $date;
        $this->groupCollectionFactory       = $groupCollectionFactory;
        $this->vendorCollectionFactory      = $vendorCollectionFactory;
        $this->productRepositoryInterface   = $productRepositoryInterface;
        $this->categoryLinkRepositoryInterface = $categoryLinkRepositoryInterface;
        $this->categoryProductLinkFactory   = $categoryProductLinkFactory;
        $this->collectionProcessor = $collectionProcessor ?: $this->getCollectionProcessor();
        $this->bannerFactory                = $bannerFactory;
        $this->vendorUpload                 = $vendorUpload;
        $this->countOrderByStatus           = $countOrderByStatus;
        $this->_orderCollectionFactory      = $orderCollectionFactory;
        $this->vendorConfig                 = $vendorConfig;
    }

    public function customerPaginateOrders($listOrders, $status, $pageSize, $currentPage)
    {
        $result = [];

        $searchCriteria = $this->searchCriteriaBuilder->create();
        if ($pageSize && $currentPage) {
            $searchCriteria->setPageSize($pageSize)->setCurrentPage($currentPage);
        }

        $listId = [];
        foreach ($listOrders as $order) {
            $listId[] = $order->getEntityId();
        }

        /** @var \Magento\Sales\Api\Data\OrderSearchResultInterface $searchResult */
        $searchResult = $this->searchResultFactory->create();
        $searchResult->addAttributeToFilter('entity_id', $listId)->setOrder('updated_at', 'desc');
        if ($status && strtolower($status) != 'all')  $searchResult->addAttributeToFilter('wk_status', $status);

        $response = $this->ordersSellerFactory->create();
        $response->setTotalCount($searchResult->getSize());

        $this->extensionAttributesJoinProcessor->process($searchResult);
        $this->collectionProcessor->process($searchCriteria, $searchResult);
        $searchResult->setSearchCriteria($searchCriteria);

        foreach ($searchResult->getItems() as $item) {
            $result[] = $this->orderMagento->get($item->getEntityId());
        }

        $response->setItems($result);



        return $response;
    }
    /**
     * @inheritdoc
     */
    public function getStoreConfig()
    {
        $connection = $this->_resource->getConnection();
        $tableName = $this->_resource->getTableName('core_config_data');
        $query = "SELECT * FROM " . $tableName . " WHERE scope = 'stores' and scope_id = 1";
        $result = $connection->fetchAll($query);
        $array = [];
        $array[0] = [];
        foreach ($result as $data) {
            $array[0][$data["path"]] = $data["value"];
        }
        return $array;
    }

    /**
     * @inheritdoc
     */
    public function loginSeller($username, $password)
    {
        try {
            $customer = $this->_customerAccountManagement->authenticate($username, $password);
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $model = $objectManager->create('Wiki\Vendors\Model\Vendor');
            $customerNew = $objectManager->create('\Magento\Customer\Model\Customer')->load($customer->getId());
            $customerVendor = $model->loadByCustomer($customerNew);
            if (count($customerVendor->getData()) == 0) {
                return false;
            } else {
                return true;
            }
        } catch (AuthenticationException $e) {
            return false;
        }
    }

    /**
     * @inheritdoc
     */
    public function createSeller($data)
    {
        $websiteId  = $this->_storeManager->getWebsite()->getWebsiteId();
        $email = (is_array($data)) ? $data["email"] : $data->getEmail();
        $checkCustomer   = $this->_customerFactory->create()->setWebsiteId($websiteId)->loadByEmail($email);
        if ($checkCustomer->getId()) {
            $this->log("Create-Account: 'Email has already exist.'");
            throw new \Magento\Framework\Webapi\Exception(
                __("Email has already exist."),
                400
            );
        }
        $connection = $this->_resource->getConnection();
        $tableName = $this->_resource->getTableName("ves_vendor_entity");
        $query = "SELECT entity_id FROM " . $tableName;
        $result = $connection->fetchAll($query);
        if (count($result) > 0) {
            $max = max($result);
        } else {
            $max["entity_id"] = 0;
        }
        $newEntity = $max["entity_id"] + 1;

        $customer   = $this->_customerFactory->create();
        $customer->setWebsiteId($websiteId);
        $customer->setEmail($data->getEmail());
        if ( $data->getPassword() ) {
            $customer->setPassword($data->getPassword());
        }
        $customer->setFirstname($data->getFirstName());
        $customer->setLastname($data->getLastName());
        $customer->save();

        $creditsModel = $this->_creditFactory->create();
        $creditsModel->setCustomerId($customer->getId());
        $creditsModel->setCredit(0.0000);
        $creditsModel->save();

        $vendor = $this->_vendorFactory->create();
        // $this->orderMagento->get($order_entity);
        $vendor->setVendorId("SELLER" . $newEntity);
        $vendor->setGroupId($this->_vendorHelper->getDefaultVendorGroup());
        $vendor->setCustomer($customer);
        $vendor->setWebsiteId($customer->getWebsiteId());
        $vendor->setStatus(Vendor::STATUS_APPROVED);
        $vendor->save();
        $this->_coreRegistry->register("current_vendor_id", $vendor->getId());
        $vendor->setData("flag_notify_email", 0)->save();

        // //save category image interest
        // if (count($data['image_id']) > 0) {
        //     $interestImage = $this->interest->create();
        //     $image_id = json_encode($data['image_id']);
        //     $interestImage->setImageId($image_id);
        //     $interestImage->setCustomerId($customer->getEntityId());
        //     $interestImage->save();
        // }

        return true;
    }

    public function getDataAccount($namestore)
    {
        try {
            $vendor = $this->_vendorsModel->loadByIdentifier($namestore);
            $type   = "namestore";
            return $this->getDataVendor($vendor, $type);
        } catch (AuthenticationException $e) {
            return false;
        }
    }

    public function getDataMyStoreById($id)
    {
        try {
            $type   = "id";
            return $this->getDataVendor($id, $type);
        } catch (AuthenticationException $e) {
            return $e;
        }
    }

    public function getDataMyStoreByProductID($productId)
    {
        try {
            $type   = "productId";
            return $this->getDataVendor($productId, $type);
        } catch (AuthenticationException $e) {
            return null;
        }
    }

    public function getDataMyStoreByVendorID($vendorID)
    {
        try {
            $type   = "vendorID";
            return $this->getDataVendor($vendorID, $type);
        } catch (AuthenticationException $e) {
            return $e;
        }
    }


    /**
     * @inheritdoc
     */
    public function getDataVendor($dataVendor, $type)
    {
        if ($type == "namestore") {
            $customer               = $this->_customerModel->load($dataVendor->getId());
            $id                     = $dataVendor->getId();
            $existsCustomer         = 1;
        } else if ($type == "id") {
            $customer               = $this->_customerModel->load($dataVendor);
            $customerVendor         = $this->_vendorsModel->loadByCustomer($customer);
            $id                     = $customerVendor->getEntityId();
            $existsCustomer         = 1;
        } else if ($type == "productId") {
            $product                = $this->_productRepository->getById($dataVendor);
            if (null != ($product->getVendorId()) && $product->getVendorId() > 0) {
                $id                     = $product->getVendorId();
            } else return null;
            $existsCustomer         = 0;
        } else if ($type == "vendorID") {
            $id = $dataVendor;
            $existsCustomer         = 0;
        } else {
            return null;
        }
        if ($existsCustomer == 1) {
            $customerVendor         = $this->_vendorsModel->loadByCustomer($customer);
            $credit                 = $this->_creditFactory->create()->loadByCustomerId($customer->getId());
        }
        $customer   = $this->_customerFactory->create();
        $customerData           = $customer->getData();
        $customerData['gender'] = $customer->getAttribute('gender')->getSource()->getOptionText($customer->getData('gender'));
        $customerData['dob']    = date('d-m-Y', strtotime($customer->getDob()));
        $scopeConfig            = $this->_configHelper->getVendorConfig('general/store_information/logo_image_seller', $id);
        $basePath               = 'ves_vendors/logo/';
        $objectManager          = \Magento\Framework\App\ObjectManager::getInstance();
        if ($scopeConfig)
            $image              = $basePath . $scopeConfig;
        else $image             = null;

        $scopeConfig            = $this->_configHelper->getVendorConfig('general/store_information/favicon_icon_seller', $id);

        if ($scopeConfig)
            $imageFalcon        = $basePath . $scopeConfig;
        else $imageFalcon       = null;

        $scopeConfig            = $this->_configHelper->getVendorConfig('general/store_information/logo', $id);
        if ($scopeConfig)
            $imageLogo          = $basePath . $scopeConfig;
        else $imageLogo         = null;

        $nameStore              = $this->_configHelper->getVendorConfig('general/store_information/name', $id);
        $nameDesc               = $this->_configHelper->getVendorConfig('general/store_information/detail_store', $id);
        $namePhone              = $this->_configHelper->getVendorConfig('general/store_information/phone', $id);
        $nameHours              = $this->_configHelper->getVendorConfig('general/store_information/hours', $id);
        $scopeConfigCoverImage  = $this->_configHelper->getVendorConfig('general/store_information/cover_image_seller', $id);

        if ($scopeConfigCoverImage)
            $coverImage          = $basePath . $scopeConfigCoverImage;
        else $coverImage        = null;
        $sellerBanner           = $this->_configHelper->getVendorConfig('page/general/banner', $id);
        $sellerImageBanner      = $sellerBanner;

        $sellerDescription      = $this->_configHelper->getVendorConfig('page/general/description', $id);
        $sellerRefundPolicy     = $this->_configHelper->getVendorConfig('page/general/refund_policy', $id);
        $sellerShippingPolicy   = $this->_configHelper->getVendorConfig('page/general/shipping_policy', $id);
        $sellerUrlWebsite       = $this->_configHelper->getVendorConfig('page/social/website', $id);
        $sellerUrlFacebook      = $this->_configHelper->getVendorConfig('page/social/facebook', $id);
        $sellerUrlTwitter       = $this->_configHelper->getVendorConfig('page/social/twitter', $id);
        $sellerUrlInstagram     = $this->_configHelper->getVendorConfig('page/social/instagram', $id);
        $sellerUrlGooglePlus    = $this->_configHelper->getVendorConfig('page/social/google_plus', $id);
        $sellerUrlYoutube       = $this->_configHelper->getVendorConfig('page/social/youtube', $id);
        $sellerUrlPinterest     = $this->_configHelper->getVendorConfig('page/social/pinterest', $id);
        $sellerUrlVimeo         = $this->_configHelper->getVendorConfig('page/social/vimeo', $id);
        $productCollection      = $this->_productModel->getCollection()->addAttributeToFilter('vendor_id', $id);
        $productCollection      = $productCollection->joinField(
            'qty',
            'cataloginventory_stock_item',
            'qty',
            'product_id=entity_id',
            '{{table}}.stock_id=1',
            'left'
        );

        $connection = $objectManager->get('Magento\Framework\App\ResourceConnection')->getConnection('\Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION');


        $listProduct = $connection->fetchAll("SELECT entity_id,vendor_id FROM catalog_product_entity");
        $listRating = $connection->fetchAll("SELECT entity_pk_value,percent_approved FROM rating_option_vote_aggregated ");
        $listVendors = [];

        foreach ($listRating as $rating) {
            foreach ($listProduct as $product) {
                if ($rating['entity_pk_value'] == $product['entity_id'] && $product['vendor_id'] == $id) {
                    $listVendors[] = $rating['percent_approved'];
                }
            }
        }
        $average = 0;
        if (count($listVendors) > 0) {
            $average = array_sum($listVendors) / count($listVendors);
            $average = round($average / 20, 1);
        }

        /***-------get wishlist number ---------- */

        $wishListTmp = [];
        $listWishList = $connection->fetchAll("SELECT product_id,wishlist_id FROM wishlist_item ");

        foreach ($listWishList as $wishlist) {
            foreach ($listProduct as $product) {
                if ($wishlist['product_id'] == $product['entity_id'] && $product['vendor_id'] == $id) {
                    if (!in_array($wishlist['wishlist_id'], $wishListTmp)) {
                        $wishListTmp[] = $wishlist['wishlist_id'];
                    }
                }
            }
        }
        $wishListing = '';
        $countWish = count($wishListTmp);

        //format number display
        if ($countWish < 1000) {
            $wishListing = $countWish . "";
        } else if ($countWish < 1000000) {
            $wishListing = round($countWish / 1000, 1) . 'k';
        } else if ($countWish < 1000000000) {
            $wishListing = round($countWish / 1000000, 1) . 'm';
        } else {
            $wishListing = round($countWish / 1000000000, 1) . 'b';
        }
        $result = $this->_vendorsModel->load($id);
        $arrTemp = $result->getData();
        $arrTemp['general']['falcon']               = $imageFalcon;
        $arrTemp['general']['seller_logo']          = $image;
        $arrTemp['general']['logo']                 = $imageLogo;
        $arrTemp['general']['store_name']           = $nameStore;
        $arrTemp['general']['store_detail']         = $nameDesc;
        $arrTemp['general']['store_phone']          = $namePhone;
        $arrTemp['general']['store_hours']          = $nameHours;
        $arrTemp['general']['cover_image']          = $coverImage;

        if (empty($sellerImageBanner)) $arrTemp['sellerpage']['banner'] = $sellerImageBanner;
        else if (!empty(json_decode($sellerImageBanner))) {
            $banners = [];
            $arrDecode = json_decode($sellerImageBanner, true);
            if (is_array($arrDecode[0])) {
                $vendorsModelBanners = $this->vendorConfig->create()->getCollection()->addFieldToFilter('path', 'page/general/banner')->addFieldToFilter('vendor_id', $id)->getFirstItem();
                $vendorsModelBanners->setValue()->save();
            } else {
                foreach (json_decode($sellerImageBanner, true) as $key => $value) {
                    $imageBanners = $this->vendorUpload->getBannerByIdImage($value);
                    if ($imageBanners) {
                        $arr['image'] = 'ves_vendors/banners/' . $imageBanners->getImage();
                        $arr['url'] = $imageBanners->getTitle();
                        $arr['id'] = $imageBanners->getId();
                    }

                    $banners[] = $arr;
                }
            }
            $arrTemp['sellerpage']['banner'] = $banners;
        } else {
            $arrTemp['sellerpage']['banner'] = 'ves_vendors/banner/' . $sellerImageBanner;
        }
        $arrTemp['sellerpage']['about_me']          = $sellerDescription;
        $arrTemp['sellerpage']['refund_policy']     = $sellerRefundPolicy;
        $arrTemp['sellerpage']['shipping_policy']   = $sellerShippingPolicy;
        $arrTemp['sellerpage']['urlwebsite']        = $sellerUrlWebsite;
        $arrTemp['sellerpage']['urlfacebook']       = $sellerUrlFacebook;
        $arrTemp['sellerpage']['urltwitter']        = $sellerUrlTwitter;
        $arrTemp['sellerpage']['urlinstagram']      = $sellerUrlInstagram;
        $arrTemp['sellerpage']['urlgoogle_plus']    = $sellerUrlGooglePlus;
        $arrTemp['sellerpage']['urlyoutube']        = $sellerUrlYoutube;
        $arrTemp['sellerpage']['urlpinterest']      = $sellerUrlPinterest;
        $arrTemp['sellerpage']['urlvimeo']          = $sellerUrlVimeo;
        $arrTemp['customer']                        = $customerData;

        foreach ($productCollection as $collection) {
            $product = $this->_productRepository->get($collection->getSku());
            $arrTemp['items'][]          = $product;
            $collection->getImage();
        }
        $arrTemp['totalItem'] = count($productCollection);
        $arrTemp['rating'] = $average;
        $arrTemp['wishlist'] = $wishListing;
        $seller[] =  $arrTemp;
        return $seller;
    }

    /**
     *
     * @inheritdoc
     */

    public function updateDataMyStore($vendorId, $cover_image, $logo, $store_name, $store_detail, $banners = NULL, $deleteBanners = NULL)
    {
        $this->_vendorHelper->fixPath($vendorId);
        $filePath = "ves_vendors/logo/";
        /** save cover_image, logo to folder */
        try {
            if (base64_decode($cover_image, true) == true) {
                $coverImage = $this->vendorUpload->uploadImage($cover_image, $filePath);
            }
            if (base64_decode($logo, true) == true) {
                $logoImage = $this->vendorUpload->uploadImage($logo, $filePath);
            }
            $vendor = $this->_vendorsModel->loadByIdentifier($vendorId);
            $model = $this->vendorConfig->create();
            $collection =   $model->getCollection()->addFieldToFilter('vendor_id', $vendor->getEntityId());

            if (count($collection) == 0) {
                $logoImage         = isset($logoImage) ? $logoImage : NULL;
                $coverImage   = isset($coverImage) ? $coverImage : NULL;
                $store_name   = isset($store_name) ? $store_name : NULL;
                $store_detail = isset($store_detail) ? $store_detail : NULL;

                $paths = ['logo', 'cover_image_seller', 'name', 'detail_store'];

                foreach ($paths as $path) {
                    $newModel = $this->vendorConfig->create();
                    $data = ['vendor_id' => $vendor->getEntityId()];
                    if ($path == 'logo') {
                        $data['path'] = 'general/store_information/logo';
                        $data['value'] = $logoImage;
                        $newModel->setData($data);
                        $newModel->save();
                    } else if ($path == 'cover_image_seller') {
                        $data['path'] = 'general/store_information/cover_image_seller';
                        $data['value'] = $coverImage;
                        $model->setData($data);
                        $model->save();
                    } else if ($path == 'name') {
                        $data['path'] = 'general/store_information/name';
                        $data['value'] = $store_name;
                        $model->setData($data);
                        $model->save();
                    } else if ($path == 'detail_store') {
                        $data['path'] = 'general/store_information/detail_store';
                        $data['value'] = $store_detail;
                        $model->setData($data);
                        $model->save();
                    }
                }
            } else {
                foreach ($collection as $item) {
                    if ($item['path'] == 'general/store_information/logo') {
                        if (!empty($logoImage)) {
                            $deleteImage = $item['value'];
                            if (!empty($deleteImage)) {
                                $this->vendorUpload->deleteImage($deleteImage, $filePath);
                            }
                            $item->setValue($logoImage)->save();
                        }
                    } else if ($item['path'] == 'general/store_information/cover_image_seller') {
                        if (!empty($coverImage)) {
                            $deleteCoverImage = $item['value'];
                            if (!empty($deleteCoverImage)) {
                                $this->vendorUpload->deleteImage($deleteCoverImage, $filePath);
                            }
                            $item->setValue($coverImage)->save();
                        }
                    } else if ($item['path'] == 'general/store_information/name') {
                        $item->setValue($store_name)->save();
                    } else if ($item['path'] == 'general/store_information/detail_store') {
                        $item->setValue($store_detail)->save();
                    }
                }
            }
        } catch (AuthenticationException $e) {
            return false;
        }

        $path = "ves_vendors/banners/";
        if (!empty($banners)) {
            $this->updateBannersSeller($banners, $vendorId, $path);
        }
        if (!empty($deleteBanners)) {
            $this->deleteBannersSeller($deleteBanners, $vendorId, $path);
        }

        return true;
    }

    public function deleteBannersSeller($listDelete, $vendorId, $path)
    {
        try {
            foreach ($listDelete as  $idImage) {
                $this->vendorUpload->deleteBanner($idImage, $path);
            }
            $model = $this->vendorConfig->create();
            $vendor = $this->_vendorsModel->loadByIdentifier($vendorId);

            $collection =   $model->getCollection()->addFieldToFilter('vendor_id', $vendor->getEntityId())
                ->addFieldToFilter('path', 'page/general/banner')->getFirstItem();
            if (!empty($collection->getId())) {
                $banners  = json_decode($collection->getValue(), true);
                foreach ($banners as $key => $banner) {
                    if (in_array($banner, $listDelete)) {
                        unset($banners[$key]);
                    }
                }
                if (count($banners) > 0) {
                    $bannersJson  = json_encode(array_values($banners));
                    $collection->setValue($bannersJson)->save();
                } else {
                    $collection->setValue()->save();
                }
            }
        } catch (\Exception $e) {
            return false;
        }
        return true;
    }

    public function updateBannersSeller($banners, $vendorId, $filePath)
    {
        // $filePath = "ves_vendors/banners/";
        $listBanner = [];

        $vendor = $this->_vendorsModel->loadByIdentifier($vendorId);
        $model = $this->vendorConfig->create();
        $collection =   $model->getCollection()->addFieldToFilter('vendor_id', $vendor->getEntityId())
            ->addFieldToFilter('path', 'page/general/banner')->getFirstItem();
        if (!empty($collection->getConfigId())) {
            $listBanner  = json_decode($collection->getValue(), true);
        }
        foreach ($banners as $banner) {
            if (base64_decode($banner->getImage(), true) == true) {
                $bannerImage = $this->vendorUpload->uploadBanners($banner->getImage(), $filePath, $banner->getUrl());

                if (!$bannerImage) return false;
                $listBanner[] = $bannerImage;
            }
        }
        if (count($listBanner) > 0) {
            $bannersJson  = json_encode($listBanner);

            try {
                if (empty($collection->getConfigId())) {
                    $newModel = $this->vendorConfig->create();
                    $data = [
                        'vendor_id' => $vendor->getEntityId(),
                        'path' => 'page/general/banner',
                        'value' => $bannersJson
                    ];
                    $newModel->setData($data)->save();
                } else {
                    $collection->setValue($bannersJson)->save();
                }
                return true;
            } catch (AuthenticationException $e) {
                //write log
            }
        }
        return false;
    }

    public function getMediaUrl()
    {
        $mediaUrl = $this->_storeManager->getStore()
            ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        return $mediaUrl;
    }

    /**
     * @inheritdoc
     */
    public function getConfigData()
    {
        $arrays = [];
        $arrays[] = "general/store_information/name";
        $arrays[] = "page/general/description";
        $arrays[] = "general/store_information/logo";
        $arrays[] = "general/store_information/phone";
        $arrays[] = "general/store_information/hours";
        $arrays[] = "page/general/refund_policy";
        $arrays[] = "page/general/shipping_policy";
        return $arrays;
    }

    /**
     * @inheritdoc
     */
    public function getAuctionProduct()
    {
        return false;
    }

    protected function saveCategory($nameCategory, $parent, $namestore = null)
    {
        $storeId = $this->_storeManager->getStore()->getStoreId();
        $url = empty($namestore) ? '' : $namestore . "/" . $nameCategory;
        $path = $parent->getPath();
        $childCategory = $this->_category;
        $childCategory->setStoreId($storeId);
        $childCategory->setName($nameCategory);
        $childCategory->setIsActive(true);
        $childCategory->setUrlKey($url);
        $childCategory->setPath($path);
        $childCategory->setParent($parent->getId());
        $childCategory->setParentId($parent->getId());
        $childCategory->save();
    }


    /**
     * @inheritdoc
     */
    //  Request data
    //  {
    //     "data": {
    //         "categoryID": "107",
    //         "searchSku": "new product",
    //         "searchPriceMin": "500",
    //         "searchPriceMax": "2000"
    //   }
    //  }
    public function searchProductID($data)
    {
        $collection         = $this->_productModel->getCollection()->addCategoriesFilter(array('nin' => $data["categoryID"]));
        if ($data["searchSku"] != "") {
            $collection         = $collection->addFieldToFilter('sku', array('like' => '' . $data["searchSku"] . '%'));
        }
        if ($data["searchPriceMax"] != "") {
            $collection = $collection->addAttributeToFilter('price', array('lt' => $data["searchPriceMax"]));
        }
        if ($data["searchPriceMin"] != "") {
            $collection = $collection->addAttributeToFilter('price', array('gt' => $data["searchPriceMin"]));
        }
        if (count($collection) == 0) {
            return false;
        }
        $arraySearchProduct = [];
        foreach ($collection as $key => $item) {
            $product        = $this->_productRepository->getById($item->getEntityId());
            $arraySearchProduct[$key] = $product->getData();
            $image          = $this->_storeManager->getStore()
                ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . "catalog/product" . $product->getImage();
            $arraySearchProduct[$key]["imageUrl"] = $image;
        }
        return $arraySearchProduct;
    }

    /**
     * @inheritdoc
     */
    //  Request data
    //  {
    //     "data": {
    //         "categoryID": "107",
    //         "searchSku": "new product",
    //         "searchPriceMin": "500",
    //         "searchPriceMax": "2000"
    //   }
    //  }
    public function addProductToCategory($data, $categoryID)
    {
        $categoryIds = [
            $categoryID
        ];
        foreach ($data as $item) {
            $this->_categoryLinkManagement->assignProductToCategories(
                $item["sku"],
                $categoryIds
            );
        }
        return true;
    }

    /**
     * @inheritdoc
     */
    //  Request data
    //  {
    //     "data": {
    //         "vendor_id": "1",
    //         "searchSku": "test product"
    //   }
    //  }
    public function searchProductManagement($data)
    {
        $productCollection      = $this->_productModel->getCollection();
        $productCollection      = $productCollection->addAttributeToFilter('vendor_id', $data["vendor_id"]);
        $productCollection      = $productCollection->addAttributeToFilter('status', 1);
        if ($data["searchSku"] != "") {
            $productCollection  = $productCollection->addFieldToFilter('sku', array('like' => '' . $data["searchSku"] . '%'));
        }
        $arrayProductManagement = [];
        foreach ($productCollection as $key => $item) {
            $product        = $this->_productRepository->getById($item->getEntityId());
            $arrayProductManagement[$key] = $product->getData();
            $image          = $this->_storeManager->getStore()
                ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . "catalog/product" . $product->getImage();
            $arrayProductManagement[$key]["imageUrl"] = $image;
        }
        return $arrayProductManagement;
    }


    public function checkOtpOfAccountMobile($mobile, $otp)
    {
        $objectManager          = \Magento\Framework\App\ObjectManager::getInstance();
        $connection = $objectManager->get('Magento\Framework\App\ResourceConnection')->getConnection('\Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION');
        $checkCustomerMobile     = $connection->fetchAll("SELECT * FROM `wk_otp` WHERE email = $mobile AND otp = $otp");

        if (count($checkCustomerMobile) > 0) {
            return true;
        }
        return false;
    }

    public function getListSeller()
    {
        $model = $this->_vendorsModel->getCollection()->getData();
        $tmp = [];
        foreach ($model as $data) {
            $tmp[$data['entity_id']] = $data['vendor_id'];
        }
        $result = $tmp;
        return $result;
    }

    public function getOrderByVendor($namestore, $type = null)
    {

        try {
            $vendor                 = $this->_vendorsModel->loadByIdentifier($namestore);
            $id                     = $vendor->getId();
            $customer               = $this->_customerModel->setWebsiteId(1)->loadByEmail($vendor->getEmail());
            $customerVendor         = $this->_vendorsModel->loadByCustomer($customer);
            if (count($customerVendor->getData()) == 0) {
                return null;
            } else {
                $objectManager          = \Magento\Framework\App\ObjectManager::getInstance();
                $connection = $objectManager->get('Magento\Framework\App\ResourceConnection')->getConnection('\Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION');
                $listOrderbyVendor      = $connection->fetchAll("SELECT order_id FROM `ves_vendor_sales_order` WHERE vendor_id = $id ORDER BY order_id DESC;");

                $result1 = [];
                if (count($listOrderbyVendor) > 0) {
                    foreach ($listOrderbyVendor as $orer) {
                        $order_entity = $orer['order_id'];
                        try{
                            $resultVendorOrder = $this->orderMagento->get($order_entity);
                            $result1[] = $resultVendorOrder;
                        } catch(\Exception $e){

                        }
                  
                      
                    }
                }
                $result2 = [];
                $idCus = $customer->getId();
                $result2 = $this->getOrderByCustomer($idCus);
                if ($type === 'seller') {
                    return $result1;
                } else if ($type === 'buyer') {
                    return $result2;
                } else {
                    $rsTmp['vendor_order'] = $result1;
                    $rsTmp['vendor_buyorder'] = $result2;
                    $result[] = $rsTmp;
                }
            }
        } catch (AuthenticationException $e) {
            return false;
        }
    }

    public function getInfoVendor($customer_id = null, $product_id = null, $vendor_id = null)
    {
        if ($customer_id == null && $product_id == null && $vendor_id == null)
            return null;

        if ($customer_id) {
            $data = $this->getDataMyStoreById($customer_id);
        } else if ($product_id) {
            $data = $this->getDataMyStoreByProductID($product_id);
        } else if ($vendor_id) {
            $data = $this->getDataAccount($vendor_id);
        }

        $response = $this->sellerFactory->create();
        $responseCustomer = $this->customerOfSellFactory->create();
        $responseCustomer->setData($data[0]['customer']);

        $responseGeneral = $this->generalOfSellFactory->create();
        $responseGeneral->setData($data[0]['general']);


        $responseSellerPage = $this->sellerPageOfSellFactory->create();

        $banners = $data[0]['sellerpage']['banner'];

        if (empty($banners)) $responseBanner = [];
        else {
            foreach ($banners as $banner) {
                $bannerInterface = $this->bannerFactory->create();
                $bannerInterface->setData($banner);
                $responseBanner[] = $bannerInterface;
            }
        }

        $responseSellerPage->setData($data[0]['sellerpage']);
        $responseSellerPage->setBanners($responseBanner);

        $response->setData($data[0]);
        $response->setCustomer($responseCustomer);
        $response->setGeneral($responseGeneral);
        $response->setSellerPage($responseSellerPage);
        return $response;
    }

    public function getItemsByVendorId($vendorId, $pageSize = null, $currentPage = null)
    {
        $vendor                 = $this->_vendorsModel->loadByIdentifier($vendorId);
        $id                     = $vendor->getId();

        if (empty($id)) return false;
        $collectionFactory = $this->productCollectionFactory->create();
        $collection = $collectionFactory->addAttributeToSelect('*')->addFieldToFilter('vendor_id', $id);

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
            $productOfSku = $this->_productRepository->get($sku);
            $result[] = $productOfSku;
        }
        return $result;
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

    public function getBuyerOrderOfVendorId($vendorId, $status = null, $pageSize = null, $currentPage = null)
    {
        $vendor       = $this->_vendorsModel->loadByIdentifier($vendorId);
        $id           = $vendor->getId();

        if (empty($id)) return false;
        if (empty($pageSize)) $pageSize = 10;
        if (empty($currentPage)) $currentPage = 1;

        try {
            $listOrders    = $this->getOrderByVendor($vendorId, 'buyer');
        } catch (\Exception $e) {
            return [];
        }
        if (count($listOrders) == 0) return null;
        $buyerOrders   = $this->customerPaginateOrders($listOrders, $status, $pageSize, $currentPage);

        return $buyerOrders;
    }

    public function getSellerOrderOfVendorId($vendorId, $status = null, $pageSize = null, $currentPage = null)
    {
        $vendor       = $this->_vendorsModel->loadByIdentifier($vendorId);
        $id           = $vendor->getId();

        if (empty($id)) return false;
        try {
            $listOrders    = $this->getOrderByVendor($vendorId, 'seller');
        } catch (\Exception $e) {
            return [];
        }
        if (count($listOrders) == 0) return null;
        if (empty($pageSize)) $pageSize = 10;
        if (empty($currentPage)) $currentPage = 1;
        $sellerOrders  = $this->customerPaginateOrders($listOrders, $status, $pageSize, $currentPage);

        return $sellerOrders;
    }

    public function getOrderByCustomer($id)
    {
        $result = [];
        $collection = $this->_orderCollectionFactory->create()
            ->addAttributeToSelect('*')
            ->addFieldToFilter('customer_id', $id);
        if (count($collection) > 0) {
            foreach ($collection as $orer) {
                $order_entity = $orer['entity_id'];
                try{
                    $resultVendorBuyer = $this->orderMagento->get($order_entity);
                    $result[] = $resultVendorBuyer;
                } catch(\Exception $e){
                    //write log and ignore product error
                }
            }
        }
        return $result;
    }
    public function countWkStatusInterface($orders)
    {
        $listStatus = $result = [];
        foreach ($orders as $order) {
            $wkStatus = $order->getWkStatus();
            if (isset($listStatus[$wkStatus])) {
                $listStatus[$wkStatus]++;
            } else {
                $listStatus[$wkStatus] = 1;
            }
        }
        foreach ($listStatus as $status => $count) {
            $respone = $this->countOrderByStatus->create();
            $respone->setWkStatus($status);
            $respone->setCount($count);
            $result[] = $respone;
        }
        return $result;
    }
    public function countOrdersByStatus($id, $type)
    {
        try {
            if ($type == 'S') {
                $orders = $this->getOrderByVendor($id, 'seller');
                if (!$orders) return;
                return $this->countWkStatusInterface($orders);
            } else if ($type == 'B') {
                $orders = $this->getOrderByCustomer($id);
                if (!$orders) return;
                return $this->countWkStatusInterface($orders);
            }
        } catch (\Exception $e) {
            return [];
        }
    }

    public function noviceSeller($vendorId)
    {
        $connection = $this->_resource->getConnection();
        $tableName = $this->_resource->getTableName('ves_vendor_entity');
        $update = "UPDATE $tableName SET is_novice = false WHERE vendor_id = '$vendorId'";
        try {
            $connection->query($update);
        } catch (\Exception $e) {
            return false;
        }
        return true;
    }
    protected function log($data)
    {
        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/accountsellers.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        $logger->info($data);
    }
}
