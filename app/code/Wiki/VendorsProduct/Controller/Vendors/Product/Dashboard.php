<?php

namespace Wiki\VendorsProduct\Controller\Vendors\Product;

class Dashboard extends \Wiki\Vendors\Controller\Vendors\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    protected $_aclResource = 'Wiki_VendorsProduct::catalog_dashboard';

    /**
     * @return void
     */
    public function execute()
    {
        $this->getRequest()->setParam('vendor_id', $this->_session->getVendor()->getId());
        $this->_initAction();
        $title = $this->_view->getPage()->getConfig()->getTitle();
        $title->prepend(__("List of Products"));
        $title->prepend(__("Manage Product"));
        $this->setActiveMenu('Wiki_VendorsProduct::catalog_dashboard');
        $this->_addBreadcrumb(__("List of Products"), __("List of Products"))
            ->_addBreadcrumb(__("Manage Product"), __("Manage Product"));
        $this->_view->renderLayout();
    }
}
