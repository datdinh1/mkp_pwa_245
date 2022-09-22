<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Wiki\VendorsCommission\Model\Api;

use Wiki\VendorsCommission\Api\CommissionManagementInterface;
use Wiki\VendorsCommission\Model\Rule as CommissionRule;

/**
 * Handle various customer account actions
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @SuppressWarnings(PHPMD.TooManyFields)
 * @SuppressWarnings(PHPMD.ExcessiveClassComplexity)
 * @SuppressWarnings(PHPMD.CookieAndSessionMisuse)
 */
class CommissionManagement implements CommissionManagementInterface
{
    /**
     * @var \Wiki\VendorsCommission\Model\Rule
     */
    protected $_ruleFactory;

    /**
     * @var \Magento\CatalogRule\Model\RuleFactory
     */
    protected $_catalogRuleFactory;

    /**
     * Store manager
     *
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    public function __construct(
        \Magento\Framework\Stdlib\DateTime\Timezone $_stdTimezone,
        \Wiki\VendorsCommission\Model\RuleFactory $ruleFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Wiki\VendorsCommission\Model\TmpRuleFactory $catalogRuleFactory,
        \Wiki\Vendors\Model\Vendor $vendorsModel
    ) {
        $this->_ruleFactory                 = $ruleFactory;
        $this->_stdTimezone                 = $_stdTimezone;
        $this->_vendorsModel                = $vendorsModel;
        $this->_storeManager                = $storeManager;
        $this->_catalogRuleFactory          = $catalogRuleFactory;
    }

    /**
     * @inheritdoc
     */
    public function getAllCommissionRule()
    {
        $currentTime = $this->_stdTimezone->date()->format('Y-m-d');
        $ruleCollection = $this->_ruleFactory->create()->getCollection()
        ->addFieldToFilter('is_active', 1)
        ->addFieldToFilter('to_date', ['gteq' => $currentTime]);
        $activeRules =[];
        foreach($ruleCollection as $rule){
            if (!array_key_exists($rule->getRuleId(), $activeRules)) {
                $activeRules[$rule->getRuleId()] = $rule->getData();
            }
        }
        return $activeRules;
    }
    //Request Data
    //{
    //"orderId": "40"
    //}
    public function applyCommission($orderId)
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $order = $objectManager->create('Magento\Sales\Model\Order')->load($orderId);
        $invoice_details = $order->getInvoiceCollection();
        foreach ($invoice_details as $invoice){
            $invoiceOrder = $invoice;
        }
        $products = $order->getAllVisibleItems();
        $arrayCommission["commission"] = [];
        foreach($products as $product){
            $vendorId = $product->getVendorId();
            $vendor = $this->_vendorsModel->load($vendorId);
            $vendorGroupId = $vendor->getGroupId();
            $websiteId     = $this->_storeManager->getStore(1)->getWebsiteId();
            $ruleCollection = $this->_ruleFactory->create()->getCollection()
                    ->addFieldToFilter('vendor_group_ids', ['finset'=>$vendorGroupId])
                    ->addFieldToFilter('website_ids', ['finset'=>$websiteId])
                    ->addFieldToFilter('is_active', CommissionRule::STATUS_ENABLED);
            $today = (new \DateTime())->format('Y-m-d');
            $ruleCollection->getSelect()
                ->where(
                    '(from_date IS NULL OR from_date<=?) AND (to_date IS NULL OR to_date>=?)',
                    $today,
                    $today
                )->order('priority ASC');
            if ($ruleCollection->count()) {
                $ruleDescriptionArr = [];
                $fee = 0;
                foreach ($ruleCollection as $rule) {
                    $tmpRule = $this->_catalogRuleFactory->create();
                    /*If the product is not match with the conditions just continue*/
                    $tmpRule->setConditionsSerialized($rule->getConditionSerialized());
                    if (!$tmpRule->getConditions()->validate($product)) {
                        continue;
                    }
                    $tmpFee = 0;
                    switch ($rule->getData('commission_by')) {
                        case CommissionRule::COMMISSION_BY_FIXED_AMOUNT:
                            $tmpFee = $rule->getData('commission_amount');
                            break;
                        case CommissionRule::COMMISSION_BY_PERCENT_PRODUCT_PRICE:
                            if (!$product->getData('base_row_total')) {
                                $baseRowTotal = ($product->getData('price_incl_tax') * $product->getData('qty')) - $product->getData('base_tax_amount');
                                $product->setData('base_row_total', $baseRowTotal);
                            }
                            switch ($rule->getData('commission_action')) {
                                case CommissionRule::COMMISSION_BASED_PRICE_INCL_TAX:
                                    $amount = $product->getData('base_row_total') + $product->getData('base_tax_amount');
                                    break;
                                case CommissionRule::COMMISSION_BASED_PRICE_EXCL_TAX:
                                    $amount = $product->getData('base_row_total');
                                    break;
                                case CommissionRule::COMMISSION_BASED_PRICE_AFTER_DISCOUNT_INCL_TAX:
                                    $amount = $product->getData('base_row_total') - $product->getData('base_discount_amount') + $product->getData('base_tax_amount');
                                    break;
                                case CommissionRule::COMMISSION_BASED_PRICE_AFTER_DISCOUNT_EXCL_TAX:
                                    $amount = $product->getData('base_row_total')  - $product->getData('base_discount_amount');
                                    break;
                                default:
                                    $amount = $product->getData('base_row_total')  - $product->getData('base_discount_amount');
                            }
                            $tmpFee = ($rule->getData('commission_amount') * $amount)/100;
                            break;
                    }
                    $tmpFeeWithCurrency = $invoiceOrder->getOrder()->formatBasePrice($tmpFee);

                    $ruleDescriptionArr[] = $rule->getDescription().": -".$tmpFeeWithCurrency;

                    $fee +=  $tmpFee;
                    $arrayCommission["commission"][$product->getId()] = $fee;
                    /*Break if the flag stop rules processing is set to 1*/
                    if ($rule->getData('stop_rules_processing')) {
                        break;
                    }
                }
            }
        }
        return $arrayCommission;
    }
}
