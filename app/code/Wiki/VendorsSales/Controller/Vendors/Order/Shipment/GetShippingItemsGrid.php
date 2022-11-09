<?php

namespace Wiki\VendorsSales\Controller\Vendors\Order\Shipment;

use Magento\Framework\App\ResponseInterface;

class GetShippingItemsGrid extends \Wiki\Vendors\App\AbstractAction
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    protected $_aclResource = 'Wiki_VendorsSales::sales_shipments';
    
    /**
     * @var \Magento\Shipping\Controller\Adminhtml\Order\ShipmentLoader
     */
    protected $shipmentLoader;

    /**
     * @param \Wiki\Vendors\App\Action\Context $context
     * @param \Wiki\VendorsSales\Controller\Vendors\Order\ShipmentLoader $shipmentLoader
     */
    public function __construct(
        \Wiki\Vendors\App\Action\Context  $context,
        \Wiki\VendorsSales\Controller\Vendors\Order\ShipmentLoader $shipmentLoader
    ) {
        $this->shipmentLoader = $shipmentLoader;
        parent::__construct($context);
    }

    /**
     * Return grid with shipping items for Ajax request
     *
     * @return ResponseInterface
     */
    public function execute()
    {
        $vendorOrder = $this->_objectManager->create('Wiki\VendorsSales\Model\Order')->load($this->getRequest()->getParam('order_id'));
        $this->shipmentLoader->setOrderId($vendorOrder->getOrderId());
        $this->shipmentLoader->setShipmentId($this->getRequest()->getParam('shipment_id'));
        $this->shipmentLoader->setShipment($this->getRequest()->getParam('shipment'));
        $this->shipmentLoader->setTracking($this->getRequest()->getParam('tracking'));
        $this->shipmentLoader->setVendorOrder($vendorOrder);
        $this->shipmentLoader->load();

        return $this->getResponse()->setBody(
            $this->_view->getLayout()->createBlock(
                'Magento\Shipping\Block\Adminhtml\Order\Packaging\Grid'
            )->setIndex(
                $this->getRequest()->getParam('index')
            )->toHtml()
        );
    }
}
