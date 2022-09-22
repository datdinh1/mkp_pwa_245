<?php

namespace Wiki\VendorsReport\Controller\Vendors\Product;

class Ordered extends \Wiki\Vendors\Controller\Vendors\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    protected $_aclResource = 'Wiki_VendorsReport::report_products_ordered';
    /**
     * @return void
     */
    public function execute()
    {
        $this->_initAction();
        $this->setActiveMenu('Wiki_VendorsReport::report_products_ordered');
        $title = $this->_view->getPage()->getConfig()->getTitle();
        $title->prepend(__("Reports"));
        $title->prepend(__("Ordered Products Report"));
        $this->_addBreadcrumb(__("Reports"), __("Reports"))->_addBreadcrumb(__("Ordered Products Report"), __("Ordered Products Report"));
        $this->_view->renderLayout();
    }
}
