<?php
/**
 *
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\Core\Controller\Adminhtml\Licenses;

use Wiki\Core\Controller\Adminhtml\Action;

class Index extends Action
{
    /**
     * @return void
     */
    public function execute()
    {
        $this->_initAction()->_addBreadcrumb(__('Manage Licenses'), __('Manage Licenses'));
        $this->_view->getPage()->getConfig()->getTitle()->prepend(__('Manage Licenses'));
        $this->_view->renderLayout();
    }
}
