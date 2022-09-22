<?php
namespace Wiki\VendorsReport\Controller\Adminhtml;
 
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
 
class Reports extends Action
{
    protected $_coreRegistry;
    protected $_resultPageFactory;
 
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->_coreRegistry = $coreRegistry;
        $this->_resultPageFactory = $resultPageFactory;
 
    }
    public function execute()
    {
        $this->_view->loadLayout();

        $this->_view->renderLayout();
    }
 
    protected function _isAllowed()
    {
        return true;
    }
}