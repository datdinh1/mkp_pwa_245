<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\StoreApi\Model\Rule;

use Magento\SalesRule\Model\Utility;
use Magento\SalesRule\Model\ResourceModel\Rule\CollectionFactory;
use Wiki\StoreApi\Model\Api\Data\CouponFactory;
use Wiki\VendorsCoupon\Model\Api\CouponFactory as CouponApiFactory;
use Wiki\VendorsCoupon\Model\CouponManagement;
class CouponCollection
{
    protected $couponManagement;
    /**
     * @var CouponApiFactory
     */
    protected $couponApiFactory;

    /**
     * @var Utility
     */
    protected $utility;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var CouponFactory
     */
    protected $couponFactory;

    /**
     * @param Utility $utility
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        CouponApiFactory            $couponApiFactory,
        Utility                     $utility,
        CouponFactory               $couponFactory,
        CollectionFactory           $collectionFactory,
        CouponManagement $couponManagement
    ) {
        $this->couponApiFactory     = $couponApiFactory;
        $this->utility              = $utility;
        $this->couponFactory        = $couponFactory;
        $this->collectionFactory    = $collectionFactory;
        $this->couponManagement     = $couponManagement;
    }

    public function getRulesCollection()
    {
        return $this->collectionFactory->create()
                    ->addFieldToFilter('is_active', 1)
                    ->addFieldToFilter('coupon_type', 2)
                    ->addFieldToFilter('to_date', ['gteq' => date('Y-m-d')])
                    ->addFieldToFilter('is_visible_in_listing', 1);
    }

    public function getAllCoupon()
    {
        $rules = $this->getRulesCollection();
        foreach ( $rules as $rule ){
            $data[] = $this->setCoupon($rule);
        }
        return isset($data) ? $data : [];
    }

    public function getAllCouponShip()
    {
        $rules = $this->getRulesCollection();
        $rules->addFieldToFilter('apply_to_shipping', 1);
        foreach ( $rules as $rule ){
            $data = $this->couponApiFactory->create();
            $data->setData($rule->getData());
            $flag = false;
            if ($rule->getCouponBySeller() == "MARKETPLACE_SELLER" ) {
                $sellerId = "MKP";
                $flag = $this->couponManagement->getVendorIdByMKPSeller($sellerId, $rule);
            } else if( $rule->getCouponBySeller() != "MARKETPLACE_CODE"){
                $flag = $rule->getCouponBySeller();
            }
            if ($flag != false) {
                $info = $this->couponManagement->setVendorOfCoupon($flag, $rule);
                $data->setVendor($info);
            }

            $dataRule[] = $data;
        }
        return isset($dataRule) ? $dataRule : [];
       // return isset($rules) ? $rules : [];
    }

    public function getValidCouponList($quote)
    {
        $websiteId = $quote->getStore()->getWebsiteId();
        $customerGroupId = $quote->getCustomerGroupId();
        $address   = $quote->getShippingAddress();
        $items     = $quote->getAllVisibleItems();
        $rules     = $this->getRulesCollection()->addWebsiteGroupDateFilter($websiteId, $customerGroupId);

        foreach ( $rules as $rule ){
            $validate    = $this->utility->canProcessRule($rule, $address);
            $validAction = false;

            foreach ( $items as $item ){
                if ( $validAction = $rule->getActions()->validate($item) ){
                    break;
                }
            }

            if ( $validate && $validAction ){
                $data[] = $this->setCoupon($rule);
            }
        }
        return isset($data) ? $data : [];
    }

    protected function setCoupon($rule)
    {
        $coupon = $this->couponFactory->create();
        $coupon->setCouponName($rule->getName());
        $coupon->setCouponCode($rule->getCode());
        $coupon->setDescription($rule->getDescription());
        $coupon->setToDate(empty($rule->getToDate()) ? '' : $rule->getToDate());
        return $coupon;
    }
}
