<?php

namespace Wiki\VendorsReport\Controller\Vendors\Sales;

class Day extends \Wiki\Vendors\Controller\Vendors\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    protected $_aclResource = 'Wiki_VendorsReport::report_sales_day';
    /**
     * @return void
     */
    public function execute()
    {
        $this->_initAction();
        $this->setActiveMenu('Wiki_VendorsReport::report_sales_day');
        $title = $this->_view->getPage()->getConfig()->getTitle();
        $title->prepend(__("Reports"));
        $title->prepend(__("Sales by Day of Week"));
        $this->_addBreadcrumb(__("Reports"), __("Reports"))->_addBreadcrumb(__("Sales by Day of Week"), __("Sales by Day of Week"));
        $this->_view->renderLayout();
    }
}
