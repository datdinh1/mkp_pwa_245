<?php

namespace Wiki\VendorsImportExport\Controller\Vendors\Product;

class Export extends \Wiki\Vendors\Controller\Vendors\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    protected $_aclResource = 'Wiki_VendorsImportExport::export_product';
    /**
     * @return void
     */
    public function execute()
    {
        $this->_initAction();
        $this->setActiveMenu('Wiki_VendorsImportExport::export_product');
        $title = $this->_view->getPage()->getConfig()->getTitle();
        $title->prepend(__("Export"));
        $title->prepend(__("Export Product"));
        $this->_addBreadcrumb(__("Export"), __("Export"))->_addBreadcrumb(__("Export Product"), __("Export Product"));
        $this->_view->renderLayout();
    }
}
