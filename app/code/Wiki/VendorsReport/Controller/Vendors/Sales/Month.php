<?php

namespace Wiki\VendorsReport\Controller\Vendors\Sales;

class Month extends \Wiki\Vendors\Controller\Vendors\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    protected $_aclResource = 'Wiki_VendorsReport::report_sales_month';
    /**
     * @return void
     */
    public function execute()
    {
        $this->_initAction();
        $this->setActiveMenu('Wiki_VendorsReport::report_sales_month');
        $title = $this->_view->getPage()->getConfig()->getTitle();
        $title->prepend(__("Reports"));
        $title->prepend(__("Sales by Month of Year"));
        $this->_addBreadcrumb(__("Reports"), __("Reports"))->_addBreadcrumb(__("Sales by Month of Year"), __("Sales by Month of Year"));
        $this->_view->renderLayout();
    }
}
