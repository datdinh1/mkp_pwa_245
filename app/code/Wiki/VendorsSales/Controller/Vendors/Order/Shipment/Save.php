<?php
/**
 * Copyright © Wiki, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Wiki\VendorsSales\Controller\Vendors\Order\Shipment;

use Magento\Sales\Model\Order\Email\Sender\ShipmentSender;
use Magento\Framework\Controller\ResultFactory;



/**
 * Class Save
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Save extends \Wiki\Vendors\App\AbstractAction
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    protected $_aclResource = 'Wiki_VendorsSales::sales_order_action_ship';

    /**
     * @var \Wiki\VendorsSales\Controller\Vendors\Order\ShipmentLoader
     */
    protected $shipmentLoader;

    /**
     * @var \Magento\Shipping\Model\Shipping\LabelGenerator
     */
    protected $labelGenerator;

    /**
     * @var ShipmentSender
     */
    protected $shipmentSender;

    /**
     * @var \Wiki\VendorsSales\Model\OrderFactory
     */
    protected $_orderFactory;

    protected $_salesVendorsFactory;

    protected $orderRepository;

    protected $_eventManager;
    /**
     * @param \Wiki\Vendors\App\Action\Context $context
     * @param \Magento\Shipping\Controller\Adminhtml\Order\ShipmentLoader $shipmentLoader
     * @param \Magento\Shipping\Model\Shipping\LabelGenerator $labelGenerator
     * @param ShipmentSender $shipmentSender
     */
    public function __construct(
        \Wiki\Vendors\App\Action\Context $context,
        \Wiki\VendorsSales\Controller\Vendors\Order\ShipmentLoader $shipmentLoader,
        \Magento\Shipping\Model\Shipping\LabelGenerator $labelGenerator,
        \Wiki\VendorsSales\Model\OrderFactory $oderfactory,
        \Wiki\VendorsSales\Model\SalesVendorsFactory $salesVendorsFactory,
        \Magento\Framework\Event\ManagerInterface $eventManager,
        \Magento\Sales\Api\OrderRepositoryInterface $orderRepository,
        
        ShipmentSender $shipmentSender
    ) {
        $this->shipmentLoader = $shipmentLoader;
        $this->labelGenerator = $labelGenerator;
        $this->shipmentSender = $shipmentSender;
        $this->_orderFactory = $oderfactory;
        $this->_salesVendorsFactory = $salesVendorsFactory;
        $this->_eventManager = $eventManager;
        $this->orderRepository = $orderRepository;
        parent::__construct($context);
       
    }

    /**
     * Save shipment and order in one transaction
     *
     * @param \Magento\Sales\Model\Order\Shipment $shipment
     * @return $this
     */
    protected function _saveShipment($shipment)
    {
        /*Set vendor Id*/
        $shipment->setVendorId($this->_session->getVendor()->getId());
        $shipment->getOrder()->setIsInProcess(true);
        $transaction = $this->_objectManager->create(
            'Magento\Framework\DB\Transaction'
        );
        $transaction->addObject(
            $shipment
        )->addObject(
            $shipment->getOrder()
        )->save();

        return $this;
    }

    /**
     * Save shipment
     * We can save only new shipment. Existing shipments are not editable
     *
     * @return \Magento\Framework\Controller\ResultInterface
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

    
        $isPost = $this->getRequest()->isPost();
        if (!$isPost) {
            $this->messageManager->addErrorMessage(__('We can\'t save the shipment right now.'));
            return $resultRedirect->setPath('sales/order/index');
        }

        $data = $this->getRequest()->getParam('shipment');

        if (!empty($data['comment_text'])) {
            $this->_objectManager->get('Wiki\Vendors\Model\Session')->setCommentText($data['comment_text']);
        }

        $isNeedCreateLabel = isset($data['create_shipping_label']) && $data['create_shipping_label'];
        $responseAjax = new \Magento\Framework\DataObject();

        try {
            $vendorOrder = $this->_objectManager->create('Wiki\VendorsSales\Model\Order')->load($this->getRequest()->getParam('order_id'));

            $this->shipmentLoader->setOrderId($vendorOrder->getOrderId());
            $this->shipmentLoader->setShipmentId($this->getRequest()->getParam('shipment_id'));
            $this->shipmentLoader->setShipment($data);
            $this->shipmentLoader->setTracking($this->getRequest()->getParam('tracking'));
            $this->shipmentLoader->setVendorOrder($vendorOrder);

            $shipment = $this->shipmentLoader->load();
            if (!$shipment) {
                return $this->resultFactory->create(ResultFactory::TYPE_FORWARD)->forward('noroute');
            }


            if (!empty($data['comment_text'])) {
                $shipment->addComment(
                    $data['comment_text'],
                    isset($data['comment_customer_notify']),
                    isset($data['is_visible_on_front'])
                );

                $shipment->setCustomerNote($data['comment_text']);
                $shipment->setCustomerNoteNotify(isset($data['comment_customer_notify']));
            }

            $shipment->setVendorOrderId($vendorOrder->getId());

            $shipment->register();

            $shipment->getOrder()->setCustomerNoteNotify(!empty($data['send_email']));

            if ($isNeedCreateLabel) {
                $this->labelGenerator->create($shipment, $this->_request);
                $responseAjax->setOk(true);
            }

            $this->_saveShipment($shipment);

            if (!empty($data['send_email'])) {
                $this->shipmentSender->send($shipment);
            }
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
                        if($collection[0] == 'complete'){
                            $mess = 'The Order #<strong>'.$orderIncrementId.'</strong> has been sent.';

                            
                            echo $collection[0].'-'. $vendor[0]. ' - ' . $mess . ' - ' . $customer_sale[0];

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
           
            $shipmentCreatedMessage = __('The shipment has been created.');
            $labelCreatedMessage = __('You created the shipping label.');

            $this->messageManager->addSuccessMessage(
                $isNeedCreateLabel ? $shipmentCreatedMessage . ' ' . $labelCreatedMessage : $shipmentCreatedMessage
            );
            $this->_objectManager->get('Magento\Backend\Model\Session')->getCommentText(true);
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            if ($isNeedCreateLabel) {
                $responseAjax->setError(true);
                $responseAjax->setMessage($e->getMessage());
            } else {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $resultRedirect->setPath('*/*/new', ['order_id' => $this->getRequest()->getParam('order_id')]);
            }
        } catch (\Exception $e) {
            $this->_objectManager->get('Psr\Log\LoggerInterface')->critical($e);
            if ($isNeedCreateLabel) {
                $responseAjax->setError(true);
                $responseAjax->setMessage(__('An error occurred while creating shipping label.'));
            } else {
                $this->messageManager->addErrorMessage(__('Cannot save shipment.'));
                return $resultRedirect->setPath('*/*/new', ['order_id' => $this->getRequest()->getParam('order_id')]);
            }
        }
        if ($isNeedCreateLabel) {
            return $this->resultFactory->create(ResultFactory::TYPE_JSON)->setJsonData($responseAjax->toJson());
        }

        return $resultRedirect->setPath('sales/order/view', ['order_id' => $this->getRequest()->getParam('order_id')]);
    }
}
