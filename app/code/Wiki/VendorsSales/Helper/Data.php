<?php

/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Wiki\VendorsSales\Helper;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Io\File;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Store\Model\ScopeInterface;
use Wiki\VendorsChat\Model\Api\BodyContentFactory;
use Wiki\VendorsChat\Model\Api\ChatFactory;
use Wiki\Vendors\Model\GroupFactory;
use Wiki\Vendors\Model\Vendor;
use Wiki\Vendors\Model\VendorFactory;

class Data extends \Magento\Shipping\Helper\Data
{
    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var File
     */
    private $io;

    /**
     * @var Filesystem
     */
    private $filesystem;

    protected $vendor;
    protected $groupVendor;

    protected $chatFactory;
    protected $bodyContentFactory;
    protected $orderRepository;
    protected $_customerRepositoryInterface;
    /**
     * @param File $io
     * @param Filesystem $filesystem
     * @param CustomerRepositoryInterface $customerRepository
     */
    public function __construct(
        ScopeConfigInterface        $scopeConfig,
        CustomerRepositoryInterface $customerRepositoryInterface,
        Vendor $vendorsModel,
        OrderRepositoryInterface $orderRepository,
        ChatFactory $bodyContentFactory,
        ChatFactory $chatFactory,
        File $io,
        Filesystem $filesystem,
        VendorFactory $vendor,
        GroupFactory $groupVendor

    ) {
        $this->scopeConfig                  = $scopeConfig;
        $this->_customerRepositoryInterface = $customerRepositoryInterface;
        $this->_vendorsModel                = $vendorsModel;
        $this->orderRepository              = $orderRepository;
        $this->bodyContentFactory           = $bodyContentFactory;
        $this->chatFactory                  = $chatFactory;
        $this->io                           = $io;
        $this->filesystem                   = $filesystem;
        $this->vendor                       = $vendor;
        $this->groupVendor                  = $groupVendor;
    }

    /**
     * Allowed hash keys
     *
     * @var array
     */
    protected $_allowedHashKeys = ['vendor_order_id', 'ship_id', 'order_id', 'track_id'];

    /**
     * Retrieve tracking url with params
     *
     * @param  string $key
     * @param  \Wiki\VendorsSales\Model\Order|\Magento\Sales\Model\Order|\Magento\Sales\Model\Order\Shipment|\Magento\Sales\Model\Order\Shipment\Track $model
     * @param  string $method Optional - method of a model to get id
     * @return string
     */
    protected function _getTrackingUrl($key, $model, $method = 'getId')
    {

        if ($model instanceof \Wiki\VendorsSales\Model\Order) {
            $protectCode = $model->getOrder()->getProtectCode();
        } else {
            $protectCode = $model->getProtectCode();
        }

        $urlPart = "{$key}:{$model->{$method}()}:{$protectCode}";

        $params = [
            '_direct' => 'shipping/tracking/popup',
            '_query' => ['hash' => $this->urlEncoder->encode($urlPart)],
        ];

        $storeModel = $this->_storeManager->getStore($model->getStoreId());
        return $storeModel->getUrl('', $params);
    }

    /**
     * Shipping tracking popup URL getter
     *
     * @param \Magento\Sales\Model\AbstractModel $model
     * @return string
     */
    public function getTrackingPopupUrlBySalesModel($model)
    {
        if ($model instanceof \Wiki\VendorsSales\Model\Order) {
            return $this->_getTrackingUrl('vendor_order_id', $model);
        } elseif ($model instanceof \Magento\Sales\Model\Order) {
            return $this->_getTrackingUrl('order_id', $model);
        } elseif ($model instanceof \Magento\Sales\Model\Order\Shipment) {
            return $this->_getTrackingUrl('ship_id', $model);
        } elseif ($model instanceof \Magento\Sales\Model\Order\Shipment\Track) {
            return $this->_getTrackingUrl('track_id', $model, 'getEntityId');
        }
        return '';
    }

    /**
     * get split cart by vendor
     *
     * @return Ambigous <mixed, string, NULL, multitype:, multitype:Ambigous <string, multitype:, NULL> >
     */
    public function isSplitCartByVendor()
    {
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_WEBSITE;
        // $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        return $this->scopeConfig->getValue('vendors/sales/split_cart', $storeScope);
    }

    public function checkCreateFolderURL($url)
    {
        $mediaPath = $this->filesystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath();
        $uploadPath = $mediaPath . $url;
        if (!is_dir($uploadPath)) {
            $this->io->mkdir($uploadPath, 0777);
        }
        return $uploadPath;
    }

    public function getCustomStatus()
    {
        return [
            'pending' => ['value' => 'pending', 'label' => __('Pending')],
            'canceled' => ['value' => 'canceled', 'label' => __('Canceled')],
            'completed' => ['value' => 'completed', 'label' => __('Completed')],
            'delivered' => ['value' => 'delivered', 'label' => __('Delivered')],
            'preparing' => ['value' => 'preparing', 'label' => __('Preparing')],
            'delivering' => ['value' => 'delivering', 'label' => __('Delivering')],
            'pending_cancel' => ['value' => 'pending_cancel', 'label' => __('Pending Cancel')],
            'pending_return' => ['value' => 'pending_return', 'label' => __('Pending Return')],
            'received_return' => ['value' => 'received_return', 'label' => __('Received Return')],
            'received_payment' => ['value' => 'received_payment', 'label' => __('Received Payment')],
            'processing_return' => ['value' => 'processing_return', 'label' => __('Processing Return')],
        ];
    }

    public function getStatusByCode($code)
    {
        $fraud = ['value' => 'fraud', 'label' => __('Suspected Fraud')];
        $status = $this->getCustomStatus();
        return (isset($status[$code])) ? $status[$code] : $fraud;
    }

    public function getGroupName($id)
    {
        $vendor = $this->vendor->create()->load($id);
        if (empty($vendor->getData())) {
            return null;
        }

        $groupId = empty($vendor->getData()) ? 0 : $vendor->getGroupId();
        $groupName = $this->groupVendor->create()->load($groupId)->getVendorGroupCode();
        return $groupName;
    }

    public function arrayToChatInterface($message)
    {
        $chatInteface = $this->chatFactory->create();
        $bodyChatInterface = $this->bodyContentFactory->create();

        $bodyChatInterface->setData($message['body']);
        $chatInteface->setData($message);
        $chatInteface->setBody($bodyChatInterface);
        return $chatInteface;
    }

    public function getVendorByIdOrder($id)
    {
        $order = $this->orderRepository->get($id);
        $orderItems = $order->getAllItems();
        $vendorId = 0;
        if (empty($order)) {
            return null;
        }

        foreach ($orderItems as $item) {
            $id = $item->getVendorId();
            $vendor = $this->_vendorsModel->load($id);
            if ($id != 0) {
                break;
            }
        }
        if (empty($vendor)) {
            return null;
        }

        return $vendor;
    }

    public function getCustomerByIdOrder($id)
    {
        $order = $this->orderRepository->get($id);
        $customerId = $order->getCustomerId();
        $customer = $this->_customerRepositoryInterface->getById($customerId);

        if (empty($order)) {
            return null;
        }

        if (empty($customer)) {
            return null;
        }

        return $customer;
    }
}
