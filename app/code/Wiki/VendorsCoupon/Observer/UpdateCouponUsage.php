<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\VendorsCoupon\Observer;

use Magento\Framework\Event\ObserverInterface;
use Wiki\VendorsConfig\Helper\Data;

class UpdateCouponUsage implements ObserverInterface
{
    /**
     * @var \Wiki\VendorsCoupon\Model\CouponFactory
     */
    protected $_couponFactory;
    
    /**
     * @var \Wiki\Vendors\Helper\Data
     */
    protected $_vendorHelper;

    public function __construct(
        \Wiki\Vendors\Helper\Data $vendorHelper,
        \Wiki\VendorsCoupon\Model\CouponFactory $couponFactory
    ){
        $this->_vendorHelper = $vendorHelper;
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
        /* Do nothing if the extension is not enabled.*/
        if(!$this->_vendorHelper->moduleEnabled()) return;
        
        $order = $observer->getOrder();
        $quote = $observer->getQuote();
        
        $appliedCoupons = $quote->getData('applied_vendor_coupon_ids');
        if(!$appliedCoupons) return;
        
        $appliedCoupons = explode(",", $appliedCoupons);
        foreach($appliedCoupons as $couponId){
            $coupon = $this->_couponFactory->create()->load($couponId);
            if(!$coupon->getId()) continue;
            
            $coupon->setTimesUsed($coupon->getTimesUsed() + 1)->save();
        }
        return $this;
    }
}
