<?php

namespace Wiki\VendorsNotification\Model\Api;

use Magento\Sales\Api\OrderRepositoryInterface;
use Wiki\VendorsNotification\Api\NotificationRepositoryInterface;
use Wiki\VendorsNotification\Model\NotificationFactory;
use Wiki\VendorsNotification\Model\Notification;
use Wiki\VendorsNotification\Helper\Data;
use Wiki\VendorsSales\Api\SalesManagementInterface;

class NotificationRepository implements NotificationRepositoryInterface
{


    /**
     * @var Data
     */
    protected $helperData;

    /**
     * @var NotificationFactory
     */
    protected $notificationFactory;

    /**
     * @var OrderRepositoryInterface
     */
    protected $orderRepository;

    public function __construct(
        SalesManagementInterface    $salesManagementInterface,
        Data                        $helperData,
        NotificationFactory         $notificationFactory,
        OrderRepositoryInterface    $orderRepository
    ) {
        $this->salesManagementInterface           = $salesManagementInterface;
        $this->helperData           = $helperData;
        $this->notificationFactory  = $notificationFactory;
        $this->orderRepository      = $orderRepository;
    }

    public function getNotificationById($id)
    {
        $notification = $this->notificationFactory->create()->load($id);
        if (empty($notification->getData()))
            return false;
        if ($notification->getIsRead() == 0)
            $notification->setIsRead(1)->save();
        return $notification;
    }

    public function getNotificationByCustomerId($customerId)
    {
        return $this->helperData->getNotification('customer_id', $customerId, Notification::NOTIFYCATION_CUSTOMER);
    }

    public function getNotificationByVendorId($vendorId)
    {
        return $this->helperData->getNotification('vendor_id', $vendorId, Notification::NOTIFYCATION_VENDOR);
    }

    public function createNotificationRequest($orderId, $content)
    {
        $order          = $this->orderRepository->get($orderId);
        $incrementId    = '<strong>#' . $order->getIncrementId() . '</strong>';
        $message        = sprintf("Request Cancellation Order: %s.", $incrementId);
        if ($this->helperData->checkNotification($message))
            return false;

        $this->helperData->insertNotification($order, $message, $content);
        /** update status = pending_cancel from user */
        $status = 'pending_cancel';
        return $this->salesManagementInterface->updateStatusOrder($orderId, $status);
    }

    public function createNotificationConfirm($orderId, $content, $accept)
    {
        $order          = $this->orderRepository->get($orderId);
        $incrementId    = '<strong>#' . $order->getIncrementId() . '</strong>';
        $message        = sprintf("Confirm Request Cancel Order: %s.", $incrementId);
        if ($this->helperData->checkNotification($message))
            return false;

        $this->helperData->insertNotification($order, $message, $content);

        $status = 'pending';
        if ($accept) {
            $status = 'canceled';
        } 
        return $this->salesManagementInterface->updateStatusOrder($orderId, $status);
    }

    public function createNotificationDeny($orderId, $content)
    {
        $order          = $this->orderRepository->get($orderId);
        $incrementId    = '<strong>#' . $order->getIncrementId() . '</strong>';
        $message        = sprintf("Deny Request Cancel Order: %s.", $incrementId);
        if ($this->helperData->checkNotification($message))
            return false;

        $this->helperData->insertNotification($order, $message, $content);
        return true;
    }
}
