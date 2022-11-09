<?php

namespace Wiki\VendorsSales\Observer;

use Magento\Framework\Event\ObserverInterface;
use Wiki\VendorsConfig\Helper\Data;
use Magento\Sales\Model\Order;
use Magento\Framework\Exception\StateException;

class ProcessOrderStatus implements ObserverInterface
{
    /**
     * @var \Wiki\VendorsSales\Model\ResourceModel\Order\CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var \Wiki\VendorsSales\Model\OrderFactory
     */
    protected $_orderFactory;

    /**
     * @var \Wiki\VendorsNotification\Model\ResourceModel\NotificationFactory
     */
    protected $_notiFactory;

    /**
     * @var \Wiki\VendorsSales\Model\ResourceModel\Order\Handler\State
     */
    protected $stateHandler;

    /**
     * @var Order\SalesVendorsFactory
     */
    protected $_salesVendorsFactory;
    protected $_eventManager;
    /**
     * ProcessOrderStatus constructor.
     * @param \Wiki\VendorsSales\Model\ResourceModel\Order\CollectionFactory $collectionFactory
     * @param \Wiki\VendorsSales\Model\ResourceModel\Order\Handler\State $stateHandler
     */
    public function __construct(
        \Wiki\VendorsSales\Model\ResourceModel\Order\CollectionFactory $collectionFactory,
        \Wiki\VendorsSales\Model\ResourceModel\Order\Handler\State $stateHandler,
        \Wiki\VendorsSales\Model\OrderFactory $oderfactory,
        \Wiki\VendorsNotification\Model\NotificationFactory $notificationFactory,
        \Magento\Framework\Event\ManagerInterface $eventManager,
        \Wiki\VendorsSales\Model\SalesVendorsFactory $salesVendorsFactory
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->stateHandler = $stateHandler;
        $this->_orderFactory = $oderfactory;
        $this->_notiFactory = $notificationFactory;
        $this->_eventManager = $eventManager;
        $this->_salesVendorsFactory = $salesVendorsFactory;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $order = $observer->getOrder();
        
        $vendorOrderCollection = $this->collectionFactory->create()->addFieldToFilter('order_id', $order->getId());
        foreach($vendorOrderCollection as $vendorOrder){
            $this->stateHandler->check($vendorOrder);
            $vendorOrder->save();
        }
      
        
    }
}
