<?php
/**
 *
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\VendorsDashboard\Controller\Vendors\Index;

class Index extends \Wiki\Vendors\Controller\Vendors\Action
{
    protected $_aclResource = 'Wiki_Vendors::dashboard';
    
    /**
     * @return void
     */
    public function execute()
    {
        $this->_initAction();
        $this->setActiveMenu('Wiki_Vendors::dashboard');
        $this->_view->getPage()->getConfig()->getTitle()->prepend(__("Dashboard"));
        $this->_addBreadcrumb(__("Dashboard"), __("Dashboard"));
        $this->_view->renderLayout();
    }
}
