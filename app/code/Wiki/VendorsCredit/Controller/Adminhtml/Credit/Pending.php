<?php
/**
 *
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\VendorsCredit\Controller\Adminhtml\Credit;

use Wiki\Vendors\Controller\Adminhtml\Action;

class Pending extends Action
{
    /**
     * Is access to section allowed
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return parent::_isAllowed() && $this->_authorization->isAllowed('Wiki_VendorsCredit::credit_pending');
    }
    

    /**
     * @return void
     */
    public function execute()
    {
        $this->getRequest()->setParam('status', \Wiki\VendorsCredit\Model\Withdrawal::STATUS_PENDING);
        $this->_initAction()->_addBreadcrumb(__('Credit'), __('Credit'))->_addBreadcrumb(__('Escrow Transactions'), __('Escrow Transactions'));
        $this->_view->getPage()->getConfig()->getTitle()->prepend(__('Escrow Transactions'));
        $this->_view->renderLayout();
    }
}
