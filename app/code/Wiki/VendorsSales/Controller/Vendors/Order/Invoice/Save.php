<?php

namespace Wiki\VendorsSales\Controller\Vendors\Order\Invoice;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Registry;
use Magento\Sales\Model\Order\Email\Sender\InvoiceSender;
use Magento\Sales\Model\Order\Email\Sender\ShipmentSender;
use Magento\Sales\Model\Order\ShipmentFactory;
use Wiki\VendorsSales\Model\Service\InvoiceService;
use Wiki\Vendors\App\Action\Context;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Save extends \Wiki\Vendors\App\AbstractAction
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    protected $_aclResource = 'Wiki_VendorsSales::sales_order_action_invoice';
    
    /**
     * @var InvoiceSender
     */
    protected $invoiceSender;

    /**
     * @var ShipmentSender
     */
    protected $shipmentSender;

    /**
     * @var ShipmentFactory
     */
    protected $shipmentFactory;

    /**
     * @var Registry
     */
    protected $registry;

    /**
     * @var InvoiceService
     */
    private $invoiceService;

      /**
     * @var \Wiki\VendorsSales\Model\OrderFactory
     */
    protected $_orderFactory;

    protected $_salesVendorsFactory;

    protected $orderRepository;

    protected $_eventManager;

    /**
     * Save constructor.
     * @param Context $context
     * @param InvoiceSender $invoiceSender
     * @param ShipmentSender $shipmentSender
     * @param ShipmentFactory $shipmentFactory
     * @param InvoiceService $invoiceService
     */
    public function __construct(
        Context $context,
        InvoiceSender $invoiceSender,
        ShipmentSender $shipmentSender,
        ShipmentFactory $shipmentFactory,
        InvoiceService $invoiceService,
        
        
        \Wiki\VendorsSales\Model\OrderFactory $oderfactory,
        \Wiki\VendorsSales\Model\SalesVendorsFactory $salesVendorsFactory,
        \Magento\Framework\Event\ManagerInterface $eventManager,
        \Magento\Sales\Api\OrderRepositoryInterface $orderRepository
    ) {
        $this->registry = $context->getCoreRegsitry();
        $this->invoiceSender = $invoiceSender;
        $this->shipmentSender = $shipmentSender;
        $this->shipmentFactory = $shipmentFactory;
        $this->invoiceService = $invoiceService;


        $this->shipmentSender = $shipmentSender;
        $this->_orderFactory = $oderfactory;
        $this->_salesVendorsFactory = $salesVendorsFactory;
        $this->_eventManager = $eventManager;
        $this->orderRepository = $orderRepository;
        parent::__construct($context);
    }

    /**
     * Prepare shipment
     *
     * @param \Magento\Sales\Model\Order\Invoice $invoice
     * @param \Wiki\VendorsSales\Model\Order $vendorOrder
     * @return \Magento\Sales\Model\Order\Shipment|false
     */
    protected function _prepareShipment($invoice, $vendorOrder)
    {
        $invoiceData = $this->getRequest()->getParam('invoice');

        $shipment = $this->shipmentFactory->create(
            $invoice->getOrder(),
            isset($invoiceData['items']) ? $invoiceData['items'] : [],
            $this->getRequest()->getPost('tracking')
        );
 	    $shipment->setVendorOrderId($vendorOrder->getId());
        if (!$shipment->getTotalQty()) {
            return false;
        }

        return $shipment->register();
    }

    /**
     * Save invoice
     * We can save only new invoice. Existing invoices are not editable
     *
     * @return \Magento\Framework\Controller\ResultInterface
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

       
        $isPost = $this->getRequest()->isPost();
        if (!$isPost) {
            $this->messageManager->addErrorMessage(__('We can\'t save the invoice right now.'));
            return $resultRedirect->setPath('sales/order/index');
        }

        $data = $this->getRequest()->getPost('invoice');
        $orderId = $this->getRequest()->getParam('order_id');

        if (!empty($data['comment_text'])) {
            $this->_objectManager->get('Magento\Backend\Model\Session')->setCommentText($data['comment_text']);
        }

        try {
            $invoiceData = $this->getRequest()->getParam('invoice', []);
            $invoiceItems = isset($invoiceData['items']) ? $invoiceData['items'] : [];
            /** @var \Wiki\VendorsSales\Model\Order $vendorOrder */
            $vendorOrder = $this->_objectManager->create('Wiki\VendorsSales\Model\Order')->load($orderId);
            
            /** @var \Magento\Sales\Model\Order $order */
            $order = $this->_objectManager->create('Magento\Sales\Model\Order')->load($vendorOrder->getOrderId());
            
            if (!$vendorOrder->getId() || !$order->getId()) {
                throw new \Magento\Framework\Exception\LocalizedException(__('The order no longer exists.'));
            }

            if (!$vendorOrder->canInvoice() || !$order->canInvoice()) {
                throw new \Magento\Framework\Exception\LocalizedException(
                    __('The order does not allow an invoice to be created.')
                );
            }

            $invoice = $this->invoiceService->prepareVendorInvoice($vendorOrder, $invoiceItems);

            if (!$invoice) {
                throw new LocalizedException(__('We can\'t save the invoice right now.'));
            }

            if (!$invoice->getTotalQty()) {
                throw new \Magento\Framework\Exception\LocalizedException(
                    __('You can\'t create an invoice without products.')
                );
            }
            $this->registry->register('current_invoice', $invoice);
            if (!empty($data['capture_case'])) {
                $invoice->setRequestedCaptureCase($data['capture_case']);
            }

            if (!empty($data['comment_text'])) {
                $invoice->addComment(
                    $data['comment_text'],
                    isset($data['comment_customer_notify']),
                    isset($data['is_visible_on_front'])
                );

                $invoice->setCustomerNote($data['comment_text']);
                $invoice->setCustomerNoteNotify(isset($data['comment_customer_notify']));
            }

            $invoice->register();

            $invoice->getOrder()->setCustomerNoteNotify(!empty($data['send_email']));
            $invoice->getOrder()->setIsInProcess(true);

            $transactionSave = $this->_objectManager->create(
                'Magento\Framework\DB\Transaction'
            )->addObject(
                $invoice
            )->addObject(
                $invoice->getOrder()
            );
            $shipment = false;
            if (!empty($data['do_shipment']) || (int)$invoice->getOrder()->getForcedShipmentWithInvoice()) {
                $shipment = $this->_prepareShipment($invoice, $vendorOrder);
                if ($shipment) {
                    $transactionSave->addObject($shipment);
                }
            }
            $transactionSave->save();
/**------------------------------------------------------------------------------------ */
   
$post = $this->_orderFactory->create();
$collection = $post->getCollection()
    ->addFieldToFilter('entity_id', $this->getRequest()->getParam('order_id'))
    ->addFieldToSelect('status')
    ->getColumnValues('status');

    $postSales = $this->_salesVendorsFactory->create();
    $collectionSales = $postSales->getCollection();
    
    $customer_sale = $collectionSales->addFieldToFilter('entity_id', $this->getRequest()->getParam('order_id'))
    ->addFieldToSelect('customer_id')->getColumnValues('customer_id');


    $getVendor = $this->_orderFactory->create();
    $vendor = $getVendor->getCollection()
->addFieldToFilter('entity_id', $this->getRequest()->getParam('order_id'))

                       ->addFieldToSelect('vendor_id')->getColumnValues('vendor_id');
   
                       $getOder = $this->_orderFactory->create();
                       $oderID = $getOder->getCollection()
                 ->addFieldToFilter('entity_id', $this->getRequest()->getParam('order_id'))
               
                    ->addFieldToSelect('order_id')->getColumnValues('order_id');
                    //                       echo $oderID;
          

                      $order = $this->orderRepository->get($oderID[0]);
                        $orderIncrementId = $order->getIncrementId();
              


                if(count($collection) > 0){
                    if($collection[0] == 'processing'){
                        $mess = 'The order has been confirmed: #<strong>'.$orderIncrementId.'</strong> .';

                        
                      //  echo $collection[0].'-'. $vendor[0]. ' - ' . $mess . ' - ' . $customer_sale[0];

                        $this->_eventManager->dispatch(
                            'Wiki_vendors_push_notification',
                            [
                                'vendor_id' =>  $vendor[0],
                                'type' => 'sales',
                                'message' => $mess,
                                'customer_id' => $customer_sale[0]
                                
                            ]
                        );
                    }
                
                }









/**------------------------------------------------------------------------------------ */
       
            if (!empty($data['do_shipment'])) {
                $this->messageManager->addSuccessMessage(__('You created the invoice and shipment.'));
            } else {
                $this->messageManager->addSuccessMessage(__('The invoice has been created.'));
            }

            // send invoice/shipment emails
            try {
                if (!empty($data['send_email'])) {
                    $this->invoiceSender->send($invoice);
                }
            } catch (\Exception $e) {
                $this->_objectManager->get('Psr\Log\LoggerInterface')->critical($e);
                $this->messageManager->addErrorMessage(__('We can\'t send the invoice email right now.'));
            }
            if ($shipment) {
                try {
                    if (!empty($data['send_email'])) {
                        $this->shipmentSender->send($shipment);
                    }
                } catch (\Exception $e) {
                    $this->_objectManager->get('Psr\Log\LoggerInterface')->critical($e);
                    $this->messageManager->addErrorMessage(__('We can\'t send the shipment right now.'));
                }
            }
            $this->_objectManager->get('Wiki\Vendors\Model\Session')->getCommentText(true);
            return $resultRedirect->setPath('sales/order/view', ['order_id' => $orderId]);
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('We can\'t save the invoice right now.'));
            $this->_objectManager->get('Psr\Log\LoggerInterface')->critical($e);
        }
        return $resultRedirect->setPath('sales/*/new', ['order_id' => $orderId]);
    }
}
