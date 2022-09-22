<?php

namespace Wiki\VendorsSales\Controller\Vendors\Order\Shipment;

use Magento\Framework\Registry;

class View extends \Wiki\Vendors\App\AbstractAction
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
     * @var Registry
     */
    protected $registry;
    
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var \Magento\Backend\Model\View\Result\ForwardFactory
     */
    protected $resultForwardFactory;

    /**
     * @param \Wiki\Vendors\App\Action\Context $context
     * @param \Magento\Shipping\Controller\Adminhtml\Order\ShipmentLoader $shipmentLoader
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory
     */
    public function __construct(
        \Wiki\Vendors\App\Action\Context $context,
        \Magento\Shipping\Controller\Adminhtml\Order\ShipmentLoader $shipmentLoader,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory
    ) {
        $this->shipmentLoader = $shipmentLoader;
        $this->registry = $context->getCoreRegsitry();
        $this->resultPageFactory = $resultPageFactory;
        $this->resultForwardFactory = $resultForwardFactory;
        parent::__construct($context);
    }

    /**
     * Shipment information page
     *
     * @return void
     */
    public function execute()
    {
        $this->shipmentLoader->setShipmentId($this->getRequest()->getParam('shipment_id'));
        $shipment = $this->shipmentLoader->load();
        if ($shipment) {
            $vendorOrder = $this->_objectManager->create('Wiki\VendorsSales\Model\Order')->load($shipment->getVendorOrderId());


            if ($vendorOrder->getVendorId() != $this->_session->getVendor()->getId()) {
                $resultForward = $this->resultForwardFactory->create();
                $resultForward->forward('noroute');
                return $resultForward;
            }

            $this->registry->register('vendor_order', $vendorOrder);
            
            $resultPage = $this->resultPageFactory->create();
            $this->setActiveMenu('Wiki_VendorsSales::sales_shipments');
            $resultPage->getLayout()->getBlock('sales_shipment_view')
                ->updateBackButtonUrl($this->getRequest()->getParam('come_from'));
//             $resultPage->setActiveMenu('Wiki_VendorsSales::sales_orders');
            $resultPage->getConfig()->getTitle()->prepend(__('Shipments'));
            $resultPage->getConfig()->getTitle()->prepend("#" . $shipment->getIncrementId());
            return $resultPage;
        } else {
            $resultForward = $this->resultForwardFactory->create();
            $resultForward->forward('noroute');
            return $resultForward;
        }
    }
}
