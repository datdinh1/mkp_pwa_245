<?php

namespace Wiki\VendorsReport\Controller\Adminhtml\Report;

use Wiki\VendorsSales\Model\OrderFactory;
use Wiki\Vendors\Model\Vendor;
use Wiki\VendorsReport\Model\NewReportFactory;
use Magento\Sales\Model\OrderFactory as MagentoOrderFactory;
use Magento\Framework\App\ResourceConnection;

class Index extends \Magento\Backend\App\Action
{
    protected $resultPageFactory = false;

    protected $resourceConnection;

    /**
     * @var MagentoOrderFactory
     */
    protected $magentoOrderFactory;

    /**
     * @var NewReportFactory
     */
    protected $reportSales;

    /**
     * @var OrderFactory
     */
    protected $vendorOrders;

    /**
     * @var OrderRepository
     */
    protected $ordersMagento;

    /**
     * @var Vendor
     */
    protected $vendorModel;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        OrderFactory $vendorOrders,
        Vendor         $vendorModel,
        NewReportFactory $reportSales,
        MagentoOrderFactory $magentoOrderFactory,
        ResourceConnection $resourceConnection
    ) {
        parent::__construct($context);
        $this->resultPageFactory    = $resultPageFactory;
        $this->vendorOrders         = $vendorOrders;
        $this->vendorModel          = $vendorModel;
        $this->reportSales          = $reportSales;
        $this->magentoOrderFactory  = $magentoOrderFactory;
        $this->resourceConnection   = $resourceConnection;
    }

    protected function checkLastItemReport()
    {
        $reportSales =  $this->reportSales->create();
        $collection = $reportSales->getCollection();
        $lastItemReport = $collection->getLastItem();
        if (empty($lastItemReport->getIdOrder())) {
            /* reset auto increment id */
            $connection = $this->resourceConnection->getConnection();
            $table = $connection->getTableName('wiki_report_sales_seller');
            $query = "ALTER TABLE `" . $table . "`AUTO_INCREMENT = 1";
            $connection->query($query);
            return false;
        }

        $orders =  $this->magentoOrderFactory->create();
        $collectionSales = $orders->getCollection();
        $lastItem = $collectionSales->getLastItem();
        if ($lastItem->getIncrementId() == $lastItemReport->getIdOrder()) {
            return true;
        } else {
            /** delete all collection */
            $reportSalesDel =  $this->reportSales->create();
            $collectionDel = $reportSalesDel->getCollection();
            $collectionDel->walk('delete');

            /* reset auto increment id */
            $connection = $this->resourceConnection->getConnection();
            $table = $connection->getTableName('wiki_report_sales_seller');
            $query = "ALTER TABLE `" . $table . "`AUTO_INCREMENT = 1";
            $connection->query($query);
            return false;
        }
    }

    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend((__('Reports')));

        //return report orders
        $model = $this->vendorOrders->create();
        $collection = $model->getCollection();


        // $order = $objectManager->create('\Magento\Sales\Model\OrderRepository')->get($orderId);
        try {
            $check = $this->checkLastItemReport();
            //$check  = false;
            if (!$check) {
                foreach ($collection as $vendorOrders) {
                    $data = [];
                    $orderId = $vendorOrders->getOrderId();
                    $order = $this->magentoOrderFactory->create()->load($orderId);

                    $vendor = $this->vendorModel->load($vendorOrders->getVendorId());

                    $data['id_order'] = $order->getIncrementId();
                    $data['vendor_id'] = $vendor->getVendorId();
                    $data['order_date'] = $order->getCreatedAt();

                    if ($order->getWkStatus() == 'normal_received_payment') {
                        $data['date_success_payment'] = $order->getUpdatedAt();
                    }

                    $data['total_price'] = $order->getSubtotal();
                    $data['discount_seller'] = $vendorOrders->getDiscountSeller();
                    $data['discount_mkp'] = $vendorOrders->getDiscountMkp();
                    $data['delivery_price'] = $order->getShippingAmount();
                    $data['total_amount'] = $order->getGrandTotal();

                    $commission = 0;
                    //get amount commission

                    foreach ($order->getInvoiceCollection() as $invoice) {
                        foreach ($invoice->getItems() as $item) {
                            $commission += $item->getCommission();
                        }
                    }
                    $commission = abs($commission);
                    $data['commission_fees'] = $commission;

                    $result[] = $data;
                    $reportSales =  $this->reportSales->create();
                    $reportSales->setData($data)->save();
                }
            }
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }

        return $resultPage;
    }
}
