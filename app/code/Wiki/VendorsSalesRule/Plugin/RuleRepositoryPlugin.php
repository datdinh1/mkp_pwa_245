<?php

namespace Wiki\VendorsSalesRule\Plugin;
use Magento\SalesRule\Api\Data\RuleExtensionFactory;
use Magento\SalesRule\Api\Data\RuleExtensionInterface;
use Magento\SalesRule\Api\Data\RuleInterface;
use Magento\SalesRule\Api\Data\RuleSearchResultInterface;
use Magento\SalesRule\Api\RuleRepositoryInterface;
/**
 * Class RuleRepositoryPlugin
 */
class RuleRepositoryPlugin
{
    /**
     * Order feedback field name
     */
    const FIELD_NAME = 'coupon_code';
    /**
     * Order Extension Attributes Factory
     *
     * @var RuleExtensionFactory
     */
    protected $extensionFactory;
    /**
     * OrderRepositoryPlugin constructor
     *
     * @param RuleExtensionFactory $extensionFactory
     */
    public function __construct(RuleExtensionFactory $extensionFactory)
    {
        $this->extensionFactory = $extensionFactory;
    }
    /**
     * Add "customer_feedback" extension attribute to order data object to make it accessible in API data
     *
     * @param RuleRepositoryInterface $subject
     * @param RuleInterface $order
     *
     * @return RuleInterface
     */
    public function afterGet(RuleRepositoryInterface $subject, RuleInterface $order)
    {
        $customerFeedback = $order->getData(self::FIELD_NAME);
        $extensionAttributes = $order->getExtensionAttributes();
        $extensionAttributes = $extensionAttributes ? $extensionAttributes : $this->extensionFactory->create();
      // $extensionAttributes->setCustomerFeedback($customerFeedback);
      $extensionAttributes->setCouponCode($customerFeedback);
        $order->setExtensionAttributes($extensionAttributes);
        return $order;
    }
    /**
     * Add "customer_feedback" extension attribute to order data object to make it accessible in Magento API data
     *
     * @param RuleRepositoryInterface $subject
     * @param RuleSearchResultInterface $searchResult
     *
     * @return RuleSearchResultInterface
     */
    public function afterGetList(RuleRepositoryInterface $subject, RuleSearchResultInterface $searchResult)
    {
        $orders = $searchResult->getItems();
        foreach ($orders as &$order) {
            $customerFeedback = $order->getData(self::FIELD_NAME);
            $extensionAttributes = $order->getExtensionAttributes();
            $extensionAttributes = $extensionAttributes ? $extensionAttributes : $this->extensionFactory->create();
            $extensionAttributes->setCouponCode($customerFeedback);
            $order->setExtensionAttributes($extensionAttributes);
        }
        return $searchResult;
    }
}