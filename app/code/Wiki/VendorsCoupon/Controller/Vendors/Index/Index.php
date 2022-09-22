<?php

namespace Wiki\VendorsCoupon\Controller\Vendors\Index;


class Index extends \Wiki\Vendors\Controller\Vendors\Action
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
        $title->prepend(__("Manage Coupons"));
        $this->setActiveMenu('Wiki_VendorsCoupon::coupon');
        $this->_addBreadcrumb(__("List of Coupons"), __("List of Coupons"));
        $this->_view->renderLayout();
    }
}
