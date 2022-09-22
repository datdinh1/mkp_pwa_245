<?php

namespace Wiki\VendorsReport\Model\Api;

use Magento\Catalog\Model\ProductRepository;
use Magento\Customer\Model\Customer;
use Magento\Customer\Model\CustomerFactory;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\App\Response\Http\FileFactory;
use Magento\Framework\File\Csv;
use Magento\Reports\Model\EventFactory;
use Magento\Sales\Model\OrderRepository;
use Wiki\VendorsReport\Api\ReportRepositoryInterface;
use Wiki\VendorsReport\Helper\Data;
use Wiki\VendorsReport\Model\Api\Data\ReportStoreDataFactory;
use Wiki\VendorsReport\Model\Api\Data\ReportStoreFactory;
use Wiki\VendorsReport\Model\NewReportFactory;
use Wiki\VendorsReport\Model\Report\Sales;
use Wiki\VendorsSales\Model\OrderFactory;
use Wiki\Vendors\Model\Vendor;

/**
 * Class ReportRepositoryInterface
 * @package Wiki\VendorsReport\Model\Api
 */
class ReportRepository implements ReportRepositoryInterface
{
    /**
     * @var ReportStoreFactory
     */
    protected $reportStoreFactory;
    /**
     * @var ReportStoreDataFactory
     */
    protected $reportStoreDataFactory;

    /**
     * @var Data
     */
    protected $helperData;
    /**
     * @var \Magento\Framework\App\Response\Http\FileFactory
     */
    protected $fileFactory;

    /**
     * @var Csv
     */
    protected $csvProcessor;

    /**
     * @var DirectoryList
     */
    protected $directoryList;

    /**
     * Magento\Customer\Model\Customer
     * @var Customer
     */
    protected $customer;

    /**
     * Magento\Customer\Model\CustomerFactory
     * @var CustomerFactory
     */
    protected $customerFactory;

    /**
     * Wiki\Vendors\Model\Vendor
     * @var Vendor
     */
    protected $vendor;

    /**
     * Wiki\VendorsSales\Model\OrderFactory
     * @var OrderFactory
     */
    protected $orderFactory;

    /**
     * Magento\Framework\App\ResourceConnection
     * @var ResourceConnection
     */
    protected $resourceConnection;

    /**
     * Magento\Catalog\Model\ProductRepository
     * @var ProductRepository
     */
    protected $productRepository;

    /**
     * Magento\Reports\Model\EventFactory
     * @var ProductRepository
     */
    protected $eventFactory;

    /**
     * Wiki\VendorsReport\Model\Report\Sales
     * @var Sales
     */
    protected $sales;

    /**
     * @var OrderRepository
     */
    protected $ordersMagento;

    /**
     * @var NewReportFactory
     */
    protected $reportSales;

    /**
     * @param \Magento\Framework\App\Action\Context            $context
     * @param \Magento\Framework\App\Response\Http\FileFactory $fileFactory
     * @param \Magento\Catalog\Model\ProductFactory            $productFactory
     * @param \Magento\Framework\View\Result\LayoutFactory     $resultLayoutFactory
     * @param \Magento\Framework\File\Csv                      $csvProcessor
     * @param \Magento\Framework\App\Filesystem\DirectoryList  $directoryList
     */
    public function __construct(

        ReportStoreFactory $reportStoreFactory,
        ReportStoreDataFactory $reportStoreDataFactory,
        Data $helperData,
        NewReportFactory $reportSales,
        OrderRepository $ordersMagento,
        Customer $customer,
        CustomerFactory $customerFactory,
        Vendor $vendor,
        OrderFactory $orderFactory,
        ResourceConnection $resourceConnection,
        ProductRepository $productRepository,
        EventFactory $eventFactory,
        Sales $sales,
        DirectoryList $directoryList,
        Csv $csvProcessor,
        FileFactory $fileFactory
    ) {

        $this->reportStoreFactory = $reportStoreFactory;
        $this->reportStoreDataFactory = $reportStoreDataFactory;
        $this->helperData = $helperData;
        $this->reportSales = $reportSales;
        $this->ordersMagento = $ordersMagento;
        $this->customer = $customer;
        $this->customerFactory = $customerFactory;
        $this->vendor = $vendor;
        $this->orderFactory = $orderFactory;
        $this->resourceConnection = $resourceConnection;
        $this->productRepository = $productRepository;
        $this->eventFactory = $eventFactory;
        $this->sales = $sales;
        $this->directoryList = $directoryList;
        $this->csvProcessor = $csvProcessor;
        $this->fileFactory = $fileFactory;
    }

    /**
     * @inheritdoc
     */
    //  Request data
    //  {
    //     "namestore": "SELLER16",
    //     "from": "2021-02-01",
    //     "to": "2021-03-01",
    //  }
    public function getOrder($namestore, $from, $to)
    {
        try {
            $vendor = $this->vendor->loadByIdentifier($namestore);
            $id = $vendor->getId();
            $customer = $this->customer->setWebsiteId(1)->loadByEmail($vendor->getEmail());
            $customerVendor = $this->vendor->loadByCustomer($customer);
            if (count($customerVendor->getData()) == 0) {
                return "This is not account Seller";
            } else {
                $modOrder = $this->orderFactory->create();
                $colOrderbyVendor = $modOrder->getCollection()->addFieldToFilter('vendor_id', $id)->getData();
                $connection = $this->resourceConnection->getConnection('\Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION');
                $listOrderbyVendor = $connection->fetchAll("SELECT * FROM `ves_vendor_sales_order` WHERE vendor_id = $id and created_at >= '$from' and created_at < '$to'");
            }
        } catch (AuthenticationException $e) {
            return "Invalid login or password.";
        }
        return $listOrderbyVendor;
    }

    /**
     * @inheritdoc
     */
    //  Request data
    //  {
    //     "namestore": "SELLER16",
    //     "from": "2021-02-01",
    //     "to": "2021-03-01",
    //  }
    public function getNewCustomer($namestore, $from, $to)
    {
        $listOrderbyVendor = $this->getOrder($namestore, $from, $to);
        $orderId = [];
        foreach ($listOrderbyVendor as $order) {
            $orderId[] = $order['order_id'];
        }
        $orderId = implode(',', $orderId);
        $connection = $this->resourceConnection->getConnection('\Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION');
        $listCustomerId = $connection->fetchAll("SELECT DISTINCT(customer_id) FROM `sales_order` WHERE entity_id in ($orderId)");
        $customers = [];
        $customersCollection = $this->customer->getCollection();
        $customersCollection->addAttributeToSelect("*");
        $customersCollection->getSelect()->where('created_at >= "' . $from . '"');
        $customersCollection->getSelect()->where('created_at < "' . $to . '"');
        foreach ($listCustomerId as $customerId) {
            $customersCollection->getSelect()->where('entity_id = ' . $customerId['customer_id']);
            $customers[] = $customersCollection->getData();
        }
        return $customers;
    }

    /**
     * @inheritdoc
     */
    //  Request data
    //  {
    //     "namestore": "SELLER16",
    //  }
    public function getProductRatingsByQty($namestore)
    {
        $listProduct = [];
        try {
            $vendor = $this->vendor->loadByIdentifier($namestore);
            $id = $vendor->getId();
            $customer = $this->customer->setWebsiteId(1)->loadByEmail($vendor->getEmail());
            $customerVendor = $this->vendor->loadByCustomer($customer);
            if (count($customerVendor->getData()) == 0) {
                return "This is not account Seller";
            } else {
                $connection = $this->resourceConnection->getConnection();
                $listProductId = $connection->fetchAll("SELECT SUM(qty_ordered) as qty_ordered, product_id FROM `sales_order_item` WHERE vendor_id = $id GROUP BY product_id ORDER BY SUM(qty_ordered) DESC");
                foreach ($listProductId as $productId) {
                    $product = $this->productRepository->getById($productId['product_id'])->getData();
                    $product['qty_ordered'] = $productId['qty_ordered'];
                    $listProduct[] = $product;
                }
            }
        } catch (AuthenticationException $e) {
            return "Invalid login or password.";
        }
        return $listProduct;
    }

    /**
     * @inheritdoc
     */
    //  Request data
    //  {
    //     "namestore": "SELLER16",
    //  }
    public function getProductRatingsByOrder($namestore)
    {
        $listProduct = [];
        try {
            $vendor = $this->vendor->loadByIdentifier($namestore);
            $id = $vendor->getId();
            $customer = $this->customer->setWebsiteId(1)->loadByEmail($vendor->getEmail());
            $customerVendor = $this->vendor->loadByCustomer($customer);
            if (count($customerVendor->getData()) == 0) {
                return "This is not account Seller";
            } else {
                $connection = $this->resourceConnection->getConnection();
                $listProductId = $connection->fetchAll("SELECT COUNT(item_id) as count_order, product_id FROM `sales_order_item` WHERE vendor_id = $id GROUP BY product_id ORDER BY COUNT(item_id) DESC");
                foreach ($listProductId as $productId) {
                    $product = $this->productRepository->getById($productId['product_id'])->getData();
                    $product['count_order'] = $productId['count_order'];
                    $listProduct[] = $product;
                }
            }
        } catch (AuthenticationException $e) {
            return "Invalid login or password.";
        }
        return $listProduct;
    }

    /**
     * @inheritdoc
     */
    //  Request data
    //  {
    //     "productId": "4043",
    //  }
    public function getProductCountViews($productId)
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $productObj = $objectManager->create('Magento\Catalog\Model\Product')->load($productId);
        $productcollection = $objectManager->create('\Magento\Reports\Model\ResourceModel\Product\Collection');
        $productcollection->setProductAttributeSetId($productObj->getAttributeSetId());
        $prodData = $productcollection->addViewsCount()->getData();

        if (count($prodData) > 0) {
            foreach ($prodData as $product) {
                if ($product['entity_id'] == $productId) {
                    return (int) $product['views'];
                }
            }
        }

        return 0;
    }

    /**
     * @inheritdoc
     */
    //  Request data
    //  {
    //     "productId": "4043",
    //     "customerId": "3",
    //     "storeId": "1",
    //  }
    public function setProductViews($productId, $customerId, $storeId)
    {
        if ($customerId === 0) {
            $subtype = 1;
        } else {
            $subtype = 0;
        }

        $eventModel = $this->eventFactory->create();
        $eventModel->setData([
            'event_type_id' => 1,
            'object_id' => $productId,
            'subject_id' => $customerId,
            'subtype' => $subtype,
            'store_id' => $storeId,
        ]);

        return $eventModel->save();
    }

    /**
     * @inheritdoc
     */
    //  Request data
    //  {
    //     "from": "2021-02-01",
    //     "to": "2021-03-01",
    //     "period": "day",
    //     "namestore": "SELLER16",
    //  }
    public function getDataOrderReport($from, $to, $period, $namestore)
    {
        try {
            $vendor = $this->vendor->loadByIdentifier($namestore);
            $id = $vendor->getId();
            $customer = $this->customer->setWebsiteId(1)->loadByEmail($vendor->getEmail());
            $customerVendor = $this->vendor->loadByCustomer($customer);
            if (count($customerVendor->getData()) == 0) {
                return "This is not account Seller";
            } else {
                return $this->sales->getOrderTotalsDataForGraph($from, $to, $period, $id);
            }
        } catch (AuthenticationException $e) {
            return "Invalid login or password.";
        }
    }

    /**
     * @inheritdoc
     */
    //  Request data
    //  {
    //     "from": "2021-12-01",
    //     "to": "2021-12-20",
    //     "status": "",
    //     "namestore": "SELLER16",
    //  }
    public function exportSalesSeller($namestore, $from = null, $to = null, $status = null)
    {
        try {
            $vendor = $this->vendor->loadByIdentifier($namestore);
            $id = $vendor->getId();
            $customer = $this->customer->setWebsiteId(1)->loadByEmail($vendor->getEmail());
            $customerVendor = $this->vendor->loadByCustomer($customer);
            if (count($customerVendor->getData()) == 0) {
                throw new \Magento\Framework\Webapi\Exception(__("This is not account Seller"), 400);
            } else {
                $modelSalesSeller = $this->orderFactory->create();
                $collectionSalesSeller = $modelSalesSeller->getCollection()->addFieldToFilter('vendor_id', $id)
                    ->addFieldToFilter('created_at', ['gteq' => $from])
                    ->addFieldToFilter('updated_at', ['lteq' => $to]);

                /** Add yout header name here */
                $content[] = [
                    'id_order' => __('Order ID'),
                    'vendor_id' => __('Seller ID'),
                    'order_date' => __('Order date'),
                    'date_success_payment' => __('Date Success Payment'),
                    'total_price' => __('Total Price'),
                    'discount_seller' => __('Discount Seller'),
                    'discount_mkp' => __('Discount MKP'),
                    'delivery_price' => __('Delivery Price'),
                    'total_amount' => __('Total Amount'),
                    'commission_fees' => __('Commission Fees'),
                ];

                $fileName = 'reports_sales.csv'; // Customize CSV File name
                $filePath = $this->directoryList->getPath(DirectoryList::MEDIA) . "/" . $fileName;

                $flag = false;
                foreach ($collectionSalesSeller as $vendorOrders) {

                    $data = [];
                    $orderId = $vendorOrders->getOrderId();
                    $order = $this->ordersMagento->get($orderId);
                    if ($status && $status != $order->getWkStatus()) {
                        continue;
                    }

                    $flag = true;
                    $data['date_success_payment'] = null;
                    if ($order->getWkStatus() == 'normal_received_payment') {
                        $data['date_success_payment'] = $order->getUpdatedAt();
                    }

                    $commission = 0;
                    //get amount commission
                    foreach ($order->getInvoiceCollection() as $invoice) {
                        foreach ($invoice->getItems() as $item) {
                            $commission += $item->getCommission();
                        }
                    }
                    $commission = abs($commission);

                    $content[] = [
                        $order->getIncrementId(),
                        $vendor->getVendorId(),
                        $order->getCreatedAt(),
                        $data['date_success_payment'],
                        $order->getSubtotal(),
                        $order->getDiscountSeller(),
                        $order->getDiscountMkp(),
                        $order->getShippingAmount(),
                        $order->getGrandTotal(),
                        $commission,
                    ];
                }
                if ($flag) {
                    $this->csvProcessor->setEnclosure('"')->setDelimiter(',')->saveData($filePath, $content);
                    return $this->fileFactory->create(
                        $fileName,
                        [
                            'type' => "filename",
                            'value' => $fileName,
                            'rm' => true, // True => File will be remove from directory after download.
                        ],
                        DirectoryList::MEDIA,
                        'text/csv',
                        null
                    );
                } else {
                    return false;
                }

            }
        } catch (\Exception $e) {
            throw new \Magento\Framework\Webapi\Exception(__($e->getMessage()), 400);
        }
    }

    /** @inheritdoc */
    public function reportStore($vendorId, $date, $limit = null)
    {
        $listOrders = $this->helperData->getSalesByVendor($vendorId, $date, $limit, 'orders');
        $listSales = $this->helperData->getSalesByVendor($vendorId, $date, $limit, 'sales');
        $totalBuyers = $this->helperData->getSalesByVendor($vendorId, $date, $limit, 'total_buyers');
        $newBuyers = $this->helperData->getSalesByVendor($vendorId, $date, $limit, 'new_buyers');
        $report = $this->reportStoreFactory->create();
        if ($listOrders) {
            $report->setOrders($this->renderStoreReportData($listOrders));
        }

        if ($listSales) {
            $report->setSales($this->renderStoreReportData($listSales));
        }

        if ($totalBuyers) {
            $report->setTotalBuyers($this->renderStoreReportData($totalBuyers));
        }

        if ($newBuyers) {
            $report->setNewBuyers($this->renderStoreReportData($newBuyers));
        }

        return $report;
    }

    public function renderStoreReportData($list)
    {
        $orders = [];
        foreach ($list as $month => $order) {
            $storeData = $this->reportStoreDataFactory->create();
            $storeData->setDate($month)->setTotal($order['total']);
            $orders[] = $storeData;
        }
        return $orders;
    }

    /** @inheritdoc */
    public function exportSellerOverView($vendorId, $from = null, $to = null)
    {
        try {
            $vendor = $this->vendor->loadByIdentifier($vendorId);
            $id = $vendor->getId();
            $customer = $this->customer->setWebsiteId(1)->loadByEmail($vendor->getEmail());
            $customerVendor = $this->vendor->loadByCustomer($customer);
            if (count($customerVendor->getData()) == 0) {
                throw new \Magento\Framework\Webapi\Exception(__("This is not account Seller"), 400);
            } else {

                $content = $this->helperData->getDataExportStore($id, $from, $to);

                $fileName = 'reports-store-' . date('d-m-Y') . "-" . strtotime("now") . "-" . uniqid() . '.csv'; // Customize CSV File name
                $filePath = $this->directoryList->getPath(DirectoryList::MEDIA) . "/" . $fileName;

                $this->csvProcessor->setEnclosure('"')->setDelimiter(',')->saveData($filePath, $content);
                return $this->fileFactory->create(
                    $fileName,
                    [
                        'type' => "filename",
                        'value' => $fileName,
                        'rm' => true, // True => File will be remove from directory after download.
                    ],
                    DirectoryList::MEDIA,
                    'text/csv',
                    null
                );
            }
        } catch (\Exception $e) {
            throw new \Magento\Framework\Webapi\Exception(__($e->getMessage()), 400);
        }
    }

    /** @inheritdoc */
    public function reportStoreProduct($vendorId, $date, $limit = null)
    {
        return true;
    }
}
