<?php
/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Wiki\VendorsSubAccount\Api;

use Magento\Framework\Exception\InputException;

/**
 * Interface for managing customers accounts.
 * @api
 * @since 100.0.2
 */
interface SubAccountManagementInterface
{
    /**
     * @param string $vendorId
     * @return \Wiki\VendorsSubAccount\Api\SubAccountManagementInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getAllSubAccount($vendorId);

    /**
     * @param string $vendorId
     * @return \Wiki\VendorsSubAccount\Api\SubAccountManagementInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getRoleData($vendorId);

    /**
     * @param string $customerID
     * @param mixed $customerSub
     * @param string $password
     * @param string $roleId
     * @return \Wiki\VendorsSubAccount\Api\SubAccountManagementInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function createSubAccount($customerID , $customerSub, $password , $roleId);

}
