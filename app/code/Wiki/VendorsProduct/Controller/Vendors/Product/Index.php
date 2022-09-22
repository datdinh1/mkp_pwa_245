<?php

namespace Wiki\VendorsProduct\Controller\Vendors\Product;

class Index extends \Wiki\Vendors\Controller\Vendors\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    protected $_aclResource = 'Wiki_Vendors::catalog_product';
    
    /**
     * @return void
     */
    public function execute()
    {
        $this->_initAction();
        $title = $this->_view->getPage()->getConfig()->getTitle();
        $this->setActiveMenu('Wiki_Vendors::catalog_product');
        $title->prepend(__("Catalog"));
        $title->prepend(__("Manage Products"));
        
        $this->_addBreadcrumb(__("Catalog"), __("Catalog"))->_addBreadcrumb(__("Manage Products"), __("Manage Products"));
        $this->_view->renderLayout();
    }
}
