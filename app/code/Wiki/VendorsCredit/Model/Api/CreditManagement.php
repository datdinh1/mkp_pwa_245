<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Wiki\VendorsCredit\Model\Api;


use Magento\Customer\Api\AccountManagementInterface;
use Magento\Framework\Exception\AuthenticationException;
use Magento\Framework\Exception\LocalizedException;

use Magento\Framework\Registry;

use Magento\Framework\App\ObjectManager;
use Wiki\VendorsCredit\Api\CreditManagementInterface;
use Wiki\VendorsCredit\Api\Data\CreditInterface;

// use Wiki\VendorsCredit\Model\Api\Data\CreditFactory ;
/**
 * Handle various customer account actions
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @SuppressWarnings(PHPMD.TooManyFields)
 * @SuppressWarnings(PHPMD.ExcessiveClassComplexity)
 * @SuppressWarnings(PHPMD.CookieAndSessionMisuse)
 */
class CreditManagement implements CreditManagementInterface
{
    protected $creditFactory;
  

    // public function __construct(
    //    CreditFactory $creditFactory
 
    // ) {
    //     $this->creditFactory = $creditFactory;
    // }
 
    
    /**
     * @inheritDoc
     */
    public function saveCredit($entity)
    {
        if ( empty($entity->getCardNumber()) || empty($entity->getNameOnCard()) || empty($entity->getExpirationDate())
            || empty($entity->getCvv()) || empty($entity->getCustomerId()) )
            {
                return false;
            }
        return $entity->save();
    }

    /**
     * @inheritDoc
     */
    public function saveDebit($entity)
    {
        if ( empty($entity->getFullName()) || empty($entity->getAccountNumber()) || empty($entity->getBankName()) || empty($entity->getCustomerId()) ){
            return false;
        }
        return $entity->save();
    }

}
