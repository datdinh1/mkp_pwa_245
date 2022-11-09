<?php
/**
 *
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\VendorsCustomTheme\Controller\Adminhtml\Theme;

use Wiki\VendorsCustomTheme\Controller\Adminhtml\Action;

class Index extends Action
{
    /**
     * @return void
     */
    public function execute()
    {
        $this->_initAction()->_addBreadcrumb(__('Sellers'), __('Sellers'))->_addBreadcrumb(__('Manage Theme'), __('Manage Theme'));
        $this->_view->getPage()->getConfig()->getTitle()->prepend(__('Manage Theme'));
        $this->_view->renderLayout();
    }
}
