<?php

namespace Wiki\VendorsCustomWithdrawal\Controller\Adminhtml\Credit\Withdrawal\Method;

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
        return parent::_isAllowed() && $this->_authorization->isAllowed('Wiki_VendorsCustomWithdrawal::withdrawal_methods');
    }
    

    /**
     * @return void
     */
    public function execute()
    {
        $this->_initAction()->_addBreadcrumb(__('Credit'), __('Credit'))->_addBreadcrumb(__('Withdrawal Methods'), __('Withdrawal Methods'));
        $this->_view->getPage()->getConfig()->getTitle()->prepend(__('Withdrawal Methods'));
        $this->_view->renderLayout();
    }
}
