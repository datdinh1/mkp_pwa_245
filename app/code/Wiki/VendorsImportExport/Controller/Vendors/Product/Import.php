<?php

namespace Wiki\VendorsImportExport\Controller\Vendors\Product;

class Import extends \Wiki\Vendors\Controller\Vendors\Action
{

    public function execute()
    {
        $this->_initAction();
        $this->setActiveMenu('Wiki_VendorsImportExport::import_product');
        $title = $this->_view->getPage()->getConfig()->getTitle();
        $title->prepend(__("Import"));
        $title->prepend(__("Import Product"));
        $this->_addBreadcrumb(__("Import"), __("Import"))->_addBreadcrumb(__("Import Product"), __("Import Product"));
        $this->_view->renderLayout();
    }
}
