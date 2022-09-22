<?php
/**
 * Copyright © Wiki. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\VendorsSales\Block\Vendors\Order\Shipment\Create;

/**
 * Adminhtml shipment create form
 */
class Form extends \Magento\Shipping\Block\Adminhtml\Create\Form
{
    /**
     * @return \Wiki\VendorsSales\Model\Order
     */
    public function getVendorOrder()
    {
        return $this->_coreRegistry->registry('vendor_order');
    }
    
    /**
     * @return \Magento\Framework\View\Element\AbstractBlock
     */
    protected function _prepareLayout()
    {
        $this->addChild('items', 'Magento\Shipping\Block\Adminhtml\Create\Items');
        return \Magento\Sales\Block\Adminhtml\Order\AbstractOrder::_prepareLayout();
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
    
    /**
     * @return string
     */
    public function getSaveUrl()
    {
        return $this->getUrl('*/*/save', ['order_id' => $this->getVendorOrder()->getId()]);
    }
}
