<?php
/**
 *
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\VendorsCredit\Controller\Adminhtml\Credit\Withdrawal;

use Wiki\Vendors\Controller\Adminhtml\Action;
use Wiki\VendorsCredit\Model\CreditProcessor\CancelWithdrawal;

class Complete extends Action
{
    /**
     * Is access to section allowed
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return parent::_isAllowed() && $this->_authorization->isAllowed('Wiki_VendorsCredit::credit');
    }

    /**
     * @return void
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('withdrawal_id', false);
        $withdrawal = $this->_objectManager->create('Wiki\VendorsCredit\Model\Withdrawal');
        $withdrawal->load($id);
        try {
            if (!$id || !$withdrawal->getId()) {
                $this->messageManager->addError(__("The withdrawal request is not exist."));
                $back = $this->getRequest()->getParam('back', '');
                return $this->_redirect('*/*/'.$back);
            }
            $codeTransfer = $this->getRequest()->getParam('code_of_transfer', false);
            $withdrawal->setCodeOfTransfer($codeTransfer);
            $withdrawal->markAsComplete();
            
            /*Send complete withdrawal request notification email*/
            $vendor = $this->_objectManager->create('Wiki\Vendors\Model\Vendor');
            $vendor->load($withdrawal->getVendorId());
            $vendorCreditHelper = $this->_objectManager->create('Wiki\VendorsCredit\Helper\Data');
            $vendorCreditHelper->sendWithdrawalCompletedNotification($withdrawal, $vendor);
            
            $this->messageManager->addSuccess(__("The withdrawal request has been completed."));
        } catch (\Exception $e) {
            $this->messageManager->addError($e->getMessage());
        }
        return $this->_redirect('*/*/');
    }
}
