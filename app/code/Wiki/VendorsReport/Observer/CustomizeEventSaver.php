<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\VendorsReport\Observer;

/**
 * Reports Event observer model
 */
class CustomizeEventSaver extends \Magento\Reports\Observer\EventSaver
{
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @var \Magento\Reports\Model\EventFactory
     */
    protected $_eventFactory;

    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $_customerSession;

    /**
     * @var \Magento\Customer\Model\Visitor
     */
    protected $_customerVisitor;

    protected $_cart;

    /**
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Reports\Model\EventFactory $event
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Customer\Model\Visitor $customerVisitor
     */
    public function __construct(
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Reports\Model\EventFactory $event,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Customer\Model\Visitor $customerVisitor,

        \Magento\Checkout\Model\Cart $cart
    ) {
        $this->_storeManager = $storeManager;
        $this->_eventFactory = $event;
        $this->_customerSession = $customerSession;
        $this->_customerVisitor = $customerVisitor;

        $this->_cart = $cart;
    }

    /**
     * Save event
     *
     * @param int $eventTypeId
     * @param int $objectId
     * @param int|null $subjectId
     * @param int $subtype
     * @return void
     */
    public function save($eventTypeId, $objectId, $subjectId = null, $subtype = 0)
    {
        if ($subjectId === null) {
            if ($this->_customerSession->isLoggedIn()) {
                $subjectId = $this->_customerSession->getCustomerId();
            } else {
                $subjectId = $this->_customerVisitor->getId();
                $subtype = 1;
            }
        }
         /** @var \Magento\Reports\Model\Event $eventModel */
        $eventModel         = $this->_eventFactory->create();
        $storeId            = $this->_storeManager->getStore()->getId();
 
 
        $cartProductList    = $this->_cart->getQuote()->getAllItems();
        $objectManager      = \Magento\Framework\App\ObjectManager::getInstance();
        $connection         = $objectManager->get('Magento\Framework\App\ResourceConnection')->getConnection('\Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION');

        $listOrderbyVendor  = $connection->fetchAll("SELECT vendor_id FROM `catalog_product_entity` WHERE entity_id = $objectId LIMIT 1");

        $vendor_id          = 0;
        if(isset($listOrderbyVendor) && count($listOrderbyVendor) > 0){
            $vendor_id      = ($listOrderbyVendor[0]['vendor_id']);
        }
        //echo $vendor_id;
        if($eventTypeId == 4){
            if(isset($cartProductList) && count($cartProductList) > 0 ){
                foreach($cartProductList as $item) {
                 
                    if($item->getProductId() == $objectId)  {
                    
                        $eventModel->setData([
                            'event_type_id' => $eventTypeId,
                            'object_id' => $objectId,
                            'subject_id' => $subjectId,
                            'subtype' => $subtype,
                            'store_id' => $storeId,
                            'vendor_id' => $vendor_id,
                            'qty_in_cart' => $item->getQty(),
                        ]);
                        $eventModel->save();      
                    }  
                }
            }
        } else {
             $eventModel->setData([
                 'event_type_id' => $eventTypeId,
                 'object_id' => $objectId,
                 'subject_id' => $subjectId,
                 'subtype' => $subtype,
                 'store_id' => $storeId,
                 'vendor_id' => $vendor_id,
                 'qty_in_cart' => 0,
             ]);
             $eventModel->save();

         }

       
            
  
    }
}
