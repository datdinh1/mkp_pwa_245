<?php
/**
 * Copyright © Wiki. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\VendorsSales\Block\Vendors\Order\Shipment\Create;

/**
 * Adminhtml shipment items grid
 */
class Items extends \Magento\Shipping\Block\Adminhtml\Create\Items
{
    /**
     * @return \Wiki\VendorsSales\Model\Order
     */
    public function getVendorOrder()
    {
        return $this->_coreRegistry->registry('vendor_order');
    }

        /**
         * Checks the possibility of creating shipping label by current carrier
         *
         * @return bool
         */
    public function canCreateShippingLabel()
    {
        $shippingCarrier = $this->_carrierFactory->create(
            $this->getVendorOrder()->getShippingMethod(true)->getCarrierCode()
        );
        return $shippingCarrier && $shippingCarrier->isShippingLabelsAvailable();
    }
}
