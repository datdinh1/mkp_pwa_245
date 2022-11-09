<?php
/**
 *
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\VendorsSales\Controller\Adminhtml\Sales\Shipment;

use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;

class GetShippingItemsGrid extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Magento_Sales::shipment';

    /**
     * @var \Wiki\VendorsSales\Controller\Adminhtml\Sales\Shipment\ShipmentLoader
     */
    protected $shipmentLoader;

    /**
     * @param Action\Context $context
     * @param \Wiki\VendorsSales\Controller\Adminhtml\Sales\Shipment\ShipmentLoader $shipmentLoader
     */
    public function __construct(
        Action\Context $context,
        \Wiki\VendorsSales\Controller\Adminhtml\Sales\Shipment\ShipmentLoader $shipmentLoader
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
        $vendorOrder = $this->_objectManager->create('Wiki\VendorsSales\Model\Order')->load(
            $this->getRequest()->getParam('vorder_id')
        );

        $this->shipmentLoader->setOrderId($vendorOrder->getOrderId());
        $this->shipmentLoader->setShipmentId($this->getRequest()->getParam('shipment_id'));
        $this->shipmentLoader->setShipment($this->getRequest()->getParam('shipment'));
        $this->shipmentLoader->setTracking($this->getRequest()->getParam('tracking'));
        $this->shipmentLoader->setVendorOrder($vendorOrder);

        $shipment = $this->shipmentLoader->load();
        return $this->getResponse()->setBody(
            $this->_view->getLayout()->createBlock(
                'Wiki\VendorsSales\Block\Adminhtml\Shipment\Packaging\Grid'
            )->setIndex(
                $this->getRequest()->getParam('index')
            )->toHtml()
        );
    }
}
