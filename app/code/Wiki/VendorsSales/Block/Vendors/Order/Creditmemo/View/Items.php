<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\VendorsSales\Block\Vendors\Order\Creditmemo\View;

/**
 * Adminhtml sales item renderer
 */
class Items extends \Magento\Sales\Block\Adminhtml\Order\Creditmemo\View\Items
{
    /**
     * Get vendor order
     * @return \Wiki\VendorsSales\Model\Order
     */
    public function getVendorOrder()
    {
        return $this->_coreRegistry->registry('vendor_order');
    }
}
