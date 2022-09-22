<?php

namespace Wiki\VendorsCoupon\Controller\Vendors\Index;

class Add extends \Wiki\Vendors\Controller\Vendors\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    protected $_aclResource = 'Wiki_VendorsCoupon::coupon';
    
    /**
     * @return void
     */
    public function execute()
    {
        
        $this->_initAction();
        $title = $this->_view->getPage()->getConfig()->getTitle();
        $title->prepend(__("Add New Coupons"));
        $this->_view->renderLayout();

    }
}
