<?php
/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Wiki\VendorsCommission\Api;

use Magento\Framework\Exception\InputException;

/**
 * Interface for managing customers accounts.
 * @api
 * @since 100.0.2
 */
interface CommissionManagementInterface
{
    /**
     * @return \Wiki\VendorsCommission\Api\CommissionManagementInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getAllCommissionRule();

    /**
     * @param string $orderId
     * @return \Wiki\VendorsCommission\Api\CommissionManagementInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function applyCommission($orderId);

}
