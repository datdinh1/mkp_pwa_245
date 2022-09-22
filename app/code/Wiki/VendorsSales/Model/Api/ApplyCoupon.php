<?php

namespace Wiki\VendorsSales\Model\Api;

use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Quote\Api\CartManagementInterface;
use Magento\Quote\Api\Data\CartItemInterfaceFactory;
use Magento\Quote\Model\QuoteRepository\SaveHandler;
use Magento\Quote\Model\Quote\TotalsCollector;
use Magento\Quote\Model\Cart\TotalsFactory;
use Magento\Catalog\Model\ProductFactory;
use Magento\Customer\Api\CustomerRepositoryInterface;

use Wiki\Vendors\Model\VendorFactory;
use Wiki\VendorsSales\Model\QuoteIsActiveFactory;
use Wiki\VendorsSales\Model\Api\Data\Total\GrandTotalsFactory;

use Magento\SalesRule\Model\Coupon;
use Magento\SalesRule\Model\Rule;

/**
 * Handle apply coupon code
 */
class ApplyCoupon
{
    protected $coupon;

    protected $saleRule;

    /**
     * @var CartRepositoryInterface
     */
    protected $cartQuoteRepository;

    /**
     * @var CartManagementInterface
     */
    protected $cartManagementInterface;

    /**
     * @var CartItemInterfaceFactory
     */
    protected $cartItemFactory;

    /**
     * @var ProductFactory
     */
    protected $productFactory;

    /**
     * @var CustomerRepositoryInterface
     */
    protected $customerRepository;

    /**
     * @var VendorFactory
     */
    protected $vendorFactory;

    /**
     * @var QuoteIsActiveFactory
     */
    protected $quoteIsActive;

    /**
     * @var TotalsCollector
     */
    protected $totalsCollector;

    /**
     * @var GrandTotalsFactory
     */
    protected $grandTotalsFactory;

    /**
     * @var TotalsFactory
     */
    protected $totalsFactory;

    public function __construct(
        Coupon $coupon,
        Rule $saleRule,

        CartItemInterfaceFactory            $cartItemFactory,
        CartRepositoryInterface             $cartQuoteRepository,
        CartManagementInterface             $cartManagementInterface,
        ProductFactory                      $productFactory,
        CustomerRepositoryInterface         $customerRepository,
        VendorFactory                       $vendorsFactory,
        QuoteIsActiveFactory                $quoteIsActive,
        TotalsCollector                     $totalsCollector,
        GrandTotalsFactory                  $grandTotalsFactory,
        TotalsFactory                       $totalsFactory
    ) {
        $this->coupon                       = $coupon;
        $this->saleRule                     = $saleRule;
        $this->cartItemFactory              = $cartItemFactory;
        $this->cartQuoteRepository          = $cartQuoteRepository;
        $this->cartManagementInterface      = $cartManagementInterface;
        $this->productFactory               = $productFactory;
        $this->customerRepository           = $customerRepository;
        $this->vendorsFactory               = $vendorsFactory;
        $this->quoteIsActive                = $quoteIsActive;
        $this->totalsCollector              = $totalsCollector;
        $this->grandTotalsFactory           = $grandTotalsFactory;
        $this->totalsFactory                = $totalsFactory;
    }

    public function checkCoupon($products, $vendor_id, $coupon, $customer_id)
    {
        $flag = false;
        $ruleId = $this->coupon->loadByCode($coupon)->getRuleId();
        $rule = $this->saleRule->load($ruleId);
        $subTotal = 0;

        /** check coupon Vendor */
        if ($vendor_id != "MARKETPLACE") {
            foreach ($products as $product) {
                $productById = $this->productFactory->create()->setStoreId(1)->load($product['id']);
                $subTotal += $product['qty'] *  $productById->getPrice();
            }

            foreach ($products as $item) {
                $quote = $this->_resetQuote($customer_id);
                if ($quote === false) continue;

                $vendor = $this->vendorsFactory->create()->loadByVendorId($vendor_id);
                try {
                    $product = $this->productFactory->create()->setStoreId(1)->load($item['id']);
                    if ($vendor->getVendorId() == $vendor_id && $product->getQuantityAndStockStatus()['is_in_stock'] == true) {
                        $quote = $this->_addProduct($quote, $product, $item['qty']);
                    }
                } catch (\Exception $e) {
                    continue;
                }
            }

            try {
                if ($coupon && $coupon != "string") {
                    $quote->setCouponCode($coupon)->save();
                }
                $this->cartQuoteRepository->save($quote->collectTotals());
                if ($quote->getCouponCode()) {
                    $flag = true;
                }
            } catch (\Exception $e) {
                $this->log($e->getMessage());
            }
        }

        /** check coupon Marketplace */
        else {
            $quote = $this->_resetQuote($customer_id);
            if ($quote === false)
                return false;

            foreach ($products as $item) {
                try {
                    $product = $this->productFactory->create()->setStoreId(1)->load($item['id']);
                    if ($product->getQuantityAndStockStatus()['is_in_stock'] == true) {
                        $quote = $this->_addProduct($quote, $product, $item['qty']);
                    }
                } catch (\Exception $e) {
                    continue;
                }
            }

            try {
                $quote->setCouponCode($coupon)->save();
                $this->cartQuoteRepository->save($quote->collectTotals());
                if ($quote->getCouponCode()) {
                    $flag = true;
                }
            } catch (\Exception $e) {
                $this->log($e->getMessage());
            }
        }

        return  $flag;
    }


    public function applyCoupon($productsByShop, $customerId, $mkpCoupon)
    {
        $resultData = $arrayProducts = $arrayCoupon = [];
        foreach ($productsByShop as $item) {
            $quote = $this->_resetQuote($customerId);
            if ($quote === false) continue;

            $products = $item->getProducts();
            $vendor = $this->vendorsFactory->create()->loadByVendorId($item->getVendorId());
            if (is_array($products)) {
                foreach ($products as $productItem) {
                    try {
                        $product = $this->productFactory->create()->setStoreId(1)->load($productItem->getId());
                        if ($vendor->getVendorId() == $item->getVendorId() && $product->getQuantityAndStockStatus()['is_in_stock'] == true) {
                            $quote = $this->_addProduct($quote, $product, $productItem->getQty());
                        }
                        $arrayProducts[] = ['product' => $product, 'qty' => $productItem->getQty()];
                    } catch (\Exception $e) {
                        continue;
                    }
                }
            }
            $coupon = $item->getCoupon();
            if ($coupon && $coupon != "string") {
                $arrayCoupon[] = $coupon;
                if (is_array($coupon)) {
                    $coupon = implode(", ", $coupon);
                }
                $quote->setCouponCode($coupon)->save();
            }
            $this->cartQuoteRepository->save($quote->collectTotals());
            try {
                $resultData[] = $this->setDataGrandTotals($quote, $item->getVendorId());
            } catch (\Exception $e) {
                $this->log($e->getMessage());
                continue;
            }
        }

        $quote = $this->_resetQuote($customerId);
        if ($quote === false)
            return $resultData;

        foreach ($arrayProducts as $product) {
            $quote = $this->_addProduct($quote, $product['product'], $product['qty']);
        }


        // $quote->setCouponCode($mkpCoupon)->save();
        // $this->cartQuoteRepository->save($quote->collectTotals());

        $arrayCoupon[] = $mkpCoupon;
        $coupon = implode(", ", $arrayCoupon);
        $quote->setCouponCode($coupon)->save();
        $this->cartQuoteRepository->save($quote->collectTotals());

        $resultData[] = $this->setDataGrandTotals($quote, "MARKETPLACE");

        $quote->setCouponCode($mkpCoupon)->save();
        $this->cartQuoteRepository->save($quote->collectTotals());
        $total = $this->totalsCollector->collect($quote)->getData();
        $discountMkp = array_sum(array_column(json_decode($quote->getVendorDiscountDetail()), "amount"));
        $discountMkp =  $discountMkp / count($productsByShop);


        foreach ($resultData as $data) {
            if ($mkpCoupon) {
                //minus add discount off mkp for partial  sellers
                if ($data->getVendorId() != 'MARKETPLACE') {
                    $total = $data->getTotals();
                    $total->setDiscountMkp($discountMkp);
                    $total->setBaseSubtotalWithDiscount($total->getBaseSubtotalWithDiscount() + $discountMkp);
                    $total->setSubtotalWithDiscount($total->getSubtotalWithDiscount() + $discountMkp);
                    $total->setGrandTotal($total->getGrandTotal() + $discountMkp);
                    $total->setBaseGrandTotal($total->getBaseGrandTotal() + $discountMkp);
                }
            } else{
                $total = $data->getTotals();
                $total->setDiscountMkp(0);
            }
        }
        return $resultData;
    }

    protected function setDataGrandTotals($quote, $vendorId)
    {
        $total = $this->totalsCollector->collect($quote)->getData();
        $total['discount_amount'] = array_sum(array_column(json_decode($quote->getVendorDiscountDetail()), "amount"));
        $totalDiscount = $this->totalsFactory->create();
        $totalDiscount->setData($total);

        $grandTotalsDiscount = $this->grandTotalsFactory->create();
        $grandTotalsDiscount->setVendorId($vendorId);
        $grandTotalsDiscount->setTotals($totalDiscount);
        return $grandTotalsDiscount;
    }

    protected function _addProduct($quote, $product, $qty, $customPrice = null)
    {
        $cartItem = $this->cartItemFactory->create();
        $cartItem->setProduct($product);
        $cartItem->setQty($qty);
        $cartItem->setIsSuperMode(true);
        if ($customPrice) {
            $cartItem->setCustomPrice($customPrice);
            $cartItem->setOriginalCustomPrice($customPrice);
        }
        $quote->addItem($cartItem);
        return $quote->save();
    }

    protected function _resetQuote($customerId)
    {
        try {
            $customer = $this->customerRepository->getById($customerId);
            $quoteIsActive = $this->quoteIsActive->create()->getCollection();
            $quoteIsActive->addFieldToFilter('customer_id', $customer->getId());

            if (empty($quoteIsActive->getData())) {
                return $this->_createQuote($customer);
            } else {
                try {
                    $quote = $this->cartQuoteRepository->get($quoteIsActive->getData()[count($quoteIsActive->getData()) - 1]['quote_id']);
                } catch (\Exception $e) {
                    $this->log($e->getMessage());
                    $quote = $this->_createQuote($customer);
                }
                $quote->removeAllItems();
                $quote->setCouponCode(null);
                $quote->setVendorDiscountDetail(null);
                return $quote->save();
            }
        } catch (\Exception $e) {
            $this->log($e->getMessage());
            return false;
        }
    }

    protected function _createQuote($customer)
    {
        try {
            $cartId = $this->cartManagementInterface->createEmptyCart();
            $quote = $this->cartQuoteRepository->get($cartId);
            $quote->setIsActive(false);
            $quote->setStoreId(1);
            $quote->setCustomerId($customer->getId());
            $quote->setCustomerGroupId($customer->getGroupId());
            $quote->save();

            $this->quoteIsActive->create()->setCustomerId($customer->getId())->setQuoteId($quote->getId())->save();
            return $quote;
        } catch (\Exception $e) {
            $this->log($e->getMessage());
            return false;
        }
    }

    protected function log($data)
    {
        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/applyCoupon.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        $logger->info($data);
    }
}
