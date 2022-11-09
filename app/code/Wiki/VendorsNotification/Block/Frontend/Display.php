<?php
namespace Wiki\VendorsNotification\Block\Frontend;

use Wiki\SmsNotification\Model\NewsFactory;

class Display extends \Magento\Framework\View\Element\Template
{
	protected $_notificationCollection;

	/**
	 * @var \Wiki\VendorsNotification\Model\NotificationFactory
	 */
    protected $_notificationFactory;
    
    protected $_productRepositoryFactory;

     /**
     * @var \Magento\Framework\Event\ManagerInterface
     */
    protected $_eventManager;

    
   

    protected $cacheTypeList;

    protected $cacheFrontendPool;

    protected $customerSession;
	public function __construct(
		\Magento\Framework\View\Element\Template\Context $context,
        \Wiki\VendorsNotification\Model\NotificationFactory $notificaitonFactory,
        \Magento\Catalog\Api\ProductRepositoryInterfaceFactory $productRepositoryFactory,
        NewsFactory $newsFactory,
        \Magento\Framework\Event\ManagerInterface $eventManager,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList,
        \Magento\Framework\App\Cache\Frontend\Pool $cacheFrontendPool
		)
	{
		parent::__construct($context);
        $this->_notificationFactory = $notificaitonFactory;
        $this->_productRepositoryFactory = $productRepositoryFactory;
        $this->_newsFactory = $newsFactory;
        $this->_eventManager = $eventManager;
        $this->customerSession = $customerSession;

        $this->cacheTypeList = $cacheTypeList;
        $this->cacheFrontendPool = $cacheFrontendPool;

	}

	public function getCustomerID(){
        $objectManager =  '\Magento\Framework\App\ObjectManager'::getInstance();
        $customerSession = $objectManager->get('Magento\Customer\Model\SessionFactory')->create();
        $user_id = $customerSession->getCustomer()->getId();

        return $user_id;
    }

	public function getNotificationCollection(){
        
        if(!$this->_notificationCollection){
            $this->_notificationCollection = $this->_notificationFactory->create()->getCollection();
            $this->_notificationCollection
            ->addFieldToFilter('customer_id',$this->getCustomerID())
            ->setOrder('notification_id','DESC')
                ->setPageSize(10);
        }

        return $this->_notificationCollection;
    }
    public function imgProduct($str){
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $collection = $objectManager->create('Magento\Sales\Model\Order'); 
      
            
            $strStrip = strip_tags($str);
            $strPos = strpos($strStrip, '#');
            if($strPos){
                $strSub = substr( $strStrip, $strPos + 1 , 9);

                $order = $objectManager->create('Magento\Sales\Model\Order')->loadByIncrementId($strSub);
                $orderItems = $order->getAllItems();

                foreach ($orderItems as $item) {
                     $product = $this->_productRepositoryFactory->create()->getById($item->getProductId());
                        
                
                }
                 $helperImport = $objectManager->get('\Magento\Catalog\Helper\Image');
                 $imageUrl = $helperImport->init($product, 'product_page_image_small')
                         ->setImageFile($product->getSmallImage()) // image,small_image,thumbnail
                       ->resize(380)
                       ->getUrl();

                      return $imageUrl;
            }
            return '';
    }
    public function getContent($str){
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $collection = $objectManager->create('Magento\Sales\Model\Order'); 
      
            
            $strStrip = strip_tags($str);
            $strPos = strpos($strStrip, '#');
            if($strPos){
                $strSub = substr( $strStrip, $strPos + 1 , 9);

                $order = $objectManager->create('Magento\Sales\Model\Order')->loadByIncrementId($strSub);
                $orderItems = $order->getAllItems();

                foreach ($orderItems as $item) {
                     $product = $this->_productRepositoryFactory->create()->getById($item->getProductId());
                        
                
                }
                $helperImport = $objectManager->get('\Magento\Catalog\Helper\Output');
                $result = $helperImport->productAttribute($product, $product->getDescription(), 'description');
                return $result;
            }
            return '';
       
    }
    public function getURLOder($str){
         $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        // $collection = $objectManager->create('Magento\Sales\Model\Order'); 
      
            
            $strStrip = strip_tags($str);
           

            $strFindSuccess = strpos($str, 'successfully');
            $strFindConfirm = strpos($str, 'confirmed');
            $strFindSent = strpos($str, 'sent');
            $url = '';
             if(isset($strFindSuccess) && $strFindSuccess != ''){ 
                 $url = 'view';
             } else if(isset($strFindConfirm) && $strFindConfirm != ''){
                $url = 'invoice';
             } else  if(isset($strFindSent) && $strFindSent != ''){
                $url = 'shipment';
             }
            $orderId = 0;
             $strStrip = strip_tags($str);
             $strPos = strpos($strStrip, '#');

             if($strPos){
                $strSub = substr( $strStrip, $strPos + 1 , 9);
                
                $collection = $objectManager->create('Magento\Sales\Model\Order'); 
                $orderInfo = $collection->loadByIncrementId($strSub);
                $orderId = $orderInfo ->getId();
            }
             
             
            $result =  $this->getBaseUrl().'sales/order/' . $url . '/order_id/' .  $orderId ;
            return $result;
            

    }
   
    public function getNotiAdmin($id){

        $notiAdmin = $this->_newsFactory->create();
 
		$listNotiAdmin = $notiAdmin->getCollection()->addFieldToFilter('id',$id )->getFirstItem();
						 

						return $listNotiAdmin;
    }
    public function getURLDetailNoti(){
        $result =  $this->getBaseUrl().'usernoti/index/detailnoti/id/' ;
        return $result;

    }
    public function flushCache()
    {
      $_types = [
        'config',
        'layout',
        'block_html',
        'collections',
        'reflection',
        'db_ddl',
        'eav',
        'config_integration',
        'config_integration_api',
        'full_page',
        'translate',
        'config_webservice'
        ];;
        foreach ($_types as $type) {
            $this->cacheTypeList->cleanType($type);
        }
        foreach ($this->cacheFrontendPool as $cacheFrontend) {
            $cacheFrontend->getBackend()->clean();
        }
    }
   

}