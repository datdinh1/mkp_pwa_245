<?php

namespace Wiki\VendorsAuction\Controller\Vendors\Create;

class Index extends \Wiki\Vendors\Controller\Vendors\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    protected $_aclResource = 'Wiki_VendorsAuction::create';

    /**
     * @return void
     */
    public function execute()
    {
        $this->getRequest()->setParam('vendor_id', $this->_session->getVendor()->getId());
        $this->_initAction();
        $title = $this->_view->getPage()->getConfig()->getTitle();
        $title->prepend(__("New Product"));
        $this->setActiveMenu('Wiki_VendorsAuction::create');
        $this->_addBreadcrumb(__("Auction"), __("Auction"))
            ->_addBreadcrumb(__("New Product"), __("New Product"));
        $this->_view->renderLayout();
    }
}
