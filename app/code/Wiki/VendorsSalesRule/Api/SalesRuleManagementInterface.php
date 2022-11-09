<?php

/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Wiki\VendorsSalesRule\Api;

use Magento\Framework\Exception\InputException;

/**
 * Interface for managing customers accounts.
 * @api
 * @since 100.0.2
 */
interface SalesRuleManagementInterface
{

    /**
     * Performs persist operations for a specified order.
     *
     * @param \Wiki\VendorsSalesRule\Api\Data\RuleInterface $rule
     * 
     * @return boolean
     * @throws \Magento\Framework\Exception\InputException If there is a problem with the input
     * @throws \Magento\Framework\Exception\NoSuchEntityException If a rule ID is sent but the rule does not exist
     * @throws \Magento\Framework\Exception\LocalizedException 
     */
    public function createCouponSalesRule($rule);

    /**
     * @param int $id
     * @param \Wiki\VendorsSalesRule\Api\Data\RuleInterface $rule
     * @return boolean
     */
    public function updateCouponSalesRule($id, $rule);

    /**
     * @param int $id
     * @return boolean
     */
    public function deleteCouponSalesRule($id);

    /**
     * @param int $id
     * @return \Wiki\VendorsCoupon\Api\Data\CouponInterface|null
     */
    public function getCouponSalesRule($id);

    /**
     * Performs persist operations for a specified order.
     *
     * @param string $code 
     * @param int $customer_id 
     * @return boolean
     * @throws \Magento\Framework\Exception\InputException If there is a problem with the input
     * @throws \Magento\Framework\Exception\NoSuchEntityException If a rule ID is sent but the rule does not exist
     * @throws \Magento\Framework\Exception\LocalizedException 
     */
    public function collectCouponSalesRule($code, $customer_id);


    /**
     * Performs persist operations for a specified order.
     *
     * @param int $customerId
     * @return \Wiki\VendorsCoupon\Api\Data\CouponInterface[]
     * @throws \Magento\Framework\Exception\InputException If there is a problem with the input
     * @throws \Magento\Framework\Exception\NoSuchEntityException If a rule ID is sent but the rule does not exist
     * @throws \Magento\Framework\Exception\LocalizedException 
     */
    public function getCollectCouponByUser($customerId);

    /**
     * @param int $customerId
     * @param int $ruleId
     * @return boolean
     */
    public function removeCollectCouponByUser($customerId, $ruleId);

    /**
     * Performs persist operations for a specified order.
     *
     * @param string $couponCode
     * 
     * @return bool
     *   * @throws \Magento\Framework\Exception\InputException If there is a problem with the input
     * @throws \Magento\Framework\Exception\NoSuchEntityException If a rule ID is sent but the rule does not exist
     * @throws \Magento\Framework\Exception\LocalizedException 
     */
    public function checkCouponCode($couponCode);

    /**
     *
     * @param string $vendorID
     * 
     * @return \Wiki\VendorsSalesRule\Api\SalesRuleManagementInterface
     * @throws \Magento\Framework\Exception\LocalizedException 
     */
    public function getAllPromotionByVendorId($vendorID);

    /**
     *
     * @param string $vendorID
     * @param string $statusTime
     * @return \Wiki\VendorsSalesRule\Api\SalesRuleManagementInterface
     * @throws \Magento\Framework\Exception\LocalizedException 
     */
    public function getPromotionRunningByVendorId($vendorID, $statusTime);



    /**
     * @param mixed $data
     * @return \Wiki\Vendors\Api\SellerManagementInterface
     * @throws \Magento\Framework\Exception\LocalizedException 
     */
    public function createPromotion($data);


    /**
     * @param int $ruleId
     * @return bool
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     * 
     */
    public function deleteById($ruleId);

    /**
     * @param int $customerId
     * @return \Wiki\VendorsCoupon\Api\Data\CouponInterface[]
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getListCouponRecommend($customerId = null);

    /**
     * @param int $customerId
     * @return \Wiki\VendorsCoupon\Api\Data\CouponInterface[]
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getListCouponAllpage($customerId = null);

    /**
     * @param string $vendorId
     * @param string|null $status
     * @param int|null $pageSize
     * @param int|null $currentPage
     * @return \Wiki\VendorsCoupon\Api\Data\ItemsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getListCouponByVendorId($vendorId, $status = null, $pageSize = null, $currentPage = null);

    
     /**
     * @param int $customerId
     * @param string|null $categoryId
     * @param int|null $pageSize
     * @param int|null $currentPage
     * @return \Wiki\VendorsCoupon\Api\Data\ItemsInterface[]
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getCouponsByCategory($customerId, $categoryId = null, $pageSize = null, $currentPage = null);

}
