<?php

namespace Wiki\VendorsSales\Controller\Vendors\Order\Shipment;

class RemoveTrack extends \Wiki\Vendors\App\AbstractAction
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
     * @param \Magento\Shipping\Controller\Adminhtml\Order\ShipmentLoader $shipmentLoader
     */
    public function __construct(
        \Wiki\Vendors\App\Action\Context  $context,
        \Wiki\VendorsSales\Controller\Vendors\Order\ShipmentLoader $shipmentLoader
    ) {
        $this->shipmentLoader = $shipmentLoader;
        parent::__construct($context);
    }

    /**
     * Remove tracking number from shipment
     *
     * @return void
     */
    public function execute()
    {
        $trackId = $this->getRequest()->getParam('track_id');
        /** @var \Magento\Sales\Model\Order\Shipment\Track $track */
        $track = $this->_objectManager->create('Magento\Sales\Model\Order\Shipment\Track')->load($trackId);
        if ($track->getId()) {
            try {
                $vendorOrder = $this->_objectManager->create('Wiki\VendorsSales\Model\Order')->load($this->getRequest()->getParam('order_id'));
                $this->shipmentLoader->setOrderId($vendorOrder->getOrderId());
                $this->shipmentLoader->setShipmentId($this->getRequest()->getParam('shipment_id'));
                $this->shipmentLoader->setShipment($this->getRequest()->getParam('shipment'));
                $this->shipmentLoader->setTracking($this->getRequest()->getParam('tracking'));
                $this->shipmentLoader->setVendorOrder($vendorOrder);
                $shipment = $this->shipmentLoader->load();
                if ($shipment) {
                    $track->delete();

                    $this->_view->loadLayout();
                    $this->_view->getPage()->getConfig()->getTitle()->prepend(__('Shipments'));
                    $response = $this->_view->getLayout()->getBlock('shipment_tracking')->toHtml();
                } else {
                    $response = [
                        'error' => true,
                        'message' => __('We can\'t initialize shipment for delete tracking number.'),
                    ];
                }
            } catch (\Exception $e) {
                $response = ['error' => true, 'message' => __('We can\'t delete tracking number.')];
            }
        } else {
            $response = [
                'error' => true,
                'message' => __('We can\'t load track with retrieving identifier right now.')
            ];
        }
        if (is_array($response)) {
            $response = $this->_objectManager->get('Magento\Framework\Json\Helper\Data')->jsonEncode($response);
            $this->getResponse()->representJson($response);
        } else {
            $this->getResponse()->setBody($response);
        }
    }
}
