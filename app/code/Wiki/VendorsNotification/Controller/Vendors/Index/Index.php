<?php

namespace Wiki\VendorsNotification\Controller\Vendors\Index;

class Index extends \Wiki\Vendors\Controller\Vendors\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    protected $_aclResource = 'Wiki_Vendors::notifications';
    
    /**
     * @return void
     */
    public function execute()
    {
        $this->_initAction();
        $title = $this->_view->getPage()->getConfig()->getTitle();
        $title->prepend(__("Notifications"));
        
        $this->_addBreadcrumb(__("Notifications"), __("Notifications"));
        $this->_view->renderLayout();
    }
}
