<?php

namespace Wiki\VendorsMedia\Controller\Vendors\Image;

class Index extends \Wiki\Vendors\Controller\Vendors\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    protected $_aclResource = 'Wiki_VendorsMedia::media';
    
    /**
     * @return void
     */
    public function execute()
    {
        $this->getRequest()->setParam('vendor_id', $this->_session->getVendor()->getId());
        $this->_initAction();
        $title = $this->_view->getPage()->getConfig()->getTitle();
        $title->prepend(__("Media"));
        $title->prepend(__("Manage Images"));
        $this->setActiveMenu('Wiki_VendorsMedia::media');
        $this->_addBreadcrumb(__("Media"), __("Media"))
            ->_addBreadcrumb(__("Manage Images"), __("Manage Images"));
        $this->_view->renderLayout();
    }
}
