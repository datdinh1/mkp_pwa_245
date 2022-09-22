<?php
/**
 *
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\Credit\Controller\Adminhtml\Account;

use Wiki\Credit\Controller\Adminhtml\Action;

class Index extends Action
{

    /**
     * @return void
     */
    public function execute()
    {
        $this->_initAction()->_addBreadcrumb(__('Manage Credit Accounts'), __('Manage Credit Accounts'));
        $this->_view->getPage()->getConfig()->getTitle()->prepend(__('Manage Credit Accounts'));
        $this->_view->renderLayout();
    }
}
