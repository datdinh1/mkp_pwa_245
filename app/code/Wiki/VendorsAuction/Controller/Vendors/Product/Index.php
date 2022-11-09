<?php

namespace Wiki\VendorsAuction\Controller\Vendors\Product;

class Index extends \Wiki\Vendors\Controller\Vendors\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    protected $_aclResource = 'Wiki_VendorsAuction::product';

    /**
     * @return void
     */
    public function execute()
    {
        $this->getRequest()->setParam('vendor_id', $this->_session->getVendor()->getId());
        $this->_initAction();
        $title = $this->_view->getPage()->getConfig()->getTitle();
        $title->prepend(__("Auction Products"));
        $this->setActiveMenu('Wiki_VendorsAuction::product');
        $this->_addBreadcrumb(__("Auction"), __("Auction"))
            ->_addBreadcrumb(__("Products"), __("Products"));
        $this->_view->renderLayout();
    }
}
