<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\VendorsSales\Block\Adminhtml\Shipment\Packaging;

class Grid extends \Magento\Backend\Block\Template
{
    /**
     * @var string
     */
    protected $_template = 'order/shipment/packaging/grid.phtml';

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;

    /**
     * @var \Magento\Sales\Model\Order\Shipment\ItemFactory
     */
    protected $_shipmentItemFactory;

    /**
     * @var \Wiki\VendorsSales\Model\OrderFactory
     */
    protected $vendorOrder;
    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Sales\Model\Order\Shipment\ItemFactory $shipmentItemFactory
     * @param \Magento\Framework\Registry $registry
     * @param \Wiki\VendorsSales\Model\OrderFactory $order
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Sales\Model\Order\Shipment\ItemFactory $shipmentItemFactory,
        \Magento\Framework\Registry $registry,
        \Wiki\VendorsSales\Model\OrderFactory $order,
        array $data = []
    ) {
        $this->vendorOrder = $order;
        $this->_shipmentItemFactory = $shipmentItemFactory;
        $this->_coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    /**
     * Return collection of shipment items
     *
     * @return array
     */
    public function getCollection()
    {
        if ($this->getShipment()->getId()) {
            $collection = $this->_shipmentItemFactory->create()->getCollection()->setShipmentFilter(
                $this->getShipment()->getId()
            );
        } else {
            $collection = $this->getShipment()->getAllItems();
        }
        return $collection;
    }

    /**
     * Retrieve shipment model instance
     *
     * @return \Magento\Sales\Model\Order\Shipment
     */
    public function getShipment()
    {
        return $this->_coreRegistry->registry('current_shipment');
    }

    /**
     * Can display customs value
     *
     * @return bool
     */
    public function displayCustomsValue()
    {
        $storeId = $this->getShipment()->getStoreId();
        $order = $this->getShipment()->getOrder();
        $address = $order->getShippingAddress();

        $vendorOrder =  $this->vendorOrder->create()->load($this->getShipment()->getVendorOrderId());
        $vendor = $vendorOrder->getVendor();

        $shipperAddressCountryCode = $vendor->getCountryId();

        $recipientAddressCountryCode = $address->getCountryId();
        if ($shipperAddressCountryCode != $recipientAddressCountryCode) {
            return true;
        }
        return false;
    }

    /**
     * Format price
     *
     * @param   float $value
     * @return  string
     */
    public function formatPrice($value)
    {
        return sprintf('%.2F', $value);
    }
}