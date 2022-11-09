<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\VendorsCoupon\Observer;

use Magento\Framework\Event\ObserverInterface;
use Wiki\VendorsConfig\Helper\Data;

class UpdateDiscountDescription implements ObserverInterface
{
    /**
     * @var \Wiki\VendorsCoupon\Model\CouponFactory
     */
    protected $_couponFactory;


    public function __construct(
        \Wiki\VendorsCoupon\Model\CouponFactory $couponFactory
    ){
        $this->_couponFactory = $couponFactory;
    }
    
    /**
     * Add multiple vendor order row for each vendor.
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return self
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
                
        $orderDataObj = $observer->getOrderData();
        $quote = $observer->getQuote();
        $vendorId = $observer->getVendorId();
        
        $appliedCoupons = $quote->getData('applied_vendor_coupon_ids');
        if(!$appliedCoupons) return;
        
        $appliedCoupons = explode(",", $appliedCoupons);
        foreach($appliedCoupons as $couponId){
            $coupon = $this->_couponFactory->create()->load($couponId);
            if(!$coupon->getId() || $coupon->getVendorId() != $vendorId) continue;
            
            $orderDataObj->setCouponCode($coupon->getCode());
            $orderDataObj->setDiscountDescription($coupon->getCode());
        }
        return $this;
    }
}
