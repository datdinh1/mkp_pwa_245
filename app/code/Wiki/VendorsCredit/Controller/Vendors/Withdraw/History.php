<?php

namespace Wiki\VendorsCredit\Controller\Vendors\Withdraw;

class History extends \Wiki\Vendors\Controller\Vendors\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    protected $_aclResource = 'Wiki_VendorsCredit::credit_withdrawal_history';
    
    /**
     * @return void
     */
    public function execute()
    {
        $this->getRequest()->setParam('vendor_id', $this->_session->getVendor()->getId());
        $this->_initAction();
        $title = $this->_view->getPage()->getConfig()->getTitle();
        $title->prepend(__("Credit"));
        $title->prepend(__("Withdrawal History"));
        $this->_view->renderLayout();
    }
}
