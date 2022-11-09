<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Wiki\VendorsSales\Model\Api\Data;

/**
 * Softprodigy Dailydeal date model
 */
class AccountPageSale extends \Magento\Framework\Api\AbstractExtensibleObject implements \Wiki\VendorsSales\Api\Data\AccountPageSaleInterface
{

    /**
     * Get order
     *
     * @return \Magento\Sales\Api\Data\OrderInterface
     */
    public function getOrder()
    {
        return $this->_get(self::ORDER);
    }

    /**
     * Set order 
     *
     * @param \Magento\Sales\Api\Data\OrderInterface $order
     * @return $this
     */
    public function setOrder($order)
    {
        return $this->setData(self::ORDER, $order);
    }

  
    /**
     *
     * @return \Wiki\Vendors\Api\SellerManagementInterface
     */
    public function getVendor()
    {
        return $this->_get(self::VENDOR);
    }

    /**

     *
     * @param \Wiki\Vendors\Api\SellerManagementInterface $vendor
     * @return $this
     */
    public function setVendor($vendor)
    {
        return $this->setData(self::VENDOR, $vendor);
    }
}
