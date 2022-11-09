<?php

namespace Wiki\VendorsAuction\Controller\Vendors\Dashboard;

class Index extends \Wiki\Vendors\Controller\Vendors\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    protected $_aclResource = 'Wiki_VendorsAuction::dashboard';

    /**
     * @return void
     */
    public function execute()
    {
        $this->getRequest()->setParam('vendor_id', $this->_session->getVendor()->getId());
        $this->_initAction();
        $title = $this->_view->getPage()->getConfig()->getTitle();
        $title->prepend(__("Dashboard"));
        $this->setActiveMenu('Wiki_VendorsAuction::dashboard');
        $this->_addBreadcrumb(__("Auction"), __("Auction"))
             ->_addBreadcrumb(__("Dashboard"), __("Dashboard"));
        $this->_view->renderLayout();
    }
}
