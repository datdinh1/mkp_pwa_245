<?php

namespace Wiki\VendorsSalesRule\Model;

use Magento\Framework\Model\AbstractModel;
use Wiki\VendorsSalesRule\Api\Data\CollectInterface;

class CollectCoupon extends AbstractModel implements CollectInterface
{
    const CACHE_TAG = 'wiki_collect_coupon';
    protected $_cacheTag = 'wiki_collect_coupon';

    protected $_eventPrefix = 'wiki_collect_coupon';
    /**
     * Define resource model
     */
    protected function _construct()
    {
        $this->_init('Wiki\VendorsSalesRule\Model\ResourceModel\CollectCoupon');
    }
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getDefaultValues()
    {
        $values = [];

        return $values;
    }
    /**
     * Get coupon code
     *
     * @return $this
     */
    public function getCode()
    {
        return $this->getData(self::CODE);
    }

    /**
     * Set coupon code 
     *
     * @param string $code
     * @return $this
     */
    public function setCode($code)
    {
        return $this->setData(self::CODE, $code);
    }

    /**
     * Get customer id
     *
     * @return $this
     */
    public function getCustomerId()
    {
        return $this->getData(self::CUSTOMER_ID);
    }

    /**
     * Set customer id 
     *
     * @param int $customerId
     * @return $this
     */
    public function setCustomerId($customerId)
    {
        return $this->setData(self::CUSTOMER_ID, $customerId);
    }
}
