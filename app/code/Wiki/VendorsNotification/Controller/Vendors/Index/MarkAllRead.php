<?php

namespace Wiki\VendorsNotification\Controller\Vendors\Index;

class MarkAllRead extends \Wiki\Vendors\Controller\Vendors\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    protected $_aclResource = 'Wiki_Vendors::notifications';
    
    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $_resultJsonFactory;
    
    /**
     * @var \Wiki\VendorsNotification\Model\NotificationFactory
     */
    protected $_notificationFactory;
    
    public function __construct(
        \Wiki\Vendors\App\Action\Context $context,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Wiki\VendorsNotification\Model\NotificationFactory $notificationFactory
    ) {
        parent::__construct($context);
        $this->_resultJsonFactory = $resultJsonFactory;
        $this->_notificationFactory = $notificationFactory;
    }
    /**
     * @return void
     */
    public function execute()
    {
        
        $response = new \Magento\Framework\DataObject();
        try {
            $resource = $this->_notificationFactory->create()->getResource();
            $resource->getConnection()->update(
                $resource->getTable('ves_vendor_notification'),
                ['is_read' => 1],
                ['vendor_id =?' => $this->_session->getVendor()->getId(), 'is_read = 0','customer_id = 0']
            );
            
            $result = ['success' => true];
        } catch (\Exception $e) {
            $result = ['success' => false, 'msg' =>$e->getMessage()];
        }
        
        $response->setData($result);
        
        return $this->_resultJsonFactory->create()->setJsonData($response->toJson());
    }
}
