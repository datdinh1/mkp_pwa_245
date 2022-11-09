<?php
/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Wiki\VendorsCredit\Api;

use Magento\Framework\Exception\InputException;
use Wiki\VendorsCredit\Api\Data\CreditInterface;

interface CreditManagementInterface
{
     /**
     * @param \Wiki\VendorsCredit\Api\Data\CreditInterface $entity
     * @return \Wiki\VendorsCredit\Api\Data\CreditInterface 
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function saveCredit($entity);

    /**
     * @param \Wiki\VendorsCredit\Api\Data\DebitInterface $entity
     * @return \Wiki\VendorsCredit\Api\Data\DebitInterface 
     */
    public function saveDebit($entity);

}
