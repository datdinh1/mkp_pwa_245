<?php
/**
 *
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\Vendors\Controller\Vendors\Account;

class Index extends \Wiki\Vendors\Controller\Vendors\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    protected $_aclResource = 'Wiki_Vendors::account';
    
    /**
     * @return void
     */
    public function execute()
    {
        $this->_initAction();
        $this->_view->getPage()->getConfig()->getTitle()->prepend(__("Account"));
        $this->_addBreadcrumb(__("Account"), __("Account"));
        $vendor = $this->_session->getVendor();
        $this->_coreRegistry->register('current_vendor', $vendor);
        $this->_view->renderLayout();
    }
}
