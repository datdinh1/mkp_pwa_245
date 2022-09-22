<?php
/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Wiki\Vendors\Api;

use Magento\Framework\Exception\InputException;

/**
 * Interface for managing customers accounts.
 * @api
 * @since 100.0.2
 */
interface SellerAddressInterface
{
    /**
     * @param int $sellerId
     * @return \Magento\Customer\Api\Data\AddressInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getDefaultMainAddress($sellerId);

    /**
     * @param int $sellerId
     * @return \Magento\Customer\Api\Data\AddressInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getDefaultShippingAddress($sellerId);

    /**
     * @param int $sellerId
     * @return \Magento\Customer\Api\Data\AddressInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getDefaultReturnAddress($sellerId);

    /**
     * Save Seller address.
     *
     * @param \Wiki\Vendors\Api\Data\AddressInterface $address
     * @return \Magento\Customer\Api\Data\AddressInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function saveAddress($address);

    /**
     * Save Seller default address.
     *
     * @param int $sellerId
     * @param int|null $mainAddress
     * @param int|null $shippingAddress
     * @param int|null $returnAddress
     * @return bool
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function saveDefaultAddress($sellerId, $mainAddress = null, $shippingAddress = null, $returnAddress = null);

    /**
     * Update Seller address.
     *
     * @param int $addressId
     * @param \Wiki\Vendors\Api\Data\AddressInterface $address
     * @return \Magento\Customer\Api\Data\AddressInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function updateAddress($addressId, $address);

    /**
     * Delete Seller address.
     *
     * @param int $addressId
     * @return bool
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteAddress($addressId);
}
