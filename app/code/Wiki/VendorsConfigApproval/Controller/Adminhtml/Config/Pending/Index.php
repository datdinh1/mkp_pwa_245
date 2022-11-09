<?php

namespace Wiki\VendorsConfigApproval\Controller\Adminhtml\Config\Pending;

use Wiki\Vendors\Controller\Adminhtml\Action;

class Index extends Action
{
    /**
     * Is access to section allowed
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return parent::_isAllowed() && $this->_authorization->isAllowed('Wiki_VendorsConfigApproval::pending_config');
    }
    

    /**
     * @return void
     */
    public function execute()
    {
        $this->_initAction()->_addBreadcrumb(__('Sellers'), __('Sellers'))->_addBreadcrumb(__('Manage Pending Configurations'), __('Manage Pending Configurations'));
        $this->_view->getPage()->getConfig()->getTitle()->prepend(__('Manage Pending Configurations'));
        $this->_view->renderLayout();
    }
}
