<?php 
namespace Wiki\VendorsNotification\Controller\Index;  
use Wiki\SmsNotification\Model\NewsFactory;
class Index extends \Magento\Framework\App\Action\Action { 
    protected $_pageFactory;
       /**
     * News model factory
     *
     * @var \Wiki\SmsNotification\Model\NewsFactory
     */
    protected $_newsFactory;
	  /**
     * @var \Wiki\VendorsNotification\Model\NotificationFactory
     */
    protected $_notificationFactory;

    protected $cacheTypeList;

    protected $cacheFrontendPool;

    public $blockDisplay;
    
	public function __construct(
    
		\Magento\Framework\App\Action\Context $context,
		\Magento\Framework\View\Result\PageFactory $pageFactory,
		\Wiki\VendorsNotification\Model\NotificationFactory $notificationFactory,
    \Wiki\VendorsNotification\Block\Frontend\Display $blockDisplay
    )
	{
		$this->_pageFactory = $pageFactory;
		$this->_notificationFactory = $notificationFactory;
    
    $this->blockDisplay = $blockDisplay;
    return parent::__construct($context);
	}

	public function execute()
	{
		
         $resultPage = $this->_pageFactory->create();
         $resultPage->getConfig()->getTitle()->prepend(__("Notification"));
         $this->blockDisplay->flushCache();
         return $resultPage;
    
	}
 
} 
?>