<?php
/**
 *
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\VendorsCredit\Controller\Adminhtml\Credit\Escrow;

use Wiki\Vendors\Controller\Adminhtml\Action;

class Cancel extends Action
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
        $id = $this->getRequest()->getParam('id', false);
        $escrow = $this->_objectManager->create('Wiki\VendorsCredit\Model\Escrow');
        $escrow->load($id);
        if (!$id || !$escrow->getId()) {
            $this->messageManager->addError(__("The pending transaction is not exist."));
            return $this->_redirect('vendors/credit/pending');
        }
        
        try {
            $escrow->cancel();
            $this->messageManager->addSuccess(__("The pending credit is canceled."));
            return $this->_redirect('vendors/credit_escrow/view', ['id' => $id]);
        } catch (\Exception $e) {
            $this->messageManager->addError($e->getMessage());
        }
        return $this->_redirect('vendors/credit/pending');
    }
}
