<?php
/**
 *
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\VendorsCredit\Controller\Adminhtml\Credit\Withdrawal;

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
        return parent::_isAllowed() && $this->_authorization->isAllowed('Wiki_VendorsCredit::credit_all_withdrawal');
    }
    

    /**
     * @return void
     */
    public function execute()
    {
        $this->getRequest()->setParam('status', \Wiki\VendorsCredit\Model\Withdrawal::STATUS_PENDING);
        $this->_initAction()->_addBreadcrumb(__('Credit'), __('Credit'))->_addBreadcrumb(__('Pending Withdrawal Requests'), __('Pending Withdrawal Requests'));
        $this->_view->getPage()->getConfig()->getTitle()->prepend(__('Pending Withdrawal Requests'));
        $this->_view->renderLayout();
    }
}
