<?php

namespace Wiki\VendorsCredit\Controller\Vendors\Transactions;

class Index extends \Wiki\Vendors\Controller\Vendors\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    protected $_aclResource = 'Wiki_VendorsCredit::sales_transactions';
    
    /**
     * @return void
     */
    public function execute()
    {
        $this->getRequest()->setParam('customer_id', $this->_session->getCustomerId());
        $this->_initAction();
        $this->_setActiveMenu('Wiki_VendorsCredit::sales_transactions')
            ->_addBreadcrumb(__('Sales'), __('Sales'))
            ->_addBreadcrumb(__('Credit Transactions'), __('Credit Transactions'));
        $title = $this->_view->getPage()->getConfig()->getTitle();
        $title->prepend(__("Sales"));
        $title->prepend(__("Transactions"));
        $this->_view->renderLayout();
    }
}
