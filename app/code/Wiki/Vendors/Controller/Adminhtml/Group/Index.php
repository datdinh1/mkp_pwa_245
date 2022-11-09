<?php
/**
 *
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\Vendors\Controller\Adminhtml\Group;

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
        return $this->_authorization->isAllowed('Wiki_Vendors::vendors_groups') && parent::_isAllowed();
    }
    
    /**
     * @return void
     */
    public function execute()
    {
        $this->_initAction()->_addBreadcrumb(__('Sellers'), __('Sellers'))->_addBreadcrumb(__('Manage Groups'), __('Manage Groups'));
        $this->_view->getPage()->getConfig()->getTitle()->prepend(__('Manage Groups'));
        $this->_view->renderLayout();
    }
}
