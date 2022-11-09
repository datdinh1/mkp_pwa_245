<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

// @codingStandardsIgnoreFile

namespace Wiki\VendorsCoupon\Block\Cart\Coupon;

/**
 * Vendor Notifications block
 */
class Detail extends \Magento\Checkout\Block\Cart\Coupon
{
    /**
     * @var \Wiki\VendorsCoupon\Helper\Data
     */
    protected $_couponHelper;
    
    /**
     * 
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Checkout\Model\Session $checkoutSession
     * @param \Wiki\Vendors\Helper\Data $vendorHelper
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Wiki\VendorsCoupon\Helper\Data $couponHelper,
        array $data = []
    ) {
        parent::__construct($context, $customerSession, $checkoutSession, $data);
        $this->_couponHelper = $couponHelper;
    }
    
    /**
     * Get vendor store name
     * 
     * @param int $vendorId
     * @return boolean
     */
    public function getVendorStoreName($vendorId){
        return $this->_couponHelper->getVendorStoreName($vendorId);
    }
    
    /**
     * Can show store name
     * 
     * @return boolean
     */
    public function canShowStoreName(){
        return $this->_couponHelper->canShowStoreName();
    }
}
