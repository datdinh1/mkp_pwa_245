<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\VendorsNotification\Observer;

use Magento\Framework\Event\ObserverInterface;
use Wiki\VendorsNotification\Helper\Data;

class NotificationOrderCancel implements ObserverInterface
{

    /**
	 * @var Data
	 */
    protected $helperData;

    public function __construct(
        Data                $helperData
    ) {
        $this->helperData   = $helperData;
    }

    /**
     * Add notification when order status Cancel.
     * @param \Magento\Framework\Event\Observer $observer
     * @return self
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $order = $observer->getOrder();
        if ( $order instanceof \Magento\Framework\Model\AbstractModel ){
            if ( $order->getState() == 'canceled' || $order->getState() == 'closed' ){
                $incrementId    = '<strong>'. $order->getIncrementId() . '</strong>';
                $message        = __("Order #%1 has been cancelled.", $incrementId);
                $this->helperData->insertNotification($order, $message);
            }
        }
        return $this;
    }
}