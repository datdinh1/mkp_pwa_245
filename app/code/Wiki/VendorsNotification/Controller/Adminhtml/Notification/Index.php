<?php
namespace Wiki\VendorsNotification\Controller\Adminhtml\Notification;

use Wiki\VendorsNotification\Controller\Adminhtml\Notification;

class Index extends Notification
{
    public function execute()
    {
        if ( $this->getRequest()->getQuery('ajax') ){
            $this->_forward('grid');
            return;
        }
        
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->_resultPageFactory->create();
        $resultPage->setActiveMenu('Wiki_VendorsNotification::main_menu');
        $resultPage->getConfig()->getTitle()->prepend(__('Manage Notification'));

        return $resultPage;
    }
}