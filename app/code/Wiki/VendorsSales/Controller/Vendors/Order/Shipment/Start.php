<?php

namespace Wiki\VendorsSales\Controller\Vendors\Order\Shipment;

class Start extends \Wiki\Vendors\App\AbstractAction
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    protected $_aclResource = 'Wiki_VendorsSales::sales_order_action_ship';
    
    /**
     * Start create shipment action
     *
     * @return void
     */
    public function execute()
    {
        /**
         * Clear old values for shipment qty's
         */
        $this->_redirect('*/*/new', ['order_id' => $this->getRequest()->getParam('order_id')]);
    }
}
