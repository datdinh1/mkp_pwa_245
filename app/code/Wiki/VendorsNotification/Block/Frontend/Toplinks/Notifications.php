<?php
namespace Wiki\VendorsNotification\Block\Frontend\Toplinks;

use Magento\Customer\Block\Account\SortLinkInterface;
use Magento\Customer\Block\Account\AuthorizationLink;

class Notifications extends \Wiki\Vendors\Block\Vendors\AbstractBlock
{
    const CONTEXT_AUTH = 'customer_logged_in';
/**
 * @var \Wiki\VendorsNotification\Model\NotificationFactory
 */
protected $_notificationFactory;

/**
 * @var \Wiki\VendorsNotification\Model\ResourceModel\Notification\Collection
 */
protected $_notificationCollection;

protected $_unReachedNotificationCollection;

protected $_customerSessionFactory;

protected $customerUrl;




protected $httpContext;


    /**
     * @var Order\SalesVendorsFactory
     */
    protected $_salesVendorsFactory;


// protected $_template = 'Wiki_VendorsNotification::toplinks/notifications.phtml';

public function __construct(
    \Magento\Framework\View\Element\Template\Context $context,
    \Magento\Framework\App\Http\Context $httpContext,
    \Wiki\Vendors\Model\UrlInterface $url,
    \Magento\Customer\Model\Url $customerUrl,
    \Wiki\VendorsNotification\Model\NotificationFactory $notificaitonFactory,
    \Wiki\Vendors\Model\Session $vendorSession,
    \Wiki\VendorsSales\Model\SalesVendorsFactory $salesVendorsFactory,
   
    array $data = []
) {
    parent::__construct($context, $url, $data);
    $this->httpContext = $httpContext;
    $this->_vendorSession = $vendorSession;
    $this->_notificationFactory = $notificaitonFactory;
    $this->_customerUrl = $customerUrl;
    $this->_salesVendorsFactory = $salesVendorsFactory;
  

}
public function textSalesvendors(){
    $post = $this->_salesVendorsFactory->create();
        $collection = $post->getCollection();
        $collection->addFieldToFilter('entity_id', 19)->addFieldToSelect('customer_id');
		
        return  $collection;
}
    public function getCustomerID(){
        $objectManager =  '\Magento\Framework\App\ObjectManager'::getInstance();
        $customerSession = $objectManager->get('Magento\Customer\Model\SessionFactory')->create();
        $user_id = $customerSession->getCustomer()->getId();

        return $user_id;
    }
    public function getUnreachedNotificationCollection(){
      
        if(!$this->_unReachedNotificationCollection){
            $this->_unReachedNotificationCollection = $this->_notificationFactory->create()->getCollection();
            $this->_unReachedNotificationCollection
            ->addFieldToFilter('customer_id', $this->getCustomerID())
           ->addFieldToFilter('is_read', 0)
            ->setOrder('notification_id','DESC');
        }

        return $this->_unReachedNotificationCollection;
    }
    public function getNotifiationCount(){
        return $this->getUnreachedNotificationCollection()->count();
    }
     /**
     * Get Notification Collection
     *
     * @return \Wiki\VendorsNotification\Model\ResourceModel\Notification\Collection
     */
    public function getNotificationCollection(){
        
        if(!$this->_notificationCollection){
            $this->_notificationCollection = $this->_notificationFactory->create()->getCollection();
            $this->_notificationCollection
            ->addFieldToFilter('customer_id', $this->getCustomerID())
            ->setOrder('notification_id','DESC')
                ->setPageSize(10);
        }

        return $this->_notificationCollection;
    }
    public function getViewAllUrl(){
        return $this->getBaseUrl().'usernoti/index/index';
    }

}



?>
