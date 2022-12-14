<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\VendorsSales\Block\Vendors\Order\Invoice\View;

/**
 * Adminhtml sales item renderer
 */
class Items extends \Magento\Sales\Block\Adminhtml\Order\Invoice\View\Items
{
    /**
     * Get vendor invoice
     * @return \Wiki\VendorsSales\Model\Order\Invoice
     */
    public function getVendorInvoice()
    {
        return $this->_coreRegistry->registry('vendor_invoice');
    }
}
