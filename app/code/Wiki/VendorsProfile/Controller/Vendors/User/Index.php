<?php

namespace Wiki\VendorsProfile\Controller\Vendors\User;

class Index extends \Wiki\Vendors\Controller\Vendors\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    protected $_aclResource = 'Wiki_VendorsProfile::edit_profile';

    /**
     * @return void
     */
    public function execute()
    {
        $this->getRequest()->setParam('vendor_id', $this->_session->getVendor()->getId());
        $this->_initAction();
        $title = $this->_view->getPage()->getConfig()->getTitle();
        $title->prepend(__("Profile"));
        $title->prepend(__("Edit Profile"));
        $this->setActiveMenu('Wiki_VendorsProfile::edit_profile');
        $this->_addBreadcrumb(__("Profile"), __("Profile"))
            ->_addBreadcrumb(__("Edit Profile"), __("Edit Profile"));
        $this->_view->renderLayout();
    }
}
