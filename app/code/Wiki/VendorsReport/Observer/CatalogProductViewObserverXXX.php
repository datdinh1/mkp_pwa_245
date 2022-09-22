<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\VendorsReport\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Reports\Model\Event;
use Magento\Reports\Observer\EventSaver;


/**
 * Reports Event observer model
 * @SuppressWarnings(PHPMD.CookieAndSessionMisuse)
 */
class CatalogProductViewObserverXXX extends \Magento\Reports\Observer\CatalogProductViewObserver
{
   
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @var \Magento\Reports\Model\Product\Index\ViewedFactory
     */
    protected $_productIndxFactory;

    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $_customerSession;

    /**
     * @var \Magento\Customer\Model\Visitor
     */
    protected $_customerVisitor;

    /**
     * @var EventSaver
     */
    protected $eventSaver;

    /**
     * @var \Magento\Reports\Model\ReportStatus
     */
    private $reportStatus;

     /**
     * @var \Magento\Reports\Model\Event
     */
    private $event;
    /**
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Reports\Model\Product\Index\ViewedFactory $productIndxFactory
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Customer\Model\Visitor $customerVisitor
     * @param EventSaver $eventSaver
     * @param \Magento\Reports\Model\ReportStatus $reportStatus
     */
    public function __construct(
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Reports\Model\Product\Index\ViewedFactory $productIndxFactory,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Customer\Model\Visitor $customerVisitor,
        EventSaver $eventSaver,
        \Magento\Reports\Model\ReportStatus $reportStatus,

        \Magento\Reports\Model\EventFactory $eventfactory,
        \Wiki\VendorsProduct\Model\ProductManagement $productManagement,
        \Wiki\Vendors\Model\SellerManagement $sellerManagement

    ) {
        $this->_storeManager        = $storeManager;
        $this->_productIndxFactory  = $productIndxFactory;
        $this->_customerSession     = $customerSession;
        $this->_customerVisitor     = $customerVisitor;
        $this->eventSaver           = $eventSaver;
        $this->reportStatus         = $reportStatus;

        $this->event                = $eventfactory;
        $this->productManagement    = $productManagement;
        $this->sellerManagement    = $sellerManagement;
    }

    /**
     * View Catalog Product action
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        if (!$this->reportStatus->isReportEnabled(Event::EVENT_PRODUCT_VIEW)) {
            return;
        }

        $productId = $observer->getEvent()->getProduct()->getId();

        $viewData['product_id'] = $productId;
        $viewData['store_id']   = $this->_storeManager->getStore()->getId();
        if ($this->_customerSession->isLoggedIn()) {
            $viewData['customer_id'] = $this->_customerSession->getCustomerId();
        } else {
            $viewData['visitor_id'] = $this->_customerVisitor->getId();
        }

        $this->_productIndxFactory->create()->setData($viewData)->save()->calculate();

        $this->eventSaver->save(Event::EVENT_PRODUCT_VIEW, $productId);


        
        /**-------------------------------- */

        $getSellerbyProductID  = $this->sellerManagement->getDataMyStoreByProductID(6);

        $objectManager          = \Magento\Framework\App\ObjectManager::getInstance();
        $connection             = $objectManager->get('Magento\Framework\App\ResourceConnection')->getConnection('\Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION');

        $listEvent    = $connection->fetchAll("SELECT object_id , logged_at FROM `report_event` WHERE event_type_id = 1");

        // // foreach($listEvent as $event){
           
        // // }
        // $date = "2021-02-25 08:49:08";

   
        //  echo "<pre>";
    
        // $d = date_parse_from_format("Y-m-d", $date);
        // echo $d["month"];
        // echo "<br>";

        //     $countArr = [];
            
        //     foreach($listEvent as $event){
        //         if(isset($countArr[$event['object_id']]) ) {
        //             $countArr[$event['object_id']]['count'] ++;
        //             $countArr[$event['object_id']][] = $event['logged_at'];
        //         }
        //         else {
        //             $countArr[$event['object_id']]['count'] = 1; 
        //             $countArr[$event['object_id']][] = $event['logged_at'];
        //         }
        //     }
        //    // print_r($listEvent);
        // print_r($countArr);
       // $listPrduct = $this->productManagement->save('best');
      //  exit;
    }
}
