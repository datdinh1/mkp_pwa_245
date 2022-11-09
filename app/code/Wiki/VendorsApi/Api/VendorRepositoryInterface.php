<?php

namespace Wiki\VendorsApi\Api;

/**
 * Vendor CRUD interface.
 * @api
 */
interface VendorRepositoryInterface
{
    /**
     * Get customer by Customer ID.
     *
     * @param int $customerId
     * @return \Wiki\VendorsApi\Api\Data\VendorInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException If customer with the specified ID does not exist.
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($customerId);
}
