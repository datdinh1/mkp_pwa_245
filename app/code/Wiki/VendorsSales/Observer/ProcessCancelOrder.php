<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\VendorsSales\Observer;

use Magento\Framework\Event\ObserverInterface;
use Wiki\VendorsConfig\Helper\Data;
use Wiki\VendorsSales\Model\Order\Email\Sender\OrderSender;

class ProcessCancelOrder implements ObserverInterface
{
    /**
     * @var \Wiki\VendorsSales\Model\OrderFactory
     */
    protected $_vendorOrderFactory;


    /**
     * @var \Wiki\VendorsConfig\Helper\Data
     */
    protected $_vendorConfig;

    /**
     * @var OrderSender
     */
    protected $_orderSender;

    /**
     * @var \Magento\Framework\Event\ManagerInterface
     */
    protected $_eventManager;

    /**
     * @var \Wiki\Vendors\Helper\Data
     */
    protected $_vendorHelper;

    public function __construct(
        \Wiki\VendorsSales\Model\OrderFactory $vendorOrderFactory,
        \Magento\Framework\Event\ManagerInterface $eventManager,
        \Wiki\VendorsSales\Model\Order\Email\Sender\OrderSender $orderSender,
        \Wiki\Vendors\Helper\Data $vendorHelper,
        Data $vendorConfig
    ) {
        $this->_vendorOrderFactory = $vendorOrderFactory;
        $this->_eventManager = $eventManager;
        $this->_vendorConfig = $vendorConfig;
        $this->_vendorHelper = $vendorHelper;
        $this->_orderSender = $orderSender;
    }

    /**
     * Add multiple vendor order row for each vendor.
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return self
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        /* Do nothing if the extension is not enabled.*/
        if (!$this->_vendorHelper->moduleEnabled()) {
            return;
        }

        $order = $observer->getOrder();

        $vendorOrders = $this->_vendorOrderFactory->create()->getCollection()->addFieldToFilter("order_id", $order->getId());
        foreach ($vendorOrders as $vendorOrder) {
            $vendorOrder->cancel();
        }

        return $this;
    }
}
