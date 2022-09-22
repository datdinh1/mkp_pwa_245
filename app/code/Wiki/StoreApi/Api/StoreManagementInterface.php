<?php 
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\StoreApi\Api;
 
interface StoreManagementInterface 
{
    /**
     * @api
     * @param int $customerId
     * @param \Wiki\StoreApi\Api\Data\SettingInterface[] $settings
     * @return bool
     * @throws \Exception
     */
    public function saveSetting($customerId, $settings = []);

    /**
     * @return \Wiki\StoreApi\Api\Data\ShippingMethodInterface[]
     */
    public function getShippingMethods();
}
