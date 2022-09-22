<?php
/**
 * Copyright © Wiki. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\VendorsSales\Block\Vendors\Order\Creditmemo\View;

/**
 * Invoice view form
 */
class Form extends \Magento\Sales\Block\Adminhtml\Order\Creditmemo\View\Form
{
    /**
     * Get vendor order
     * @return \Wiki\VendorsSales\Model\Order
     */
    public function getVendorOrder()
    {
        return $this->_coreRegistry->registry('vendor_order');
    }

    /**
     * Get price data object
     *
     * @return \Wiki\VendorsSales\Model\Order|mixed
     */
    public function getPriceDataObject()
    {
        $obj = $this->getData('price_data_object');
        if ($obj === null) {
            return $this->getVendorOrder();
        }
        return $obj;
    }
}
