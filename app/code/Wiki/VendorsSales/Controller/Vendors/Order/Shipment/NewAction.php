<?php

namespace Wiki\VendorsSales\Controller\Vendors\Order\Shipment;

class NewAction extends \Wiki\Vendors\App\AbstractAction
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    protected $_aclResource = 'Wiki_VendorsSales::sales_order_action_ship';
    
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;
    
    /**
     * @var \Wiki\VendorsSales\Controller\Vendors\Order\ShipmentLoader
     */
    protected $shipmentLoader;

    /**
     * @param  \Wiki\Vendors\App\Action\Context $context
     * @param \Wiki\VendorsSales\Controller\Vendors\Order\ShipmentLoader $shipmentLoader
     */
    public function __construct(
        \Wiki\Vendors\App\Action\Context $context,
        \Wiki\VendorsSales\Controller\Vendors\Order\ShipmentLoader $shipmentLoader
    ) {
        $this->shipmentLoader = $shipmentLoader;
        $this->_coreRegistry = $context->getCoreRegsitry();
        parent::__construct($context);
    }

    /**
     * Shipment create page
     *
     * @return void
     */
    public function execute()
    {
        $vendorOrder = $this->_objectManager->create('Wiki\VendorsSales\Model\Order')->load($this->getRequest()->getParam('order_id'));
        
        $this->shipmentLoader->setOrderId($vendorOrder->getOrderId());
        $this->shipmentLoader->setShipmentId($this->getRequest()->getParam('shipment_id'));
        $this->shipmentLoader->setShipment($this->getRequest()->getParam('shipment'));
        $this->shipmentLoader->setTracking($this->getRequest()->getParam('tracking'));
        $this->shipmentLoader->setVendorOrder($vendorOrder);
        
        $shipment = $this->shipmentLoader->load();
        if ($shipment) {
            $comment = $this->_objectManager->get('Magento\Backend\Model\Session')->getCommentText(true);
            if ($comment) {
                $shipment->setCommentText($comment);
            }
            
            $this->_coreRegistry->register('vendor_order', $vendorOrder);
            
            $this->_view->loadLayout();
            $this->_setActiveMenu('Wiki_VendorsSales::sales_shipments');
            $this->_view->getPage()->getConfig()->getTitle()->prepend(__('Shipments'));
            $this->_view->getPage()->getConfig()->getTitle()->prepend(__('New Shipment'));
            $this->_view->renderLayout();
        } else {
            $this->_redirect('*/order/view', ['order_id' => $this->getRequest()->getParam('order_id')]);
        }
    }
}
