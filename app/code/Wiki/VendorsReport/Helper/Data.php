<?php

/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Wiki\VendorsReport\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Sales\Model\OrderFactory as MgtOrderFactory;
use Wiki\VendorsSales\Model\OrderFactory;
use Wiki\Vendors\Model\SellerManagement;
use Wiki\Vendors\Model\Vendor;

class Data extends AbstractHelper
{
    const XML_PROCESS_ORDERS = 'vendors/reports/process_order';
    const XML_ORDER_DATE_FILTER_FIELD = 'vendors/reports/order_datefilter_field';

    /**
     * @var MgtOrderFactory
     */
    protected $mgtOrderFactory;

    /**
     * @var OrderFactory
     */
    protected $orderFactory;

    /**
     * @var SellerManagement
     */
    protected $sellerManagement;

    public function __construct(
        SellerManagement $sellerManagement,
        OrderFactory $orderFactory,
        Vendor $vendorsModel,
        MgtOrderFactory $mgtOrderFactory
    ) {
        $this->mgtOrderFactory = $mgtOrderFactory;
        $this->orderFactory = $orderFactory;
        $this->sellerManagement = $sellerManagement;
        $this->_vendorsModel = $vendorsModel;
    }

    /**
     * Get Process Orders Status
     * @return array:
     */
    public function getProcessOrders()
    {
        $processOrders = $this->scopeConfig->getValue(self::XML_PROCESS_ORDERS);

        return explode(",", $processOrders);
    }

    /**
     * Get Date filter field
     *
     * @return string
     */
    public function getDateFilterField()
    {
        return $this->scopeConfig->getValue(self::XML_ORDER_DATE_FILTER_FIELD);
    }

    public function returnSales(&$sales, $id, $year, $month, $type)
    {
        $totalSum = 0;
        $vesOrder = $this->orderFactory->create();
        $vesOrderCollection = $vesOrder->getCollection()->addFieldToFilter('vendor_id', $id)
            ->addFieldToFilter('created_at', array('like' => "$year-$month-%"))
            ->addFieldToSelect('order_id')->getColumnValues('order_id');
        if (count($vesOrderCollection) == 0) {
            $sales[$year . '-' . $month]['total'] = 0;
        } else {
            $mgtOrder = $this->mgtOrderFactory->create();
            /** collection sales */
            $salesCollection = $mgtOrder->getCollection()->addFieldToFilter('entity_id', $vesOrderCollection)
                ->addFieldToSelect('grand_total')
                ->getColumnValues('grand_total');
            $totalSum = array_sum($salesCollection);

            if ($type == 'orders') {
                $sales[$year . '-' . $month]['total'] = count($vesOrderCollection);
            } else if ($type == 'sales') {
                $sales[$year . '-' . $month]['total'] = $totalSum;
            } else if ($type == 'total_buyers') {
                /** collection customer */
                $customerCollection = $mgtOrder->getCollection()->addFieldToFilter('entity_id', $vesOrderCollection)
                    ->addFieldToSelect('customer_id')->getColumnValues('customer_id');
                $listIdCustomer = array_unique($customerCollection); //remove dublicate element
                $sales[$year . '-' . $month]['total'] = count($listIdCustomer);
            } else if ($type == 'new_buyers') {
                $customerCollection = $mgtOrder->getCollection()->addFieldToFilter('entity_id', $vesOrderCollection)
                    ->addFieldToSelect('customer_id')->getColumnValues('customer_id');
                $listIdCustomer = array_unique($customerCollection); //remove dublicate element
                $count = $this->countBuyer($year . "-" . $month, $listIdCustomer, 'new_buyers', $id);
                $sales[$year . '-' . $month]['total'] = $count;
            }
        }
    }

    public function getSalesByVendor($vendorId, $date, $limit, $type)
    {
        $vendor = $this->_vendorsModel->loadByIdentifier($vendorId);
        $id = $vendor->getId();

        if (!$id) {
            throw new \Magento\Framework\Webapi\Exception(__("Vendor does not exist"), 400);
        }

        $sales = [];
        $date = trim($date);
        if (strlen($date) != 7) {
            throw new \Magento\Framework\Webapi\Exception(__("Invalid month's data"), 400);
        }

        if ($limit && $limit < 1 || $limit > 24) {
            throw new \Magento\Framework\Webapi\Exception(__("Invalid limit's data"), 400);
        }
        $number = $limit ? ($limit - 1) : 5;

        //$newdate = strtotime("-5 month", strtotime($date));
        $newdate = strtotime("-$number month", strtotime($date));
        $newdate = date('Y-m', $newdate);

        $dateArr = explode("-", $newdate); //03-2022:
        $yearNewDate = $dateArr[0]; // 2022
        $monthNewDate = $dateArr[1]; // 03

        do {
            $this->returnSales($sales, $id, $yearNewDate, $monthNewDate, $type);

            $dateIncre = strtotime('+1 month', strtotime($newdate));
            $dateIncre = date('Y-m', $dateIncre);

            $dateArr = explode("-", $dateIncre); //04-2022:
            $yearNewDate = $dateArr[0]; //2022
            $monthNewDate = $dateArr[1]; //04
            $newdate = $dateIncre;
        } while (strtotime($date) >= strtotime($dateIncre));

        return $sales;
    }
    public function getListBuyerVendor($vendorId, $from)
    {

        $lastDate = date("Y-m-t", strtotime(' -1 month', strtotime($from)));
        $dateIncre = strtotime('-12 month', strtotime($from));
        $dateIncre = date('Y-m-d H:i:s', $dateIncre);

        $vesOrder = $this->orderFactory->create();
        $vesOrderCollection = $vesOrder->getCollection()->addFieldToFilter('vendor_id', $vendorId)
        //->addFieldToFilter('created_at', array('like' => "$from-%"))
            ->addFieldToFilter('created_at', ['lteq' => $lastDate])
            ->addFieldToFilter('created_at', ['gteq' => $dateIncre])
            ->addFieldToSelect('order_id')->getColumnValues('order_id');

        if (count($vesOrderCollection) == 0) {
            return [];
        }

        $mgtOrder = $this->mgtOrderFactory->create();
        $customerCollection = $mgtOrder->getCollection()->addFieldToFilter('entity_id', $vesOrderCollection)
            ->addFieldToSelect('customer_id')->getColumnValues('customer_id');
        $listIdCustomer = array_unique($customerCollection); //remove dublicate element
        return $listIdCustomer;
    }

    public function countBuyer($from, $listBuyer, $type, $vendorId)
    {
        $total = 0;
        $listBuyerOfVendor = $this->getListBuyerVendor($vendorId, $from);
        if ($type == "new_buyers") {
            foreach ($listBuyer as $idCustomer) {

                if (!in_array($idCustomer, $listBuyerOfVendor)) {
                    $total++;
                }
            }
        }

        return $total;
    }

    public function returnExportStore(&$content, $from, $to, $id)
    {

        $vesOrder = $this->orderFactory->create();
        $vesOrderCollection = $vesOrder->getCollection()->addFieldToFilter('vendor_id', $id)
            ->addFieldToFilter('created_at', array('like' => $from . '%'))
            ->addFieldToSelect('order_id')->getColumnValues('order_id');
        if (count($vesOrderCollection) == 0) {
            $content[] = [$from, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
        } else {
            $mgtOrder = $this->mgtOrderFactory->create();
            /** collection sales */
            $salesCollection = $mgtOrder->getCollection()->addFieldToFilter('entity_id', $vesOrderCollection)
                ->addFieldToSelect('grand_total')->getColumnValues('grand_total');
            $totalSum = array_sum($salesCollection);
            $allOrder = count($vesOrderCollection);
            $average = $totalSum / $allOrder;
            $viewer = 0;
            $numberVisitor = 0;

            /** Number of buyers with paid orders divided / the total number of visitors during the selected period */
            $purchaseRate = 0;

            $collectionByStatusCancel = $mgtOrder->getCollection()->addFieldToFilter('entity_id', $vesOrderCollection)
                ->addFieldToFilter('wk_status', 'canceled')->addFieldToSelect('grand_total')->getColumnValues('grand_total');

            $cancelOrder = count($collectionByStatusCancel);
            $cancelSales = array_sum($collectionByStatusCancel);

            $collectionByStatusReturn = $mgtOrder->getCollection()->addFieldToFilter('entity_id', $vesOrderCollection)
                ->addFieldToFilter('wk_status', 'processing_return')->addFieldToSelect('grand_total')->getColumnValues('grand_total');

            $returnOrder = count($collectionByStatusReturn);
            $returnSales = array_sum($collectionByStatusReturn);

            $collectionByCustomer = $mgtOrder->getCollection()->addFieldToFilter('entity_id', $vesOrderCollection)
                ->addFieldToFilter('wk_status', 'completed')->addFieldToSelect('customer_id')->getColumnValues('customer_id');

            $uniqueListBuyer = array_unique($collectionByCustomer);
            $buyer = count($uniqueListBuyer); //remove dublicate element
            $newBuyer = $this->countBuyer($from, $uniqueListBuyer, 'new');
            $oldBuyer = $this->countBuyer($from, $uniqueListBuyer, 'old');
            $whoMayBuy = 0;
            $repurchaseRate = 0;
            // if ($type == 'orders') {
            //     $sales[$year . '-' . $month]['total'] = count($vesOrderCollection);
            // } else if ($type == 'sales') {
            //     $sales[$year . '-' . $month]['total'] = $totalSum;
            // } else if ($type == 'customer') {
            //     /** collection customer */
            //     $customerCollection     = $mgtOrder->getCollection()->addFieldToFilter('entity_id', $vesOrderCollection)
            //         ->addFieldToSelect('customer_id')->getColumnValues('customer_id');
            //     $totalSum = array_unique($customerCollection); //remove dublicate element
            //     $sales[$year . '-' . $month]['total'] = count($totalSum);
            // }
            $content[] = [
                $from,
                $totalSum,
                $allOrder,
                $average,
                $viewer,
                $numberVisitor,
                $purchaseRate,
                $cancelOrder,
                $cancelSales,
                $returnOrder,
                $returnSales,
                $buyer,
                $newBuyer,
                $oldBuyer,
                $whoMayBuy,
                $repurchaseRate,
            ];
        }
    }

    public function getDataExportStore($id, $from = null, $to = null)
    {
        /** Add yout header name here */
        $content[] = [
            'date' => __('Date'),
            'total_sales_amount' => __('Total Sales Amount'),
            'all_order' => __('All Order'),
            'average_sales_order' => __('Average Sales Order'),
            'viewer' => __('Viewer'),
            'number_of_visitors' => __('Number of visitors'),
            'purchase_rate' => __('Purchase Rate'),
            'cancel_order' => __('Cancel Order'),
            'cancel_sales' => __('Cancel Sales'),
            'refund_order' => __('Refund Order'),
            'refund_sales' => __('Refund Sales'),
            'buyer' => __('Buyer'),
            'new_buyer' => __('New Buyer'),
            'old_buyer' => __('Old Buyer'),
            'who_may_buy' => __('Who may buy'),
            'repurchase_rate' => __('Repurchase Rate'),
        ];
        $dateCurrent = date("Y-m-d");
        $dateFistMonth = date('Y-m-01');
        if (!$from && !$to) {
            $from = $dateFistMonth;
            $to = $dateCurrent;
        }
        do {
            // $this->returnExportStore($content, $from, $to, $id);

            // $dateIncre = strtotime('+1 days', strtotime($dateFistMonth));
            // $dateIncre = date('Y-m-d', $dateIncre);

            // $from= $dateFistMonth = $dateIncre;

            $this->returnExportStore($content, $from, $to, $id);

            $dateIncre = strtotime('+1 days', strtotime($from));
            $dateIncre = date('Y-m-d', $dateIncre);

            $from = $dateIncre;
        } while (strtotime($from) <= strtotime($to));

        return $content;
    }
}
