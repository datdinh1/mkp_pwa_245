<?php

namespace Wiki\VendorsSales\Controller\Vendors\Order\Creditmemo;

class Start extends \Wiki\Vendors\App\AbstractAction
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    protected $_aclResource = 'Wiki_VendorsSales::sales_order_action_creditmemo';
    
    /**
     * Start create creditmemo action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        /**
         * Clear old values for creditmemo qty's
         */
        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('*/*/new', ['_current' => true]);
        return $resultRedirect;
    }
}
