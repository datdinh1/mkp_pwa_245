<?php

namespace Wiki\VendorsProfile\Controller\Vendors\Address;

class Index extends \Wiki\Vendors\Controller\Vendors\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    protected $_aclResource = 'Wiki_VendorsProfile::address';

    /**
     * @return void
     */
    public function execute()
    {
        $this->getRequest()->setParam('vendor_id', $this->_session->getVendor()->getId());
        $this->_initAction();
        $title = $this->_view->getPage()->getConfig()->getTitle();
        $title->prepend(__("Profile"));
        $title->prepend(__("Address"));
        $this->setActiveMenu('Wiki_VendorsProfile::address');
        $this->_addBreadcrumb(__("Profile"), __("Profile"))
            ->_addBreadcrumb(__("Address"), __("Address"));
        $this->_view->renderLayout();
    }
}
