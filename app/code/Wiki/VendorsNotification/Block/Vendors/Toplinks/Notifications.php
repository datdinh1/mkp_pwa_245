<?php
// @codingStandardsIgnoreFile

namespace Wiki\VendorsNotification\Block\Vendors\Toplinks;

/**
 * Vendor Notifications block
 */
class Notifications extends \Wiki\Vendors\Block\Vendors\AbstractBlock
{
    
    /**
     * @var \Wiki\Vendors\Model\Session
     */
    protected $_vendorSession;
    
    /**
     * @var \Wiki\VendorsMessage\Model\ResourceModel\Message\Collection
     */
    protected $_unreadMessageCollection;
    
    /**
     * @var \Wiki\VendorsNotification\Model\NotificationFactory
     */
    protected $_notificationFactory;
    
    /**
     * @var \Wiki\VendorsNotification\Model\ResourceModel\Notification\Collection
     */
    protected $_notificationCollection;
    
    /**
     * @var \Wiki\VendorsNotification\Model\ResourceModel\Notification\Collection
     */
    protected $_unReachedNotificationCollection;
    
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Wiki\Vendors\Model\UrlInterface $url,
        \Wiki\VendorsNotification\Model\NotificationFactory $notificaitonFactory,
        \Wiki\Vendors\Model\Session $vendorSession,
        array $data = []
    ) {
        parent::__construct($context, $url, $data);
        $this->_vendorSession = $vendorSession;
        $this->_notificationFactory = $notificaitonFactory;
    }
    
    /**
     * Get Notification Collection
     * 
     * @return \Wiki\VendorsNotification\Model\ResourceModel\Notification\Collection
     */
    public function getNotificationCollection(){
        if(!$this->_notificationCollection){
            $this->_notificationCollection = $this->_notificationFactory->create()->getCollection();
            $this->_notificationCollection->addFieldToFilter('vendor_id', $this->_vendorSession->getVendor()->getId())
                ->addFieldToFilter('customer_id', 0)
                ->setOrder('notification_id','DESC')
                ->setPageSize(10);
        }
        
        return $this->_notificationCollection;
    }
    
    /**
     * Get Unreached Notification Collection
     *
     * @return \Wiki\VendorsNotification\Model\ResourceModel\Notification\Collection
     */
    public function getUnreachedNotificationCollection(){
        if(!$this->_unReachedNotificationCollection){
            $this->_unReachedNotificationCollection = $this->_notificationFactory->create()->getCollection();
            $this->_unReachedNotificationCollection->addFieldToFilter('vendor_id', $this->_vendorSession->getVendor()->getId())
            ->addFieldToFilter('is_read', 0)->addFieldToFilter('customer_id', 0)
            ->setOrder('notification_id','DESC');
        }
    
        return $this->_unReachedNotificationCollection;
    }
    
    /**
     * Get unreached notifications count
     * 
     * @return int
     */
    public function getNotifiationCount(){
        return $this->getUnreachedNotificationCollection()->count();
    }
    
    /**
     * Get View notification URL
     * 
     * @param \Wiki\VendorsNotification\Model\Notification $notification
     * @return string
     */
    public function getViewUrl(\Wiki\VendorsNotification\Model\Notification $notification){
        return $this->getUrl('notification/index/view',['id' => $notification->getId()]);
    }
    
    /**
     * Get Mark All as Read URL
     * @return string
     */
    public function getMarkAllAsReadUrl(){
        return $this->getUrl('notification/index/markAllRead');
    }
    
    /**
     * Get view all notifications URL
     * 
     * @return string
     */
    public function getViewAllUrl(){
        return $this->getUrl('notification/index/index');
    }
    
    /**
     * CHeck if the account has permission to view notifications
     * 
     * @see \Magento\Framework\View\Element\Template::_toHtml()
     */
    protected function _toHtml(){
        
        $permission = new \Wiki\Vendors\Model\AclResult();
        $this->_eventManager->dispatch(
            'ves_vendor_check_acl',
            [
                'resource' => 'Wiki_Vendors::notifications',
                'permission' => $permission
            ]
        );
        
        return $permission->isAllowed()?parent::_toHtml():'';
    }
}
