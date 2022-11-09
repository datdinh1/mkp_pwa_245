<?php

/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Wiki\VendorsReport\Api;

use Magento\Framework\Exception\InputException;

/**
 * Interface for managing customers accounts.
 * @api
 * @since 100.0.2
 */
interface ProductSellerManagementInterface
{
    /**
     * @param string $namestore
     * @param int $month
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getConversionRateByMonth($namestore, $month);
}
