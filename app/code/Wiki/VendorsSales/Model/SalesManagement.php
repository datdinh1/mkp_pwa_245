<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Wiki\VendorsSales\Model;

use Wiki\VendorsSales\Api\SalesManagementInterface;
use Wiki\VendorsSales\Model\OrderFactory;
use Wiki\VendorsSales\Model\Order\InvoiceFactory;
use Wiki\VendorsSales\Model\SalesVendorsFactory;
use Magento\Sales\Api\Data\InvoiceSearchResultInterfaceFactory as SearchResultFactory;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Sales\Api\Data\InvoiceCommentCreationInterface;
use Magento\Sales\Api\Data\InvoiceCreationArgumentsInterface;
use Magento\Sales\Model\InvoiceOrder;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Model\Order;
use Magento\Framework\App\ResourceConnection;

use Wiki\Vendors\Api\SellerManagementInterface;
use Wiki\VendorsSales\Model\Api\Data\AccountPageSaleFactory;
use Wiki\VendorsSales\Model\Api\ApplyCoupon;
use Wiki\VendorsSales\Helper\Data;
use Wiki\VendorsSales\Model\RequestReturnOrderFactory;
use Wiki\VendorsSales\Model\ResourceModel\Order\CollectionFactory as WikiOrderResource;
use Wiki\VendorsNotification\Helper\Data as DataNotification;

use Wiki\VendorsChat\Api\ChatManagementInterface;
use Magento\Framework\Api\ExtensibleDataObjectConverter;

/**
 * Handle various customer account actions
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @SuppressWarnings(PHPMD.TooManyFields)
 * @SuppressWarnings(PHPMD.ExcessiveClassComplexity)
 * @SuppressWarnings(PHPMD.CookieAndSessionMisuse)
 */
class SalesManagement implements SalesManagementInterface
{
    protected $chatManagementInterface;
    protected $helperData;

    protected $requetReturn;
    protected $dataHelper;

    /**
     * Carrier's code
     * @var string
     */
    protected $_code = 'donotuseunderlines';

    protected $vendorSale;
    protected $_orderFactory;
    protected $_salesVendorFactory;
    protected $orderMagento;
    protected $_urlInterface;
    protected $collectionInvoice;

    /**
     * @var SearchResultFactory
     */
    protected $searchResultFactory;

    /**
     * @var \Wiki\VendorsSales\Controller\Vendors\Order\ShipmentLoader
     * @param \Wiki\VendorsSales\Controller\Vendors\Order\ShipmentLoader $shipmentLoader
     */
    protected $shipmentLoader;

    private $subscriptionCreator;

    /**
     * @param SearchResultFactory $searchResultFactory
     * @param \Magento\Sales\Api\Data\InvoiceCommentCreationInterface|null $comment
     * @param \Magento\Sales\Api\Data\InvoiceCreationArgumentsInterface|null $arguments
     * @param Order\StatusResolver $statusResolver
     */

    /**
     * @var Registry
     */
    protected $registry;

    /**
     * @var \Wiki\Vendors\Model\VendorFactory
     */
    protected $_vendorFactory;

    /**
     * @var \Magento\Framework\Event\ManagerInterface
     */
    protected $_eventManager;

    /**
     * @var \Wiki\VendorsSales\Model\OrderFactory
     */
    protected $_vendorOrderFactory;

    /**
     * @var Order\StatusResolver
     */
    protected $statusResolver;

    /**
     * Tax module helper
     * @var \Magento\Framework\Module\Manager
     */
    protected $_moduleManage;

    /**
     * @var Order\SalesVendorsFactory
     */
    protected $_salesVendorsFactory;

    /**
     * @var OrderSender
     */
    protected $_orderSender;

    /**
     * @var \Magento\Quote\Api\Data\CartItemInterfaceFactory
     */
    protected $cartItemFactory;

    /**
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    protected $product;

    /**
     * @var \Magento\Quote\Api\Data\CartInterface
     */
    protected $quote;

    /**
     * @var ApplyCoupon
     */
    protected $applyCoupon;

    protected $resourceConnection;
    protected $accountPage;
    protected $vendorResourceOrder;
    /*
    * @param Magento\Quote\Api\CartRepositoryInterface $cartRepositoryInterface,
    * @param Magento\Quote\Api\CartManagementInterface $cartManagementInterface
    */
    public function __construct(
        ExtensibleDataObjectConverter $dataObjectConverter,
        ChatManagementInterface $chatManagementInterface,
        DataNotification       $helperDataNotification,
        WikiOrderResource           $vendorResourceOrder,
        RequestReturnOrderFactory $requestReturn,
        Data $dataHelper,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        OrderFactory $orderFactory,
        \Wiki\Vendors\Model\Vendor $vendorsModel,
        \Magento\Customer\Model\Customer $customerModel,
        \Magento\Sales\Model\OrderRepository $orderMagento,
        \Magento\Sales\Model\OrderFactory $orderFactoryMagento,
        \Magento\Framework\UrlInterface $urlInterface,
        \Magento\Sales\Model\Order\InvoiceRepository $invoiceRepository,
        InvoiceFactory $collectionInvoice,
        SearchResultFactory $searchResultFactory,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        \Wiki\VendorsSales\Controller\Vendors\Order\ShipmentLoader $shipmentLoader,
        InvoiceOrder $subscriptionCreator,
        \Magento\Framework\Registry $registry,
        \Wiki\Vendors\Model\VendorFactory $vendorFactory,
        \Magento\Framework\Event\ManagerInterface $eventManager,
        \Wiki\VendorsSales\Model\OrderFactory $vendorOrderFactory,
        \Magento\Sales\Model\Order\StatusResolver $statusResolver,
        \Magento\Framework\Module\Manager $moduleManage,
        \Wiki\VendorsSales\Model\Order\Email\Sender\OrderSender $orderSender,
        SalesVendorsFactory $salesVendorsFactory,
        \Magento\Quote\Api\Data\CartItemInterfaceFactory $cartItemFactory,
        \Magento\Catalog\Api\ProductRepositoryInterface $product,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Catalog\Model\Product $productCatalog,
        \Magento\Framework\Data\Form\FormKey $formkey,
        \Magento\Quote\Model\QuoteFactory $quote,
        \Magento\Quote\Model\QuoteManagement $quoteManagement,
        \Magento\Customer\Model\CustomerFactory $customerFactory,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository,
        \Magento\Sales\Model\Service\OrderService $orderService,
        \Magento\Quote\Api\CartRepositoryInterface $quoteRepository,
        \Magento\Checkout\Model\Cart $cart,
        \Magento\SalesRule\Model\Coupon $coupon,
        \Magento\SalesRule\Model\Rule $saleRule,
        \Magento\Sales\Model\Order\ItemFactory $itemFactory,
        ResourceConnection $resourceConnection,
        SellerManagementInterface $sellerInterface,
        AccountPageSaleFactory $accountPage,
        OrderInterface $orderInterface,
        ApplyCoupon $applyCoupon,
        \Magento\Sales\Api\OrderRepositoryInterface $orderRepository,
        \Magento\Quote\Api\CartRepositoryInterface $cartRepositoryInterface,
        \Magento\Quote\Api\CartManagementInterface $cartManagementInterface,
        \Magento\Sales\Api\OrderPaymentRepositoryInterface $paymentRepositoryInterface,
        \Magento\Sales\Model\Order\AddressRepository $addressRepository
    ) {
        $this->dataObjectConverter          = $dataObjectConverter;
        $this->chatManagementInterface      = $chatManagementInterface;      
        $this->helperData                   = $helperDataNotification;
        $this->vendorResourceOrder          = $vendorResourceOrder;
        $this->requestReturn                = $requestReturn;
        $this->dataHelper                   = $dataHelper;
        $this->_scopeConfig                 = $scopeConfig;
        $this->_orderFactory                = $orderFactory;
        $this->_vendorsModel                = $vendorsModel;
        $this->_customerModel               = $customerModel;
        $this->_urlInterface                = $urlInterface;
        $this->orderMagento                 = $orderMagento;
        $this->invoiceRepository            = $invoiceRepository;
        $this->collectionInvoice            = $collectionInvoice;
        $this->searchResultFactory          = $searchResultFactory;
        $this->searchCriteriaBuilder        = $searchCriteriaBuilder;
        $this->shipmentLoader               = $shipmentLoader;
        $this->orderFactoryMagento          = $orderFactoryMagento;
        $this->subscriptionCreator          = $subscriptionCreator;
        $this->registry                     = $registry;
        $this->_vendorFactory               = $vendorFactory;
        $this->_eventManager                = $eventManager;
        $this->_vendorOrderFactory          = $vendorOrderFactory;
        $this->statusResolver               = $statusResolver;
        $this->_moduleManage                = $moduleManage;
        $this->_salesVendorsFactory         = $salesVendorsFactory;
        $this->_orderSender                 = $orderSender;
        $this->cartItemFactory              = $cartItemFactory;
        $this->product                      = $product;
        $this->quote                        = $quote;
        $this->storeManager                 = $storeManager;
        $this->productCatalog               = $productCatalog;
        $this->quoteManagement              = $quoteManagement;
        $this->customerFactory              = $customerFactory;
        $this->customerRepository           = $customerRepository;
        $this->orderService                 = $orderService;
        $this->resourceConnection           = $resourceConnection;
        $this->quoteRepository              = $quoteRepository;
        $this->_cart                        = $cart;
        $this->_formKey                     = $formkey;
        $this->_coupon                      = $coupon;
        $this->_saleRule                    = $saleRule;
        $this->itemFactory                  = $itemFactory;
        $this->sellerInterface              = $sellerInterface;
        $this->accountPage                  = $accountPage;
        $this->orderInterface               = $orderInterface;
        $this->orderRepository              = $orderRepository;
        $this->applyCoupon                  = $applyCoupon;
        $this->cartRepositoryInterface = $cartRepositoryInterface;
        $this->cartManagementInterface = $cartManagementInterface;
        $this->paymentRepositoryInterface = $paymentRepositoryInterface;
        $this->addressRepository                 = $addressRepository;
    }

    /**
     * @inheritdoc
     */
    public function getConfig()
    {
        $data = $this->_scopeConfig->getValue(
            'vendors/sales',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
        return $data;
    }

    /**
     * @inheritdoc
     */

    public function getOrderByVendor($namestore, $token)
    {
        try {
            $vendor                 = $this->_vendorsModel->loadByIdentifier($namestore);
            $id                     = $vendor->getId();
            $customer               = $this->_customerModel->setWebsiteId(1)->loadByEmail($vendor->getEmail());
            $customerVendor         = $this->_vendorsModel->loadByCustomer($customer);
            if (count($customerVendor->getData()) == 0) {
                return "This is not account Seller";
            } else {
                $modOrder               = $this->_orderFactory->create();
                $colOrderbyVendor       = $modOrder->getCollection()->addFieldToFilter('vendor_id', $id)->getData();
                $objectManager          = \Magento\Framework\App\ObjectManager::getInstance();
                $connection = $objectManager->get('Magento\Framework\App\ResourceConnection')->getConnection('\Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION');
                $listOrderbyVendor      = $connection->fetchAll("SELECT order_id FROM `ves_vendor_sales_order` WHERE vendor_id = $id");
                //API URL for authentication
                $urlBase = $this->_urlInterface->getBaseUrl();
                //Using above token into header
                $headers = array("Authorization: Bearer " . $token);
                $strUR = $urlBase . 'rest/all/V1/orders/';
                $result1 = [];
                if (count($listOrderbyVendor) > 0) {
                    foreach ($listOrderbyVendor as $orer) {
                        $order_entity = $orer['order_id'];
                        $requestUrl =  $strUR . $order_entity;
                        $ch = curl_init($requestUrl);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        $resultVendorOrder = curl_exec($ch);
                        $resultVendorOrder =  json_decode($resultVendorOrder, true);
                        $result1[] = $resultVendorOrder;
                    }
                }
                $result2 = [];
                $idCus = $customer->getId();
                $listOrderBuyer = $connection->fetchAll("SELECT entity_id FROM `sales_order` WHERE customer_id = $idCus");
                if (count($listOrderBuyer) > 0) {
                    foreach ($listOrderBuyer as $orer) {
                        $order_entity = $orer['entity_id'];
                        $requestUrl =  $strUR . $order_entity;
                        $ch = curl_init($requestUrl);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        $resultVendorBuyer = curl_exec($ch);
                        // //decoding result
                        $resultVendorBuyer =  json_decode($resultVendorBuyer, true);
                        $result2[] = $resultVendorBuyer;
                    }
                }
                $rsTmp['vendor_order'] = $result1;
                $rsTmp['vendor_buyorder'] = $result2;
                $result[] = $rsTmp;
                return $result;
            }
        } catch (AuthenticationException $e) {
            return "Invalid login or password.";
        }
    }

    public function getListInvoiceByVendor($namestore)
    {

        try {
            $vendor                 = $this->_vendorsModel->loadByIdentifier($namestore);
            $id                     = $vendor->getId();
            $customer               = $this->_customerModel->setWebsiteId(1)->loadByEmail($vendor->getEmail());
            $customerVendor         = $this->_vendorsModel->loadByCustomer($customer);
            if (count($customerVendor->getData()) == 0) {
                return "This is not account Seller";
            } else {
                $invoice = $this->collectionInvoice->create();
                $collection  = $invoice->getCollection()->addFilter('vendor_id', $id);
                $tmp[] = $collection->getData();
                return $tmp;
            }
        } catch (AuthenticationException $e) {
            return "Invalid login or password.";
        }
    }
    public function getListShipmentByVendor($namestore)
    {
        try {
            $vendor                 = $this->_vendorsModel->loadByIdentifier($namestore);
            $id                     = $vendor->getId();
            $customer               = $this->_customerModel->setWebsiteId(1)->loadByEmail($vendor->getEmail());
            $customerVendor         = $this->_vendorsModel->loadByCustomer($customer);
            if (count($customerVendor->getData()) == 0) {
                return "This is not account Seller";
            } else {
                $objectManager          = \Magento\Framework\App\ObjectManager::getInstance();
                $connection             = $objectManager->get('Magento\Framework\App\ResourceConnection')->getConnection('\Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION');
                $listOrderbyVendor      = $connection->fetchAll("SELECT entity_id FROM `ves_vendor_sales_order` WHERE vendor_id = $id");
                $listShipment           = $connection->fetchAll("SELECT * FROM `sales_shipment_grid` ");
                $tmp = [];
                $valueOrderArr = [];
                foreach ($listOrderbyVendor as $order) {
                    $valueOrderArr[] = $order['entity_id'];
                }
                foreach ($listShipment as $order) {
                    if (in_array($order['vendor_order_id'], $valueOrderArr)) {
                        $tmp[] = $order;
                    }
                }
                return $tmp;
            }
        } catch (AuthenticationException $e) {
            return "Invalid login or password.";
        }
    }

    /**
     * Save shipment and order in one transaction
     *
     * @param \Magento\Sales\Model\Order\Shipment $shipment
     * @return $this
     */
    protected function _saveShipment($shipment, $id)
    {
        /*Set vendor Id*/
        $shipment->setVendorId($id);
        $shipment->getOrder()->setIsInProcess(true);
        $objectManager          = \Magento\Framework\App\ObjectManager::getInstance();
        $transaction = $objectManager->create(
            'Magento\Framework\DB\Transaction'
        );
        $transaction->addObject(
            $shipment
        )->addObject(
            $shipment->getOrder()
        )->save();
        return $this;
    }

    /**
     * @param \Magento\Sales\Api\Data\ShipmentItemCreationInterface[] $items
     * @param bool $notify
     * @param bool $appendComment
     * @param \Magento\Sales\Api\Data\ShipmentCommentCreationInterface|null $comment
     * @param \Magento\Sales\Api\Data\ShipmentTrackCreationInterface[] $tracks
     * @param \Magento\Sales\Api\Data\ShipmentPackageCreationInterface[] $packages
     * @return string
     * @throws \Magento\Sales\Api\Exception\DocumentValidationExceptionInterface
     * @throws \Magento\Sales\Api\Exception\CouldNotShipExceptionInterface
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \DomainException
     */
    public function createShipment(
        $order_id,
        array $items = [],
        $notify = false,
        $appendComment = false,
        \Magento\Sales\Api\Data\ShipmentCommentCreationInterface $comment = null,
        array $tracks = [],
        array $packages = [],
        \Magento\Sales\Api\Data\ShipmentCreationArgumentsInterface $arguments = null
    ) {
        $orderById = $this->orderFactoryMagento->create();
        $orderById->load($order_id);
        if (empty($orderById->getId()))
            return false;
        $orderVendor = $this->vendorResourceOrder->create()
            ->addFieldToFilter('order_id', $orderById->getId())
            ->getFirstItem();
        if (!empty($orderVendor->getId())) {
            $id = $orderVendor->getVendorId();
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $vendorOrder = $objectManager->create('Wiki\VendorsSales\Model\Order')->load($orderVendor->getId());
            $this->shipmentLoader->setOrderId($vendorOrder->getOrderId());
            $this->shipmentLoader->setVendorOrder($vendorOrder);
            $shipment = $this->shipmentLoader->load();
            if (!$shipment) {
                return 'Cannot save shipment. Please check order status again.';
            } else {
                $shipment->setVendorOrderId($vendorOrder->getId());
                $shipment->register();

                try {
                    $rs = '';
                    $this->_saveShipment($shipment, $id);
                    if (is_numeric($shipment->getEntityId())) {
                        $rs = 'Shipment entity: ' . $shipment->getEntityId();
                    }
                    return $rs;
                } catch (\Exception $e) {
                    throw new \Magento\Sales\Exception\CouldNotShipException(
                        __('Cannot save shipment, see error log for details')
                    );
                }
            }
        } else return 'haha';
    }

    /**
     * @param int $order_id_of_seller
     * @param bool $capture
     * @param array $items
     * @param bool $notify
     * @param bool $appendComment
     * @param \Magento\Sales\Api\Data\InvoiceCommentCreationInterface|null $comment
     * @param \Magento\Sales\Api\Data\InvoiceCreationArgumentsInterface|null $arguments
     * @return string
     * @throws \Magento\Sales\Api\Exception\DocumentValidationExceptionInterface
     * @throws \Magento\Sales\Api\Exception\CouldNotInvoiceExceptionInterface
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \DomainException
     */
    public function createInvoice(
        $order_id_of_seller,
        $capture = false,
        array $items = [],
        $notify = false,
        $appendComment = false,
        InvoiceCommentCreationInterface $comment = null,
        InvoiceCreationArgumentsInterface $arguments = null
    ) {
        $objectManager          = \Magento\Framework\App\ObjectManager::getInstance();
        /** @var \Wiki\VendorsSales\Model\Order $vendorOrder */
        $vendorOrder =  $objectManager->create('Wiki\VendorsSales\Model\Order')->load($order_id_of_seller);
        /** @var \Magento\Sales\Model\Order $order */
        $order =  $objectManager->create('Magento\Sales\Model\Order')->load($vendorOrder->getOrderId());
        if (!$vendorOrder->getId() || !$order->getId()) {
            throw new \Magento\Framework\Exception\LocalizedException(__('The order no longer exists.'));
        }
        if (!$vendorOrder->canInvoice() || !$order->canInvoice()) {
            throw new \Magento\Framework\Exception\LocalizedException(
                __('The order does not allow an invoice to be created.')
            );
        }
        $tmp = $this->subscriptionCreator->execute($vendorOrder->getOrderId(), $capture, $items, $notify, $appendComment, $comment, $arguments);
        if (is_numeric($tmp)) {
            $rs = 'Invoice entity: ' . $tmp;
        } else {
            $rs =  $tmp;
        }
        return $rs;
    }

    // Request Data
    // {
    //      "vendorId" : 3,
    //      "orderId"  : 10
    // }
    public function getOrder($vendorId, $orderId)
    {
        try {
            $objectManager          = \Magento\Framework\App\ObjectManager::getInstance();
            $connection = $objectManager->get('Magento\Framework\App\ResourceConnection')->getConnection('\Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION');
            $orderVendor = $connection->fetchAll("SELECT * FROM `ves_vendor_sales_order` WHERE vendor_id = $vendorId AND order_id = $orderId");
            $orderItems = $this->orderFactoryMagento->create()->load($orderId)->getAllVisibleItems();
            foreach ($orderItems as $item) {
                if ((int)$item['vendor_id'] == $vendorId) {
                    $orderVendor[0]['items'][] = $item->getData();
                }
            }
            return $orderVendor;
        } catch (Exception $e) {
            return "Exception : " . $e;
        }
    }


    public function getOrderAccountPage($idOrder)
    {
        $order     =  $this->orderMagento->get($idOrder);
        $items = $order->getItems();
        $idproduct = 0;
        foreach ($items as $item) {
            $idproduct = $item->getProductId();
            break;
        }
        $seller = $this->sellerInterface->getDataMyStoreByProductID($idproduct);
        $infoSeller = [];
        if ($seller) {
            $infoSeller = $seller[0];
        }
        $response = $this->accountPage->create();

        $response->setOrder($order);
        $response->setVendor($seller);
        return $response;
    }
    public function saveOrder($orderTmp, $payment, $address, $customer)
    {
        /* @var $orderFactory \Magento\Sales\Model\OrderFactory */
        $order =  $this->orderFactoryMagento->create()->setStoreId(1);
        $order
            ->setGlobalCurrencyCode("THB")
            ->setBaseCurrencyCode("THB")
            ->setStoreCurrencyCode("THB")
            ->setOrderCurrencyCode("THB");

        /* @var $orderPaymentRepository \Magento\Sales\Api\OrderPaymentRepositoryInterface */
        $orderPayment = $this->paymentRepositoryInterface->create();

        $orderPayment->setMethod($payment);
        $order->setPayment($orderPayment);

        /* @var $customer \Magento\Customer\Model\Customer */
        $order
            ->setCustomerId($customer['id'])
            ->setCustomerEmail($customer['email'])
            ->setCustomerFirstname($customer['firstname'])
            ->setCustomerLastname($customer['lastname'])
            ->setCustomerGroupId($customer['group_id'])
            ->setCustomerIsGuest(0);

        /* @var $orderAddressRepository \Magento\Sales\Model\Order\AddressRepository */
        $orderAddress = $this->addressRepository->create();
        $orderAddress
            ->setDistrict(isset($address["district"]) ? $address["district"] : null)
            ->setSubDistrict(isset($address["sub_district"]) ? $address["sub_district"] : null)
            ->setStoreId(1)
            ->setAddressType(\Magento\Sales\Model\Order\Address::TYPE_BILLING)
            ->setCustomerId($customer['id'])
            ->setPrefix("")
            ->setFirstname($address["firstname"])
            ->setMiddlename("")
            ->setLastname($address["lastname"])
            ->setCompany("")
            ->setStreet($address["street"])
            ->setCity($address["city"])
            ->setPostcode($address["postcode"])
            ->setTelephone($address["telephone"])
            ->setFax("")
            ->setCountryId($address["country_id"])
            ->setRegionId($address["region_id"]);
        $orderAddress2 = $this->addressRepository->create();
        $orderAddress2
            ->setDistrict(isset($address["district"]) ? $address["district"] : null)
            ->setSubDistrict(isset($address["sub_district"]) ? $address["sub_district"] : null)
            ->setStoreId(1)
            ->setAddressType(\Magento\Sales\Model\Order\Address::TYPE_SHIPPING) // \Magento\Sales\Model\Order\Address::TYPE_BILLING and then \Magento\Sales\Model\Order\Address::TYPE_SHIPPING
            ->setCustomerId($customer['id'])
            ->setPrefix("")
            ->setFirstname($address["firstname"])
            ->setMiddlename("")
            ->setLastname($address["lastname"])
            ->setCompany("")
            ->setStreet($address["street"])
            ->setCity($address["city"])
            ->setPostcode($address["postcode"])
            ->setTelephone($address["telephone"])
            ->setFax("")
            ->setCountryId($address["country_id"])
            ->setRegionId($address["region_id"]);
        $order->setBillingAddress($orderAddress);
        $order->setShippingAddress($orderAddress2);
        // repeat for shipping address $order->setShippingAddress($orderAddress);
        $currentTimestamp = (new \DateTime())->getTimestamp();
        $order
            ->setShippingMethod($orderTmp["shipping_method"]["method_code"])
            ->setShippingDescription($orderTmp["shipping_method"]["method_title"]);
        $order->setCreatedAt(strtotime($currentTimestamp));

        // add order item
        /* @var $product \Magento\Catalog\Model\Product */
        /* @var $orderItemFactory \Magento\Sales\Model\Order\ItemFactory */
        $totalQty = 0;
        foreach ($orderTmp["items"] as $item) {
            $orderItem = $this->itemFactory->create();
            $totalQty += $item["qty"];
            if (empty($item["weight"])) {
                $item["weight"] = 0;
            }
            $orderItem
                ->setStoreId(1)
                ->setQuoteItemId(0)
                ->setQuoteParentItemId(NULL)
                ->setProductId($item["id"])
                ->setProductType($item["type_id"])
                ->setQtyBackordered(NULL)
                ->setName($item["name"])
                ->setSku($item["sku"])
                ->setTotalQtyOrdered($item["qty"])
                ->setQtyOrdered($item["qty"])
                ->setPrice($item["price"])
                ->setBasePrice($item["totals"]["base_price"])
                ->setOriginalPrice($item["original_price"])
                ->setBaseOriginalPrice($item["original_price"])
                ->setTaxAmount($item["totals"]["tax_amount"])
                ->setBaseTaxAmount($item["totals"]["base_tax_amount"])
                ->setTaxPercent($item["totals"]["tax_percent"])
                ->setDiscountAmount($item["totals"]["discount_amount"])
                ->setBaseDiscountAmount($item["totals"]["base_discount_amount"])
                ->setRowTotal($item["totals"]["row_total"])
                ->setBaseRowTotal($item["totals"]["base_row_total"])
                ->setWeight($item["weight"])
                ->setIsVirtual(0);
            $order->addItem($orderItem);
        }

        // repeat for each order item

        // set status
        $order->setStatus(($payment = 'p2c2ppayment') ? 'Pending_2C2P' : \Magento\Sales\Model\Order::STATE_PROCESSING); // depends on your needs
        $order->setState(($payment = 'p2c2ppayment') ? 'Pending_2C2P' : \Magento\Sales\Model\Order::STATE_NEW);

        // set totals
        $order->setBaseGrandTotal($orderTmp["total"]["grand_total"]);
        $order->setGrandTotal($orderTmp["total"]["grand_total"]);
        $order->setBaseSubtotal($orderTmp["total"]["sub_total"]);
        $order->setSubtotal($orderTmp["total"]["sub_total"]);


        ////////////////////miss-data///////////////////
        $order->setBaseTaxAmount(0);
        $order->setTaxAmount(0);
        $order->setBaseDiscountAmount($orderTmp["total"]["discount_amount"]);
        $order->setDiscountAmount($orderTmp["total"]["discount_amount"]);
        $order->setBaseSubtotalInclTax($orderTmp["total"]["sub_total"]);
        $order->setSubtotalInclTax($orderTmp["total"]["sub_total"]);
        $order->setTotalItemCount(count($orderTmp["items"]));
        $order->setTotalQtyOrdered($totalQty);

        // set shipping amounts -- shiping method
        $order->setShippingAmount($orderTmp["shipping_method"]["amount"]);
        $order->setBaseShippingAmount($orderTmp["shipping_method"]["base_amount"]);
        $order->setShippingTaxAmount(0);
        $order->setBaseShippingTaxAmount(0);
        $order->setShippingInclTax(0);
        $order->setBaseShippingInclTax(0);

        // set total paid if needed
        $order->setTotalPaid($orderTmp["total"]["sub_total"]);
        $order->setBaseTotalPaid($orderTmp["total"]["sub_total"]);
        return $order->save();
    }

    /**
     * @inheritdoc
     */
    public function placeOrder($orders, $payment, $address, $customer)
    {
        $connection = $this->resourceConnection->getConnection();
        foreach ($orders as $order) {
            $orderSave = $this->saveOrder($order, $payment["code"], $address, $customer);
            $id = $orderSave->getId();
            $orderIncrement = $orderSave->getIncrementId();

            //get field "time_to_receive" add custom to extension
            $time_to_receive = $order["time_to_receive"];
            //save field
            $data           = ["time_to_receive" => $time_to_receive];
            $where          = ['entity_id = ?' => (int)$id];
            $tableName123   = $connection->getTableName('sales_order');
            $updatedRows    = $connection->update($tableName123, $data, $where);
            $vendorOrderItems = [];
            $shippingBill = $orderSave->getBillingAddress();

            /*Group order item by  vendor*/
            foreach ($orderSave->getAllItems() as $item) {
                $vendorId = $item->getProduct()->getVendorId();
                if (!$vendorId) {
                    break;
                }
                $productSku = $item->getProduct()->getSku();
                $id_customer = $orderSave->getCustomerId();
                $productID = $item->getProduct()->getId();

                $store = $this->storeManager->getStore($orderSave->getStoreId());
                $websiteId = $this->storeManager->getStore($orderSave->getStoreId())->getWebsiteId();
                $customer123 = $this->customerFactory->create();
                $customer123->setWebsiteId($websiteId);
                $customer123->load($id_customer);


                // save info order(product, customer,...) to quote
                $quote = $this->quote->create(); // Create Quote Object
                $quote->setStore($store); // Set Store
                $customer123 = $this->customerRepository->getById($customer123->getEntityId());
                $quote->setCurrency();
                $quote->assignCustomer($customer123); // Assign quote to Customer

                $product = $this->productCatalog->load($productID);
                $price = $item->getProduct()->getPrice();
                $qty = $item->getQtyOrdered();
                $product->setPrice($price);
                $quote->addProduct($product, intval($qty));

                // Set Sales Order Payment
                $paymentGet = $orderSave->getPayment()->getMethod();
                $quote->getPayment()->addData(['method' => $paymentGet]);

                //set vendor id for order 
                $transport = new \Magento\Framework\DataObject(['vendor_id' => $vendorId, 'item' => $item]);
                $this->_eventManager->dispatch('ves_vendors_checkout_init_vendor_id', ['transport' => $transport]);
                $vendorId = $transport->getVendorId();
                $item->setVendorId($vendorId);

                //prepare data for insert vendor order item
                $vendor = $this->_vendorFactory->create()->load($vendorId);
                if ($vendorId && $vendor->getId()) {
                    if (!isset($vendorOrderItems[$vendorId])) {
                        $vendorOrderItems[$vendorId] = [];
                    }
                    $vendorOrderItems[$vendorId][] = $item;
                }
            }

            //$vendorId 

            $groupName = $this->dataHelper->getGroupName($vendorId);
            switch ($groupName) {
                case  'Mall':
                    $orderIncrement .= '1';
                    break;
                case  'Recommend Store':
                    $orderIncrement .= '2';
                    break;
                case  'Normal Store':
                    $orderIncrement .= '3';
                    break;
                case  'International Store':
                    $orderIncrement .= '4';
                    break;
                default:
                    $orderIncrement .= '0';
                    break;
            }
            $dateNow = date("ymd");
            $orderIncrement = $dateNow . $orderIncrement;
            $orderSave->setIncrementId($orderIncrement);
            $orderSave->save();


            if (!$vendorId || $vendorId == 0) {
                $result[] = $orderSave;
                break;
            }
            if (isset($shippingBill)) {
                $quote->getBillingAddress()->addData($shippingBill->getData());
            }

            // Collect Totals & Save Quote
            $quote->collectTotals()->save();

            //update vendor_id and quote_id of table quote_item
            $OrderId = $orderSave->getEntityId();
            $quote_id = $quote->getEntityId();

            $tableQuoteItem = $connection->getTableName('quote_item');
            $table = $connection->getTableName('sales_order_item');
            $query = "SELECT item_id FROM `" . $tableQuoteItem . "` WHERE quote_id = $quote_id ";
            $resultQuoteItem = $connection->fetchAll($query);

            $id_item = $item->getId();
            if (isset($resultQuoteItem) && count($resultQuoteItem) > 0) {

                $quote_item_id = $resultQuoteItem[0]['item_id'];
                $query = "UPDATE `" . $table . "` SET `vendor_id`= $vendorId  WHERE item_id = $id_item ";
                $connection->query($query);
                $query = "UPDATE `" . $table . "` SET  `quote_item_id` = $quote_item_id  WHERE item_id = $id_item ";
                $connection->query($query);
            }


            $currentTimestamp = (new \DateTime())->getTimestamp();
            foreach ($vendorOrderItems as $vendorId => $items) {
                $vendorOrder = $this->_vendorOrderFactory->create();
                $orderData = [
                    'vendor_id' => $vendorId,
                    'order_id'  => $orderSave->getId(),
                    'state'    => Order::STATE_NEW,
                    'discount_mkp'=> $order['total']['discount_mkp'],
                    'discount_seller'=> $order['total']['discount_seller'],
                    'status'    => $this->statusResolver->getOrderStatusByState($orderSave, Order::STATE_NEW),
                    'subtotal'  => 0,
                    'weight'    => 0,
                    'grand_total'   => 0,
                    'created_at'    => $currentTimestamp,
                    'updated_at'    => $currentTimestamp,
                    'tax_amount'    => 0,
                    'base_subtotal'     => 0,
                    'base_tax_amount'   => 0,
                    'discount_amount'   => 0,
                    'shipping_amount'   => 0,
                    'shipping_incl_tax' => 0,
                    'subtotal_incl_tax' => 0,
                    'base_subtotal_incl_tax' => 0,
                    'shipping_method'   => '',
                    'base_discount_amount'  => 0,
                    'base_grand_total'      => 0,
                    'base_shipping_amount'  => 0,
                    'shipping_tax_amount'   => 0,
                    'base_shipping_tax_amount'  => 0,
                    'base_shipping_incl_tax'    => 0,
                    'total_due' => 0,
                    'base_total_due' => 0,
                ];
                $count = 0;
                foreach ($items as $item) {
                    //Skipping parent items to avoid double calculations
                    if ($item->getParentItemId()) {
                        continue;
                    }
                    if ($item->getHasChildren() && $item->isChildrenCalculated()) {
                        foreach ($item->getChildrenItems() as $child) {
                            $orderData['subtotal'] += $child->getData('row_total');
                            $orderData['base_subtotal'] += $child->getData('base_row_total');
                            $orderData['weight'] += $child->getData('row_weight');
                            $orderData['tax_amount'] += $child->getData('tax_amount');
                            $orderData['base_tax_amount'] += $child->getData('base_tax_amount');
                            $orderData['discount_amount'] += $child->getData('discount_amount');
                            $orderData['base_discount_amount'] += $child->getData('base_discount_amount');
                            $orderData['subtotal_incl_tax'] += $child->getData('row_total_incl_tax');
                            $orderData['base_subtotal_incl_tax'] += $child->getData('base_row_total_incl_tax');
                            $count += $child->getQtyOrdered();
                        }
                    } elseif (!$item->getHasChildren() || !$item->isChildrenCalculated()) {
                        $orderData['subtotal'] += $item->getData('row_total');
                        $orderData['base_subtotal'] += $item->getData('base_row_total');
                        $orderData['weight'] += $item->getData('row_weight');
                        $orderData['tax_amount'] += $item->getData('tax_amount');
                        $orderData['base_tax_amount'] += $item->getData('base_tax_amount');
                        $orderData['discount_amount'] += $item->getData('discount_amount');
                        $orderData['base_discount_amount'] += $item->getData('base_discount_amount');
                        $orderData['subtotal_incl_tax'] += $item->getData('row_total_incl_tax');
                        $orderData['base_subtotal_incl_tax'] += $item->getData('base_row_total_incl_tax');
                        $count += $item->getQtyOrdered();
                    }
                    $options = $item->getProduct()->getTypeInstance(true)->getOrderOptions($item->getProduct());
                }

                $orderDataObj = new \Magento\Framework\DataObject($orderData);

                $orderData = $orderDataObj->getData();
                $orderData['total_qty_ordered'] = $count;

                if ($this->_moduleManage->isEnabled("Wiki_VendorsTax")) {
                    $orderData['grand_total'] = $orderData['subtotal_incl_tax'] +
                        $orderData['shipping_incl_tax'] -
                        $orderData['discount_amount'];

                    $orderData['base_grand_total'] = $orderData['base_subtotal_incl_tax'] +
                        $orderData['base_shipping_incl_tax'] -
                        $orderData['base_discount_amount'];
                } else {
                    $orderData['grand_total'] = $orderData['subtotal'] +
                        $orderData['shipping_amount'] +
                        $orderData['tax_amount'] -
                        $orderData['discount_amount'];

                    $orderData['base_grand_total'] = $orderData['base_subtotal'] +
                        $orderData['base_shipping_amount'] +
                        $orderData['base_tax_amount'] -
                        $orderData['base_discount_amount'];
                }

                $orderDataAfterObj = new \Magento\Framework\DataObject($orderData);

                $orderData = $orderDataAfterObj->getData();
                $orderData['total_due'] = $orderData['grand_total'];
                $orderData['base_total_due'] = $orderData['base_grand_total'];

                $vendorOrder->setData($orderData)->setItems($items)->save();

                /**get customer_id by order_id form sales_order table */
                $post = $this->_salesVendorsFactory->create();
                $collection = $post->getCollection();
                $id_order = $orderSave->getId();

                //set wk_status = pending
                $updateWkStatus = $this->updateStatusOrder($id_order, "normal_confirmed");

                $customer_sale = $collection->addFieldToFilter('entity_id', $id_order)->addFieldToSelect('customer_id')->getColumnValues('customer_id');

                $this->_eventManager->dispatch(
                    'Wiki_vendors_push_notification',
                    [
                        'vendor_id' => $vendorId,
                        'type' => 'sales',
                        'message' => 'Order successfully: #' . '<strong>' . $orderIncrement . '</strong>',
                        'additional_info' => ['id' => $vendorOrder->getId()],
                        'customer_id' =>  $customer_sale[0],
                    ]
                );
                $this->_eventManager->dispatch(
                    'Wiki_vendors_push_notification',
                    [
                        'vendor_id' => $vendorId,
                        'type' => 'sales',
                        'message' => __('New order #%1 is placed', '<strong>' . $orderIncrement . '</strong>'),
                        'additional_info' => ['id' => $vendorOrder->getId()],

                    ]
                );
            }

            $result[] = $orderSave;
        }
        return $result;
    }

    public function applyCoupon($productsByShop, $customerId, $mkpCoupon)
    {
        return $this->applyCoupon->applyCoupon($productsByShop, $customerId, $mkpCoupon);
    }
    /**
     * @inheritdoc
     */
    public function updateStatusOrder($order_id, $status)
    {
        $orderById = $this->orderFactoryMagento->create();
        $orderById->load($order_id);
        if (empty($orderById->getId()))
            return false;
        $orderById->setWkStatus($status);
        $orderById->save();

        $vendor = $this->vendorResourceOrder->create()
            ->addFieldToFilter('order_id', $orderById->getId())
            ->getFirstItem();
        $vendorId = $vendor->getVendorId();
        if ($vendorId) {
            if ($status == 'canceled') {
                /** apply minus */
                $this->_eventManager->dispatch(
                    'wiki_penalties_failed_order',
                    [
                        'vendor_id' => $vendorId
                    ]
                );
            } else if ($status == 'preparing') {
                //check time delivery
                $this->_eventManager->dispatch(
                    'wiki_penalties_delivery_deplayed',
                    [
                        'vendor_id' => $vendorId,
                        'order_id' => $order_id
                    ]
                );
            }
        }


        //end event

        return true;
    }

    public function checkCoupon($products, $vendor_id, $coupon, $customer_id)
    {
        return $this->applyCoupon->checkCoupon($products, $vendor_id, $coupon, $customer_id);
    }

    public function requestReturnOrder($return_request)
    {
        $collection = $this->requestReturn->create()->getCollection();
        $collection->addFieldToFilter('order_id', $return_request->getOrderId());
        $collection->addFieldToFilter('status_of_seller', array('eq' => 0));
        if (count($collection) > 0) {
            return false;
        }

        $path =  $this->dataHelper->checkCreateFolderURL('orders/');
        $pictureBase = [];
        try {
            foreach ($return_request->getPicture() as $pic) {
                $base64 = base64_decode($pic);
                $type = explode('/', finfo_buffer(finfo_open(), $base64, FILEINFO_MIME_TYPE))[1];
                $imageUrl =  strtotime("now") . "-" . uniqid() . '.' . $type;
                file_put_contents($path . $imageUrl, $base64);
                $pictureBase[] = $imageUrl;
            }

            $jsonPicture =  json_encode($pictureBase);
            $jsonItems = json_encode($return_request->getItems());
            $return_request->setItems($jsonItems);
            $return_request->setPicture($jsonPicture);
            $return_request->save();

            //$this->updateStatusOrder($return_request->getOrderId(), "pending_return");

            /** send message */
            $vendor = $this->dataHelper->getVendorByIdOrder($return_request->getOrderId());
            $customer = $this->dataHelper->getCustomerByIdOrder($return_request->getOrderId());
            if (!empty($vendor->getId()) && !empty($customer->getId())) {
                $message = [
                    'vendor_id' => $vendor->getVendorId(),
                    'customer_id' => $customer->getId(),
                    'body' => [
                        'message' => $return_request->getReason(),
                        'image' => $return_request->getPicture()
                    ],
                    'sender_type' => 'B',
                    'from_system' => 1
                ];
                $messageChatInterface = $this->dataHelper->arrayToChatInterface($message);
                $this->chatManagementInterface->createConversation($messageChatInterface);
            }
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

    public function createNotificationRequest($orderId, $content)
    {

        $order          = $this->orderRepository->get($orderId);
        $incrementId    = '<strong>#' . $order->getIncrementId() . '</strong>';
        $message        = sprintf("Request Cancellation Order: %s.", $incrementId);

        $this->helperData->insertNotification($order, $message, $content);

        /** update status = pending_cancel from user */
        // $status = 'pending_cancel';
        // $this->updateStatusOrder($orderId, $status);

        /** send message */
        try {
            $vendor = $this->dataHelper->getVendorByIdOrder($orderId);
            $customer = $this->dataHelper->getCustomerByIdOrder($orderId);
            if (!empty($vendor->getId()) && !empty($customer->getId())) {
                $message = [
                    'vendor_id' => $vendor->getVendorId(),
                    'customer_id' => $customer->getId(),
                    'body' => [
                        'message' => $content,
                        'image' => []
                    ],
                    'sender_type' => 'B',
                    'from_system' => 1
                ];
                $messageChatInterface = $this->dataHelper->arrayToChatInterface($message);
                $this->chatManagementInterface->createConversation($messageChatInterface);
            }
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

    public function createNotificationConfirm($orderId, $content, $accept)
    {
        $order          = $this->orderRepository->get($orderId);
        $incrementId    = '<strong>#' . $order->getIncrementId() . '</strong>';


        if ($accept) {
            if (!$this->cancel($orderId)) {
                return false;
            }
            $status = 'canceled';
            $message        = sprintf("Confirm Request Cancel Order: %s.", $incrementId);
            $this->helperData->insertNotification($order, $message, $content);
        } 
        return true;
    }

    public function createNotificationConfirmReturn($orderId, $content, $accept)
    {
        $collection = $this->requestReturn->create()->getCollection();
        $collection->addFieldToFilter('order_id', $orderId);
        $collection->addFieldToFilter('status_of_seller', array('in' => array(0, 2)));
        if (count($collection) == 0) {
            return false;
        }

        $order = $this->orderRepository->get($orderId);
        $incrementId = '<strong>#' . $order->getIncrementId() . '</strong>';

        if ($accept) {
            $message = sprintf("Confirm Request Return in Order: %s.", $incrementId);
            $status = 'processing_return';
            $statusConfirm = 1;
        }
        $this->helperData->insertNotification($order, $message, $content);
        // $collection->getLastItem()->setContentOfSeller($content)->setStatusOfSeller($statusConfirm)->save();

        // return $this->updateStatusOrder($orderId, $status);

        return true;
    }

    public function confirmTimeExpand($orderId, $accept)
    {
        try {
            $order = $this->orderRepository->get($orderId);
            $order->setTimeExpand($accept)->save();
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

    public function cancel($id)
    {
        $order = $this->orderRepository->get($id);
        if ($order->canCancel()) {
            $order->cancel();
            $this->orderRepository->save($order);
            return true;
        }

        return false;
    }

    public function updateIncrement()
    {
        /* test crontab change increment every month */
        $connection = $this->resourceConnection->getConnection();
        $tblSalesSequenceProfile = $connection->getTableName('sales_sequence_profile');
        //set prefix of increment id
        $time = date("ymd");
        $query = "UPDATE `" . $tblSalesSequenceProfile . "` SET `prefix`= NULL WHERE meta_id = 5 ";
        $connection->query($query);
        // set auto increment
        /*
	   $tblSequenceOrder1 = $connection->getTableName('sequence_order_1');
	   $query = "DELETE FROM `" . $tblSequenceOrder1 . "`";
	   $connection->query($query);
	   $query = "ALTER TABLE `" . $tblSequenceOrder1 . "` AUTO_INCREMENT=1";
	   $connection->query($query);
       */
        /** end crontab */
        return true;
    }

    public function getOrderByIncrementId($incrementId)
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $collection = $objectManager->create('Magento\Sales\Model\Order');
        $orderInfo = $collection->loadByIncrementId($incrementId);
        if (empty($orderInfo->getId())) return;
        $order     =  $this->orderMagento->get($orderInfo->getId());
        return $order;
    }
}
