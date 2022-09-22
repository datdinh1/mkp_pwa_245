<?php
/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\VendorsApi\Api;

/**
 * Interface ProductOptionTypeListInterface
 * @api
 * @since 100.0.2
 */
interface VendorProductOptionTypeListInterface
{
    /**
     * Get all types for options for bundle products
     *
     * @return \Magento\Bundle\Api\Data\OptionTypeInterface[]
     */
    public function getItems();
}