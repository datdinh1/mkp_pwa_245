<?php

namespace Wiki\VendorsNotification\Controller\Index;

use Wiki\Vendors\App\Action\Frontend\Context;
use Wiki\Vendors\Controller\AbstractAction;
class MarkAllRead extends \Magento\Framework\App\Action\Action
{

    protected $_resultJsonFactory;

    protected $_pageFactory;

    /**
     * @var \Wiki\VendorsNotification\Model\NotificationFactory
     */
    protected $_notificationFactory;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Wiki\VendorsNotification\Model\NotificationFactory $notificationFactory
    ) {
       
        $this->_resultJsonFactory = $resultJsonFactory;
        $this->_pageFactory = $pageFactory;
        $this->_notificationFactory = $notificationFactory;
        parent::__construct($context);
    }
   
    public function execute()
    {
        $response = new \Magento\Framework\DataObject();
        try {
            $resource = $this->_notificationFactory->create()->getResource();
            $resource->getConnection()->update(
                $resource->getTable('ves_vendor_notification'),
                ['is_read' => 1],
                ['customer_id =?' => 4, 'is_read = 0']
            );
            
            $result = ['success' => true];
        } catch (\Exception $e) {
            $result = ['success' => false, 'msg' =>$e->getMessage()];
        }
        
        $response->setData($result);
        
        return $this->_resultJsonFactory->create()->setJsonData($response->toJson());
    }
}
