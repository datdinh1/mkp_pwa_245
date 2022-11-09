<?php
/* File: app/code/Atwix/OrderFeedback/Plugin/OrderRepositoryPlugin.php */

namespace Wiki\VendorsSales\Plugin;

use Magento\Sales\Api\Data\OrderExtensionFactory;
use Magento\Sales\Api\Data\OrderExtensionInterface;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\Data\OrderSearchResultInterface;
use Magento\Sales\Api\OrderRepositoryInterface;
use Wiki\VendorsProduct\Model\Api\Data\SellerDataFactory;
use Wiki\Vendors\Model\VendorFactory;
use Wiki\Vendors\Model\GroupFactory;
use Wiki\VendorsConfig\Helper\Data as WikiVendorData;
use Wiki\VendorsSales\Model\ResourceModel\RequestReturnOrder\CollectionFactory;
use Wiki\VendorsNotification\Model\ResourceModel\Notification\CollectionFactory as Notificaition;
use Wiki\VendorsSales\Api\SalesManagementInterface;
use Magento\Catalog\Model\ProductRepository;

/**
 * Class OrderRepositoryPlugin
 */
class OrderRepositoryPlugin
{
    protected $productRepository;
    protected $salesManagementInterface;
    protected $notificationCollection;
    protected $requetReturn;
    protected $vendor;
    protected $configHelper;
    protected $groupVendor;
    protected $sellerDataFactory;


    /**
     * Order feedback field name
     */
    const FIELD_NAME = 'time_to_receive';
    const WK_STATUS = 'wk_status';
    /**
     * Order Extension Attributes Factory
     *
     * @var OrderExtensionFactory
     */
    protected $extensionFactory;
    /**
     * OrderRepositoryPlugin constructor
     *
     * @param OrderExtensionFactory $extensionFactory
     */
    public function __construct(
        ProductRepository $productRepository,
        SalesManagementInterface    $salesManagementInterface,
        Notificaition     $notificationCollection,
        CollectionFactory $requestReturn,
        OrderExtensionFactory $extensionFactory,
        SellerDataFactory $sellerDataFactory,
        VendorFactory                   $vendor,
        WikiVendorData                  $configHelper,
        GroupFactory                    $groupVendor
    ) {
        $this->productRepository        = $productRepository;
        $this->salesManagementInterface = $salesManagementInterface;
        $this->notificationCollection   = $notificationCollection;
        $this->requestReturn            = $requestReturn;
        $this->extensionFactory         = $extensionFactory;
        $this->vendor                   = $vendor;
        $this->sellerDataFactory        = $sellerDataFactory;
        $this->configHelper             = $configHelper;
        $this->groupVendor              = $groupVendor;
    }

    public function afterSave(OrderRepositoryInterface $orderRepo, OrderInterface $order)
    {
        //Insert into database

        $statusMagento = $order->getStatus();
        if ($statusMagento == "Pending") {
            $status = 'normal_confirmed';
            $this->salesManagementInterface->updateStatusOrder($order->getId(), $status);
        }

        return $order;
    }
    /**
     * Add "customer_feedback" extension attribute to order data object to make it accessible in API data
     *
     * @param OrderRepositoryInterface $subject
     * @param OrderInterface $order
     *
     * @return OrderInterface
     */
    public function afterGet(OrderRepositoryInterface $subject, OrderInterface $order)
    {

        $customerFeedback = $order->getData(self::FIELD_NAME);
        $getWkStatus = $order->getData(self::WK_STATUS);
        $extensionAttributes = $order->getExtensionAttributes();
        $extensionAttributes = $extensionAttributes ? $extensionAttributes : $this->extensionFactory->create();
        $extensionAttributes->setTimeToReceive($customerFeedback);
        $extensionAttributes->setWkStatus($getWkStatus);

        $deliverydate = date('Y-m-d H:i:s', strtotime('+2 day', strtotime($order->getCreatedAt())));
        $extensionAttributes->setWkDeliveryDate($deliverydate);


        $extensionAttributes->setTimeExpand($order->getTimeExpand());
        $dataRequestReturn = $this->requestReturn->create()
            ->addFieldToFilter('order_id', $order->getId());

        if (!empty($dataRequestReturn->getData())) {
            foreach ($dataRequestReturn as $requestReturn) {
                $decodeItems = json_decode($requestReturn->getItems(), true);
                $requestReturn->setItems($decodeItems);
                $decodePicture = json_decode($requestReturn->getPicture(), true);
                $requestReturn->setPicture($decodePicture);
                $items[] = $requestReturn;
            }
            if (isset($items) && !empty($items)) {
                $extensionAttributes->setReturnRequest($items);
            }
        }

        $seller = $this->seller($order);
        if ($seller !== false) {
            $extensionAttributes->setVendor($seller);
            $vendorId = $seller->getId();
        }
        /** wk_staus = pending_cancel display field request_cancel */
        $notificationColection = $this->notificationCollection->create();
        $requestCancel =  $notificationColection->addFieldToFilter('type', 'sales')
            ->addFieldToFilter('message',  array('like' => '%Request%'));
        if (!empty($vendorId))  $requestCancel = $requestCancel->addFieldToFilter('vendor_id', $vendorId);
        $wk_status = $order->getWkStatus();
        if ($wk_status == "cancel_pending") {
            foreach ($requestCancel as $item) {
                $addInfo = unserialize($item->getAdditionalInfo());
                if ($addInfo['id'] ==  $order->getId()) {
                    $content = $item->getContent();
                    $extensionAttributes->setRequestCancel($content);
                    break;
                }
            }
        }

        // $item = $order->getItems()[14];
        // foreach ($order->getItems() as $item) {
        //     $sku = $item->getSku();

        //     $product = $this->productRepository->get($sku);
        //     $attributes = $product->getExtensionAttributes();
        //     $isAuctions = $attributes->getIsAuctions();
        //     if ($isAuctions) {
        //         $extensionAttributes->setOrderAuctions(true);
        //         break;
        //     }
        // }
        $order->setExtensionAttributes($extensionAttributes);
        return $order;
    }
    /**
     * Add "customer_feedback" extension attribute to order data object to make it accessible in Magento API data
     *
     * @param OrderRepositoryInterface $subject
     * @param OrderSearchResultInterface $searchResult
     *
     * @return OrderSearchResultInterface
     */
    public function afterGetList(OrderRepositoryInterface $subject, OrderSearchResultInterface $searchResult)
    {
        $orders = $searchResult->getItems();
        foreach ($orders as &$order) {

            $customerFeedback = $order->getData(self::FIELD_NAME);
            $getWkStatus = $order->getData(self::WK_STATUS);
            $extensionAttributes = $order->getExtensionAttributes();
            $extensionAttributes = $extensionAttributes ? $extensionAttributes : $this->extensionFactory->create();
            $extensionAttributes->setTimeToReceive($customerFeedback);
            $extensionAttributes->setWkStatus($getWkStatus);
            $seller = $this->seller($order);
            if ($seller !== false) {
                $extensionAttributes->setVendor($seller);
            }

            $order->setExtensionAttributes($extensionAttributes);
        }
        return $searchResult;
    }

    /**
     * @param Magento\Catalog\Model\Product\Interceptor
     * @return int
     */
    protected function seller($order)
    {
        $orderItems = $order->getAllItems();

        $vendorId = 0;
        foreach ($orderItems as $item) {
            $vendorId = $item->getVendorId();
            if ($vendorId != 0) {
                break;
            }
        }

        $info = $this->sellerDataFactory->create();

        if ($vendorId == 0) return false;

        $logoSeller = $this->getLogoSeller($vendorId);
        $storeName = $this->getStoreNameSeller($vendorId);
        $vendor = $this->vendor->create()->load($vendorId);
        $groupId = empty($vendor->getData()) ? 0 : $vendor->getGroupId();
        $groupName = $this->groupVendor->create()->load($groupId)->getVendorGroupCode();
        $info->setData(empty($vendor->getData()) ? null : $vendor->getData());
        $info->setGroupName($groupName);
        $info->setLogo($logoSeller);
        $info->setStoreName($storeName);
        return $info;
    }

    protected function getLogoSeller($vendorId)
    {
        $basePath = 'ves_vendors/logo/';
        $img = $this->configHelper->getVendorConfig('general/store_information/logo', $vendorId);
        return empty($img) ? null : $basePath . $img;
    }

    public function getStoreNameSeller($vendorId)
    {
        $storeName = $this->configHelper->getVendorConfig('general/store_information/name', $vendorId);
        return empty($storeName) ? null : $storeName;
    }
}
