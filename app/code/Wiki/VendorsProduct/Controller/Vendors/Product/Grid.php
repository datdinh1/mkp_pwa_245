<?php

namespace Wiki\VendorsProduct\Controller\Vendors\Product;

class Grid extends \Wiki\Vendors\Controller\Vendors\Action
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
        $this->_view->loadLayout();
        return $this->getResponse()->setBody($this->_view->getLayout()->getBlock('vendor.products.grid')->toHtml());
    }
}
