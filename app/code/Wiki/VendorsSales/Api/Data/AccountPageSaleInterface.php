<?php

/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Wiki\VendorsSales\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

/**
 * Customer group interface.
 * @api
 */
interface AccountPageSaleInterface
{

    const ORDER       = 'order';
    const VENDOR      = 'vendor';
    /**
     * Get order
     *
     * @return \Magento\Sales\Api\Data\OrderInterface
     */
    public function getOrder();

    /**
     * Set order
     *
     * @param  \Magento\Sales\Api\Data\OrderInterface $order
     * @return $this
     */
    public function setOrder($order);


    /**
     * 
     * @return  \Wiki\Vendors\Api\SellerManagementInterface
     */
    public function getVendor();

    /**
     * 
     * @param  \Wiki\Vendors\Api\SellerManagementInterface $vendor
     * @return $this
     */
    public function setVendor($vendor);
}
