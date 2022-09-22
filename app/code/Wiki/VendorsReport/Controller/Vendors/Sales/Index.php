<?php

namespace Wiki\VendorsReport\Controller\Vendors\Sales;

class Index extends \Wiki\Vendors\Controller\Vendors\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    protected $_aclResource = 'Wiki_VendorsReport::report_sales_overview';

    /**
     * @return void
     */
    public function execute()
    {
        $this->_initAction();
        $this->setActiveMenu('Wiki_VendorsReport::report_sales_overview');
        $title = $this->_view->getPage()->getConfig()->getTitle();
        $title->prepend(__("Reports"));
        $title->prepend(__("Sales Reports"));
        $this->_addBreadcrumb(__("Reports"), __("Reports"))->_addBreadcrumb(__("Sales Reports"), __("Sales Reports"));
        $this->_view->renderLayout();
    }
}
