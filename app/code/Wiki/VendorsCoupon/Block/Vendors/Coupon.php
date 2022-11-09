<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

// @codingStandardsIgnoreFile

namespace Wiki\VendorsCoupon\Block\Vendors;
/**
 * Vendor Notifications block
 */

class Coupon extends \Wiki\Vendors\Block\Vendors\AbstractBlock
{   
    protected $_salesRuleManagement;
    public $session;
    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Wiki\Vendors\Model\UrlInterface $url
     * @param \Wiki\Vendors\Helper\Data $vendorHelper
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Wiki\Vendors\Model\UrlInterface $url,
        \Wiki\VendorsSalesRule\Model\SalesRuleManagement $salesRuleManagement,
        \Wiki\Vendors\Model\Session $session,
        array $data = []
    ) {
        $this->_salesRuleManagement = $salesRuleManagement;
        $this->session = $session;
        parent::__construct($context, $url, $data);
    }
    public function getAddUrl()
    {
        return $this->getUrl('*/*/add');
    }
    public function getListCoupons(){
        return $this->_salesRuleManagement->getListCouponByVendorId($this->session->getVendor()->getId());
    }
    public function getDeleteUrl($id)
    {
        return $this->getUrl('*/*/delete', ['id' => $id]);
    }
    public function getEditUrl($id)
    {
        return $this->getUrl('*/*/edit/id', ['id' => $id]);
    }
}
