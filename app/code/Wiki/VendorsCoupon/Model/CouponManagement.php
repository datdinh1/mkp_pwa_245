<?php

/**
 *
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Wiki\VendorsCoupon\Model;

use Wiki\VendorsCoupon\Api\CouponManagementInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Quote\Model\QuoteIdMaskFactory;
use Magento\SalesRule\Model\RuleFactory;
use Wiki\Vendors\Model\SellerManagement;
use Wiki\VendorsCoupon\Model\Api\CouponFactory as CouponApiFactory;
use Wiki\VendorsCoupon\Model\Api\VendorsCouponFactory;
use Wiki\VendorsProduct\Model\Api\Data\SellerDataFactory;
use Wiki\Vendors\Model\GroupFactory;
use Wiki\Vendors\Model\VendorFactory;
use Wiki\VendorsCoupon\Model\Api\ItemsFactory;

use Wiki\VendorsSalesRule\Model\CollectCouponFactory as WikiCollectionSalesRule;


/**
 * Coupon management object.
 */
class CouponManagement extends \Magento\Quote\Model\CouponManagement implements CouponManagementInterface
{
    protected $salesRuleWk;
    /**
     * Quote repository.
     *
     * @var \Magento\Quote\Api\CartRepositoryInterface
     */
    protected $quoteRepository;

    /**
     * @var \Wiki\VendorsCoupon\Model\CouponFactory
     */
    protected $_couponFactory;

    /**
     * @var \Magento\Framework\Stdlib\DateTime\TimezoneInterface
     */
    protected $_date;

    /**
     * @var \Wiki\VendorsCoupon\Model\CouponDetailsFactory
     */
    protected $_couponDetailFactory;

    /**
     * @var RuleFactory
     */
    protected $ruleFactory;

    /**
     * @var SellerManagement 
     */
    protected $sellerManagement;

    /**
     * @var CouponApiFactory
     */
    protected $couponApiFactory;

    /**
     * @var VendorFactory
     */
    protected $vendorFactory;

    /**
     * @var VendorsCouponApiFactory
     */
    protected $vendorsCouponFactory;

    /**
     * @var SellerDataFactory
     */
    protected $sellerDataFactory;

    /**
     * @var GroupFactory
     */
    protected $groupVendor;

    protected $customerRepository;


    /**
     * @var WikiCollectionSalesRule
     */
    protected $wikiCollectionSalesRule;

    /**
     * @var ItemsFactory
     */
    protected $itemsPageFactory;


    /**
     * Constructs a coupon read service object.
     * @param \Wiki\VendorsCoupon\Model\CouponFactory $couponFactory
     * @param \Magento\Framework\Stdlib\DateTime\TimezoneInterface $date
     * @param QuoteIdMaskFactory $quoteIdMaskFactory
     * @param \Magento\Quote\Api\CartRepositoryInterface $quoteRepository
     * @param Rule $ruleFactory
     */
    public function __construct(

        WikiCollectionSalesRule                          $wikiCollectionSalesRule,
        \Magento\Customer\Api\CustomerRepositoryInterfaceFactory $customerRepositoryFactory,
        \Wiki\VendorsCoupon\Model\CouponFactory $couponFactory,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $date,
        \Wiki\VendorsCoupon\Model\CouponDetailsFactory $couponDetailFactory,
        \Magento\Quote\Api\CartRepositoryInterface $quoteRepository,
        \Wiki\Vendors\Model\Vendor $vendorsModel,
        \Magento\Customer\Model\Customer $customerModel,
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\SalesRule\Model\ResourceModel\Rule\CollectionFactory  $collection,
        \Magento\Framework\Stdlib\DateTime\Timezone $_stdTimezone,
        QuoteIdMaskFactory $quoteIdMaskFactory,
        \Magento\Checkout\Model\Cart $cart,
        \Magento\Catalog\Model\Product $productmodel,
        \Magento\Framework\Data\Form\FormKey $formKey,
        \Magento\Quote\Model\Quote\Item $quoteItem,
        \Wiki\VendorsProduct\Model\ProductManagement $productManagement,
        RuleFactory          $ruleFactory,
        SellerManagement      $sellerManagement,
        \Magento\Catalog\Model\ProductRepository $productRepository,
        \Wiki\VendorsConfig\Helper\Data $configHelper,
        CouponApiFactory $couponApiFactory,
        VendorFactory $vendorsFactory,
        SellerDataFactory $sellerDataFactory,
        VendorsCouponFactory $vendorsCouponFactory,
        GroupFactory $groupVendor,
        ItemsFactory $itemsPageFactory,
        array $data = []

    ) {
        $this->wikiCollectionSalesRule  = $wikiCollectionSalesRule;
        $this->customerRepository   = $customerRepositoryFactory->create();
        $this->_couponFactory       = $couponFactory;
        $this->_date                = $date;
        $this->_couponDetailFactory = $couponDetailFactory;
        $this->quoteRepository      = $quoteRepository;
        $this->_customerModel       = $customerModel;
        $this->_vendorsModel        = $vendorsModel;
        $this->_coreRegistry        = $registry;
        $this->collection           = $collection;
        $this->_stdTimezone         = $_stdTimezone;
        $this->_storeManager        = $storeManager;
        $this->quoteIdMaskFactory   = $quoteIdMaskFactory;
        $this->_cart                = $cart;
        $this->_formKey             = $formKey;
        $this->_productmodel        = $productmodel;
        $this->_quoteItem           = $quoteItem;
        $this->productManagement    = $productManagement;
        $this->ruleFactory          = $ruleFactory;
        $this->sellerManagement     = $sellerManagement;
        $this->productRepository    = $productRepository;
        $this->couponApiFactory     = $couponApiFactory;
        $this->vendorsFactory       = $vendorsFactory;
        $this->vendorsCouponFactory = $vendorsCouponFactory;
        $this->sellerDataFactory    = $sellerDataFactory;
        $this->groupVendor          = $groupVendor;
        $this->itemsPageFactory     = $itemsPageFactory;
        $this->_configHelper        = $configHelper;
    }

    public function getCollectCouponByUser($customerId)
    {
        //check user isset
        try {
            $checkUser = $this->customerRepository->getById($customerId);
        } catch (\Exception $e) {
            return false;
        }

        $collection = $this->wikiCollectionSalesRule->create()->getCollection();
        $collection->addFieldToFilter('customer_id', $customerId);
        if (empty($collection->getData())) {
            return false;
        }

        $listRuleId = [];
        foreach ($collection as $collect) {
            $listRuleId[] = $collect->getRuleId();
        }

        // delete coupon code expired or deactivate of customer
        $rulesExpired = $this->collection->create()
            ->addFieldToFilter('coupon_type', 2)
            ->addFieldToFilter('rule_id', array('in' => $listRuleId));
        $rulesExpired->getSelect()->where('is_active = 0')->orWhere('is_active = 1 AND to_date <= ?', date('Y-m-d'));
        if ($rulesExpired->getData()) {
            foreach ($rulesExpired as $ruleExpired) {
                foreach ($collection as $collect) {
                    if ($ruleExpired->getId() == $collect->getRuleId()) {
                        $collect->delete();
                        $listRuleId = array_diff($listRuleId, [$ruleExpired->getId()]);
                        break;
                    }
                }
            }
        }

        $rules = $this->collection->create()->addFieldToFilter('rule_id', array('in' => $listRuleId));

        $dataRule = [];
        foreach ($rules as $rule) {
            $data = $this->couponApiFactory->create();
            $data->setData($rule->getData());
            $data->setCouponType($rule->getCouponBySeller());
            $vendor = $this->_vendorsModel->loadByIdentifier($rule->getCouponBySeller());
            $flag = false;

            if ($rule->getCouponBySeller() == "MARKETPLACE_SELLER" || $rule->getCouponBySeller() == "MARKETPLACE_CODE") {
                $sellerId = 'MKP';
                $flag = $this->getVendorIdByMKPSeller($sellerId, $rule);
            } else {
                $flag = $rule->getCouponBySeller();
            }

            if ($flag != false) {
                $info = $this->setVendorOfCoupon($flag, $rule);
                $data->setVendor($info);
            }

            $dataRule[] = $data;
        }
        return $dataRule ?: null;
    }

    public function setVendorOfCoupon($vendor, $rule)
    {
        $vendor = $this->_vendorsModel->loadByIdentifier($vendor);
        $info = $this->sellerDataFactory->create();
        $groupName = $this->groupVendor->create()->load($vendor->getGroupId())->getVendorGroupCode();
        $info->setData($vendor->getData());
        $info->setGroupName($groupName);
        $info->setLogo($this->getLogoSeller($vendor->getId()));
        $nameStore = $this->_configHelper->getVendorConfig('general/store_information/name', $vendor->getId());
        $info->setStoreName($nameStore);
        return $info;
    }

    public function getVendorIdByMKPSeller($vendorId, $rule)
    {
        $flag = false;
        $value = $rule->getActions()->getData()['actions'];
        if (!empty($value)) {
            $value = $value[0]->getValue();
            if (!empty($value)) {
                if ((int)$value != 0) {
                    $vendor = $this->_vendorsModel->load($value);
                } else {
                    $vendor = $this->_vendorsModel->loadByIdentifier($value);
                }
                if ($vendorId == $vendor->getVendorId() || $vendorId == 'MKP') {

                    $flag = $vendor->getVendorId();
                }
            }
        }
        return $flag;
    }

    /**
     * {@inheritdoc}
     */
    public function getDiscountDetail($cartId)
    {
        /** @var  \Magento\Quote\Model\Quote $quote */
        $quote = $this->quoteRepository->getActive($cartId);
        $quote->collectTotals();
        return $quote->getData('vendor_discount_detail');
    }

    /**
     * {@inheritdoc}
     */
    public function set($cartId, $couponCode)
    {
        $coupon = trim($couponCode);
        $coupon = $this->_couponFactory->create()->load($coupon, 'code');
        /** @var  \Magento\Quote\Model\Quote $quote */
        $quote = $this->quoteRepository->getActive($cartId);
        if (!$quote->getItemsCount()) {
            throw new NoSuchEntityException(__('Cart %1 doesn\'t contain products', $cartId));
        }
        $couponDetail = $this->_couponDetailFactory->create();
        if (!$coupon->getId()) {
            return parent::set($cartId, $couponCode);
        }
        $today = $this->_date->date()->format('Y-m-d');
        if (
            ($coupon->getFromDate() && $today < $coupon->getFromDate()) ||
            ($coupon->getToDate() && $today > $coupon->getToDate()) ||
            ($coupon->getUsageLimit() > 0 && $coupon->getTimesUsed() >= $coupon->getUsageLimit())
        ) {
            return parent::set($cartId, $couponCode);
        }
        $canApplyCoupon = false;
        foreach ($quote->getAllItems() as $item) {
            if ($item->getProduct()->getVendorId() == $coupon->getVendorId()) {
                $canApplyCoupon = true;
                break;
            }
        }
        if (!$canApplyCoupon) return parent::set($cartId, $couponCode);
        try {
            $appliedCouponIds = $quote->getData('applied_vendor_coupon_ids');
            $appliedCouponIds = $appliedCouponIds ? explode(',', $appliedCouponIds) : [];
            if (!in_array($coupon->getId(), $appliedCouponIds)) $appliedCouponIds[] = $coupon->getId();
            $quote->getShippingAddress()->setCollectShippingRates(true);
            $quote->setData('applied_vendor_coupon_ids', implode(',', $appliedCouponIds))->collectTotals();
            $this->quoteRepository->save($quote);
            return true;
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__('Could not apply coupon code'));
        }
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function removeCoupon($cartId, $couponCode)
    {
        $coupon = trim($couponCode);
        $coupon = $this->_couponFactory->create()->load($coupon, 'code');
        /** @var  \Magento\Quote\Model\Quote $quote */
        $quote = $this->quoteRepository->getActive($cartId);
        if (!$quote->getItemsCount()) {
            throw new NoSuchEntityException(__('Cart %1 doesn\'t contain products', $cartId));
        }
        $couponDetail = $this->_couponDetailFactory->create();
        $appliedCouponIds = $quote->getData('applied_vendor_coupon_ids');
        $appliedCouponIds = $appliedCouponIds ? explode(',', $appliedCouponIds) : [];
        $idCoupon = $coupon->getId();
        if (($index = array_search($coupon->getId(), $appliedCouponIds)) !== false) {
            array_splice($appliedCouponIds, $index, 1);
            $quote->getShippingAddress()->setCollectShippingRates(true);
            $quote->setData('applied_vendor_coupon_ids', implode(',', $appliedCouponIds))->collectTotals();
            $this->quoteRepository->save($quote);
            return true;
        }
        return parent::remove($cartId);
    }

    public function getAllCoupon()
    {
        $vendors = $marketplace = $rules = $this->collection->create()
            ->addFieldToFilter('is_active', 1)
            ->addFieldToFilter('coupon_type', 2)
            ->addFieldToFilter('to_date', array(
                array('null' => true),
                array('gteq' => date('Y-m-d'))
            ))
            ->addFieldToFilter('is_visible_in_listing', 1);
        $temp = $dataRule = [];
        foreach ($rules as $rule) {
            $data = $this->couponApiFactory->create();
            $data->setData($rule->getData());
            $value = $rule->getActions()->getData()['actions'];
            if (!empty($value)) {
                $value = $value[0]->getValue();
                if (!empty($value)) {
                    if (array_key_exists($value, $temp)) {
                        $sellerId = $temp[$value];
                    } else {
                        $vendor = $this->vendorsFactory->create()->load($value);
                        if ($vendor->getVendorId()) {
                            $temp[$value] = $vendor->getVendorId();
                        }
                        $sellerId = $vendor->getVendorId();
                    }
                    $data->setStoreName($sellerId);
                }
            }
            $dataRule[] = $data;
        }
        return $dataRule ?: [];
    }

    public function getAllCouponMKP($cartId, $allproducts)
    {
        if (!is_numeric($cartId)) {
            $quoteIdMask = $this->quoteIdMaskFactory->create()->load($cartId, 'masked_id');
            $cartId = $quoteIdMask->getQuoteId();
        }
        $quote = $this->quoteRepository->getActive($cartId);
        $currentTime = $this->_stdTimezone->date()->format('Y-m-d');
        $activeRules = [];
        $rules = $this->collection->create()
            // ->addFieldToFilter('to_date', ['gteq' => $currentTime])
            ->addFieldToFilter('to_date', array(
                array('null' => true),
                array('gteq' => date('Y-m-d'))
            ))
            ->addFieldToFilter('coupon_type', 2)
            ->addFieldToFilter('coupon_by_seller', "MARKETPLACE")
            ->addFieldToFilter('is_visible_in_listing', 1);
        foreach ($rules as $rule) {
            try {
                foreach ($allproducts as $productID) {
                    $product = $this->_productmodel->load($productID["id"]);
                    $item = $this->_productmodel->setProduct($product);
                    if ($rule->getActions()->validate($product)) {
                        $fakeQuote = clone $quote;
                        $fakeQuote->setId(null);
                        $this->_quoteItem->setQuote($fakeQuote)->setProduct($product);
                        $this->_quoteItem->setAllItems(array($product));
                        $this->_quoteItem->getProduct()->setProductId($product->getEntityId());
                        $validate = $rule->getConditions()->validate($this->_quoteItem);
                        if ($validate) {
                            if (!array_key_exists($rule->getRuleId(), $activeRules)) {
                                $imageUrl = $this->_storeManager->getStore()->getBaseUrl() . "pub/media/sampleimageuploader/images/image" . $rule->getImage();
                                $rule->setData("image", $imageUrl);
                                $activeRules[$rule->getRuleId()] = $rule->getData();
                            }
                        } else {
                            break;
                        }
                    } else {
                        break;
                    }
                }
            } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
                continue;
            }
        }
        return $activeRules;
    }

    public function getListCouponMKP()
    {
        $rules = $this->collection->create()
            ->addFieldToFilter('is_active', 1)
            ->addFieldToFilter('coupon_type', 2)
            ->addFieldToFilter('to_date', array(
                array('null' => true),
                array('gteq' => date('Y-m-d'))
            ))
            ->addFieldToFilter('coupon_by_seller', array("MARKETPLACE_SELLER", "MARKETPLACE_CODE"))
            ->addFieldToFilter('is_visible_in_listing', 1);
        $temp = $dataRule = [];
        foreach ($rules as $rule) {
            $flag = false;

            if ($rule->getCouponBySeller() == "MARKETPLACE_SELLER") {
                $sellerId = 'MKP';
                $flag = $this->getVendorIdByMKPSeller($sellerId, $rule);
            }
            $data = $this->couponApiFactory->create();
            $data->setData($rule->getData());
            if ($flag != false) {
                $info = $this->setVendorOfCoupon($flag, $rule);
                $data->setVendor($info);
            }

            $dataRule[] = $data;
        }
        return $dataRule ?: [];
    }

    public function getListCouponByVendor()
    {
        $rules = $this->collection->create()
            ->addFieldToFilter('is_active', 1)
            ->addFieldToFilter('coupon_type', 2)
            ->addFieldToFilter('to_date', array(
                array('null' => true),
                array('gteq' => date('Y-m-d'))
            ))
            ->addFieldToFilter('coupon_by_seller', array('neq' => "MARKETPLACE"))
            ->addFieldToFilter('is_visible_in_listing', 1);
        $temps = $dataRule = [];
        $dataVendor = $this->vendorsCouponFactory->create();
        foreach ($rules as $rule) {
            $data = $this->couponApiFactory->create();
            $data->setData($rule->getData());
            if ($rule->getCouponBySeller() == "MARKETPLACE_SELLER") {
                $value = $rule->getActions()->getData()['actions'];
                if (!empty($value)) {
                    $value = $value[0]->getValue();
                    if (!empty($value)) {
                        if (array_key_exists($value, $temps)) {
                            $temps[$value]['coupons'][] = $data;
                        } else {
                            $vendor = $this->vendorsFactory->create()->load($value);
                            if ($vendor->getVendorId()) {
                                $info = $this->sellerDataFactory->create();
                                $groupName = $this->groupVendor->create()->load($vendor->getGroupId())->getVendorGroupCode();
                                $info->setData($vendor->getData());
                                $info->setGroupName($groupName);
                                $info->setLogo($this->getLogoSeller($value));
                                $temps[$value]['vendor'] = $info;
                                $temps[$value]['coupons'][] = $data;
                            }
                        }
                    }
                }
            } else {
                $vendor = $this->vendorsFactory->create()->loadByVendorId($rule->getCouponBySeller());
                if (array_key_exists($vendor->getId(), $temps)) {
                    $temps[$vendor->getId()]['coupons'][] = $data;
                } else {
                    if ($vendor->getVendorId()) {
                        $info = $this->sellerDataFactory->create();
                        $groupName = $this->groupVendor->create()->load($vendor->getGroupId())->getVendorGroupCode();
                        $info->setData($vendor->getData());
                        $info->setGroupName($groupName);
                        $info->setLogo($this->getLogoSeller($vendor->getGroupId()));
                        $temps[$vendor->getId()]['vendor'] = $info;
                        $temps[$vendor->getId()]['coupons'][] = $data;
                    }
                }
            }
        }

        foreach ($temps as $dataInfo) {
            $dataVendor = $this->vendorsCouponFactory->create();
            $dataVendor->setData($dataInfo);
            $dataRule[] = $dataVendor;
        }
        return $dataRule;
    }

    public function getListCouponByVendorId($vendorId, $status = null, $pageSize = null, $currentPage = null)
    {
        $rules = $this->collection->create()
            //->addFieldToFilter('is_active', 1)
            ->addFieldToFilter('coupon_type', 2)
            // ->addFieldToFilter('to_date', array(
            //     array('null' => true),
            //     array('gteq' => date('Y-m-d'))
            // ))
            ->addFieldToFilter('coupon_by_seller', array($vendorId, "MARKETPLACE_SELLER"))
            ->addFieldToFilter('is_visible_in_listing', 1);
        if ($status) {
            if (strtolower($status) == 'available') {
                $rules->addFieldToFilter('to_date', array(
                    array('null' => true),
                    array('gteq' => date('Y-m-d'))
                ))
                    ->addFieldToFilter('from_date', array(
                        array('null' => true),
                        array('lteq' => date('Y-m-d'))
                    ));
            } else if (strtolower($status) == 'expired') {
                $rules->addFieldToFilter('to_date', array(
                    array('lt' => date('Y-m-d'))
                ));
            } else if (strtolower($status) == 'soon') {
                $rules->addFieldToFilter('from_date', array(
                    array('null' => true),
                    array('gt' => date('Y-m-d'))
                ));
            }
        }

        $rulesIds = [];
        foreach ( $rules as $rule ){
            $flag = false;
            if ( $rule->getCouponBySeller() == "MARKETPLACE_SELLER" ){
                $sellerId = "MKP";
                $flag = $this->getVendorIdByMKPSeller($sellerId, $rule);
            } else {
                $flag = $vendorId;
            }
            if ($flag != false && $flag == $vendorId) {
                $rulesIds[] = $rule->getId();
            }
        }

        $pageSize = $pageSize ? $pageSize : 10;
        $rules = $this->collection->create()->addFieldToFilter('rule_id', $rulesIds);
        $countTotal = count($rulesIds);
        $rules->setPageSize($pageSize)->setCurPage($currentPage);

        $dataRule = [];
        try {
            foreach ($rules as $rule ){
                $info = $this->setVendorOfCoupon($vendorId, $rule);
                $data = $this->couponApiFactory->create();
                $data->setData($rule->getData());
                $data->setVendor($info);
                if ( $rule->getPrimaryCoupon() ){
                    $codeGenerate = $rule->getPrimaryCoupon()->getAutoGenerate();
                    $data->setCodeGenerate($codeGenerate ? $codeGenerate : '');
                }
                $dataRule[] = $data;
            }
        }
        catch ( \Exception $e ){};
        
        $dataItems = $this->itemsPageFactory->create();
        $dataItems->setItems($dataRule ?: []);
        $dataItems->setTotalCount($countTotal);
        return $dataItems;
    }

    public function getLogoSeller($vendorId)
    {
        $basePath = 'ves_vendors/logo/';
        $img = $this->_configHelper->getVendorConfig('general/store_information/logo_image_seller', $vendorId);
        return empty($img) ? null : $basePath . $img;
    }

    public function getCouponByVendor($cartId, $namestore, $arrayProductID)
    {
        if (!is_numeric($cartId)) {
            $quoteIdMask = $this->quoteIdMaskFactory->create()->load($cartId, 'masked_id');
            $cartId = $quoteIdMask->getQuoteId();
        }
        $quote = $this->quoteRepository->getActive($cartId);
        $currentTime = $this->_stdTimezone->date()->format('Y-m-d');
        $activeRules = [];
        $rules = $this->collection->create()
            ->addFieldToFilter('is_active', 1)
            ->addFieldToFilter('to_date', ['gteq' => $currentTime])
            ->addFieldToFilter('coupon_by_seller', $namestore);
        foreach ($rules as $rule) {
            try {
                foreach ($arrayProductID as $productID) {
                    $product = $this->_productmodel->load($productID);
                    $item = $this->_productmodel->setProduct($product);
                    if ($rule->getActions()->validate($product)) {
                        $fakeQuote = clone $quote;
                        $fakeQuote->setId(null);
                        $this->_quoteItem->setQuote($fakeQuote)->setProduct($product);
                        $this->_quoteItem->setAllItems(array($product));
                        $this->_quoteItem->getProduct()->setProductId($product->getEntityId());
                        $validate = $rule->getConditions()->validate($this->_quoteItem);
                        if ($validate) {
                            if (!array_key_exists($rule->getRuleId(), $activeRules)) {
                                $imageUrl = $this->_storeManager->getStore()->getBaseUrl() . "pub/media/sampleimageuploader/images/image" . $rule->getImage();
                                $rule->setData("image", $imageUrl);
                                $activeRules[$rule->getRuleId()] = $rule->getData();
                            }
                        } else {
                            break;
                        }
                    } else {
                        break;
                    }
                }
            } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
                continue;
            }
            $sellerId = 'MKP';
        }
        return $activeRules;
    }

    public function applyCouponCart($cartId, $couponCode)
    {
        return $this->set($cartId, $couponCode);
    }

    public function cancleCoupon($cartId, $couponCode)
    {
        //return $this->removeCoupon($cartId, $couponCode);
        $coupon = trim($couponCode);
        $coupon = $this->_couponFactory->create()->load($coupon, 'code');
        /** @var  \Magento\Quote\Model\Quote $quote */
        $quote = $this->quoteRepository->getActive($cartId);
        if (!$quote->getItemsCount()) {
            throw new NoSuchEntityException(__('Cart %1 doesn\'t contain products', $cartId));
        }
        $couponDetail = $this->_couponDetailFactory->create();
        $appliedCouponIds = $quote->getData('applied_vendor_coupon_ids');
        $appliedCouponIds = $appliedCouponIds ? explode(',', $appliedCouponIds) : [];
        $idCoupon = $coupon->getId();
        if (($index = array_search($coupon->getId(), $appliedCouponIds)) !== false) {
            array_splice($appliedCouponIds, $index, 1);
            $quote->getShippingAddress()->setCollectShippingRates(true);
            $quote->setData('applied_vendor_coupon_ids', implode(',', $appliedCouponIds))->collectTotals();
            $quote->save($quote);
            return true;
        }
        return parent::remove($cartId);
    }

    //conditionActions = arr
    public function searchConditionVendorID($arr, $vendorID)
    {
        foreach ($arr as $k => $v) {
            $att = (isset($v["attribute"])) ? $v["attribute"] : "";
            $va = (isset($v["value"])) ? $v["value"] : "";
            if ($att == "vendor_id" && $va == $vendorID) {
                return true;
            }
            //$v is array
            else if (isset($v['conditions']) && is_array($v) > 0) {
                return $this->searchConditionVendorID($v['conditions'], $vendorID);
            } //not found
            else if (is_array($v)) {
                return  $this->searchConditionVendorID($v, $vendorID);
            }
        }
    }

    public function getCouponMrkByVendor($cartId, $arrayProductID)
    {
        if (!is_numeric($cartId)) {
            $quoteIdMask = $this->quoteIdMaskFactory->create()->load($cartId, 'masked_id');
            $cartId = $quoteIdMask->getQuoteId();
        }
        $quote = $this->quoteRepository->getActive($cartId);
        $currentTime = $this->_stdTimezone->date()->format('Y-m-d');
        $activeRules = [];
        $rules = $this->collection->create()
            ->addFieldToFilter('is_active', 1)
            ->addFieldToFilter('to_date', ['gteq' => $currentTime])
            ->addFieldToFilter('coupon_by_seller', array("in" => ''));
        foreach ($rules as $rule) {
            try {
                foreach ($arrayProductID as $productID) {
                    $product = $this->_productmodel->load($productID);
                    $item = $this->_productmodel->setProduct($product);
                    if ($rule->getActions()->validate($product)) {
                        $fakeQuote = clone $quote;
                        $fakeQuote->setId(null);
                        $this->_quoteItem->setQuote($fakeQuote)->setProduct($product);
                        $this->_quoteItem->setAllItems(array($product));
                        $this->_quoteItem->getProduct()->setProductId($product->getEntityId());
                        $validate = $rule->getConditions()->validate($this->_quoteItem);
                        if ($validate) {
                            if (!array_key_exists($rule->getRuleId(), $activeRules)) {
                                $imageUrl = $this->_storeManager->getStore()->getBaseUrl() . "pub/media/sampleimageuploader/images/image" . $rule->getImage();
                                $rule->setData("image", $imageUrl);
                                $activeRules[$rule->getRuleId()] = $rule->getData();
                            }
                        } else {
                            break;
                        }
                    } else {
                        break;
                    }
                }
            } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
                continue;
            }
        }
        return $activeRules;
    }

    /**
     * {@inheritdoc}
     */
    public function applyDiscount($cartId, $couponCode, $arrayProductShop)
    {
        $coupon = trim($couponCode);
        $coupon = $this->_couponFactory->create()->load($coupon, 'code');
        /** @var  \Magento\Quote\Model\Quote $quote */
        if (!is_numeric($cartId)) {
            $quoteIdMask = $this->quoteIdMaskFactory->create()->load($cartId, 'masked_id');
            $cartId = $quoteIdMask->getQuoteId();
        }
        $quote = $this->quoteRepository->getActive($cartId);
        $this->_cart->setQuote($quote);
        $allItems = $quote->getAllItems();
        foreach ($allItems as $item) {
            $itemId = $item->getItemId();
            $this->_cart->removeItem($itemId)->save();
        }

        $formkey = $this->_formKey->getFormKey();
        foreach ($arrayProductShop as $productShop) {
            $quote = $this->quoteRepository->getActive($cartId);
            $this->_cart->setQuote($quote);
            $product = $this->_productmodel->load($productShop["id"]);
            $params = array(
                'form_key' => $formkey,
                'product' => $productShop["id"], //product Id
                'qty'   => $productShop["qty"] //quantity of product
            );
            $this->_cart->addProduct($product, $params);
            $this->_cart->save();
        }
        $quote = $this->quoteRepository->getActive($cartId);
        $quote->setCouponCode($couponCode);
        $data = $quote->collectTotals();
        $discountPrice = $data["subtotal"] - $data["subtotal_with_discount"];
        return $discountPrice;
    }

    /**
     * {@inheritdoc}
     */
    public function applyCouponSumProduct($cartId, $couponCode, $discountCodeStore, $arrayProductSelect)
    {
        /** @var  \Magento\Quote\Model\Quote $quote */
        if (!is_numeric($cartId)) {
            $quoteIdMask = $this->quoteIdMaskFactory->create()->load($cartId, 'masked_id');
            $cartId = $quoteIdMask->getQuoteId();
        }
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $discountPrice = 0;
        $priceAfterDiscount = 0;
        $countProduct = 0;
        foreach ($arrayProductSelect as $key => $value) {
            $quote = $this->quoteRepository->getActive($cartId);
            $this->_cart->setQuote($quote);
            $allItems = $quote->getAllItems();
            foreach ($allItems as $item) {
                $itemId = $item->getItemId();
                $this->_cart->removeItem($itemId)->save();
            }
            foreach ($value as $data) {
                $countProduct++;
                $quote = $this->quoteRepository->getActive($cartId);
                $this->_cart->setQuote($quote);
                $product = $this->_productmodel->load($data["id"]);
                $params = array(
                    'form_key' => $this->_formKey->getFormKey(),
                    'product' => $product->getId(), //product Id
                    'qty'   => $data["qty"] //quantity of product
                );
                $this->_cart->addProduct($product, $params);
                $this->_cart->save();
            }
            $newCouponCode = "";
            foreach ($discountCodeStore as $idCoupon => $couponData) {
                if ($idCoupon == $key) {
                    foreach ($couponData as $coupon) {
                        $newCouponCode .= $coupon . ",";
                    }
                }
            }
            $newCouponCode = rtrim($newCouponCode, ", ");
            $quote = $this->quoteRepository->getActive($cartId);
            $quote->setCouponCode($newCouponCode);
            $data = $quote->collectTotals();
            $discountPrice += $data["subtotal"] - $data["subtotal_with_discount"];
            $priceAfterDiscount += $data["subtotal_with_discount"];
        }
        $coupon = $objectManager->create('\Magento\SalesRule\Model\Coupon');
        $saleRule = $objectManager->create('\Magento\SalesRule\Model\Rule');
        $ruleId =   $coupon->loadByCode($couponCode)->getRuleId();
        $rule = $saleRule->load($ruleId);
        if ($rule->getSimpleAction() == "by_percent") {
            $finalDiscount = $priceAfterDiscount - (($priceAfterDiscount / 100) * $rule->getDiscountAmount());
        } else if ($rule->getSimpleAction() == "by_fixed") {
            $finalDiscount = $priceAfterDiscount - ($rule->getDiscountAmount() * $countProduct);
        } else if ($rule->getSimpleAction() == "cart_fixed") {
            $finalDiscount = $priceAfterDiscount - $rule->getDiscountAmount();
        } else {
            $finalDiscount = $priceAfterDiscount;
        }
        return $finalDiscount;
    }

    public function recommendCoupon($cartId, $namestore, $arrayProduct)
    {
        if (!is_numeric($cartId)) {
            $quoteIdMask = $this->quoteIdMaskFactory->create()->load($cartId, 'masked_id');
            $cartId = $quoteIdMask->getQuoteId();
        }
        $quote = $this->quoteRepository->getActive($cartId);
        $currentTime = $this->_stdTimezone->date()->format('Y-m-d');
        $rules = $this->collection->create()
            ->addFieldToFilter('is_active', 1)
            ->addFieldToFilter('to_date', ['gteq' => $currentTime])
            ->addFieldToFilter('coupon_by_seller', $namestore);
        $this->_cart->setQuote($quote);
        $allItems = $quote->getAllItems();
        foreach ($allItems as $item) {
            $itemId = $item->getItemId();
            $this->_cart->removeItem($itemId)->save();
        }
        foreach ($arrayProduct as $arr) {
            $quote = $this->quoteRepository->getActive($cartId);
            $this->_cart->setQuote($quote);
            $product = $this->_productmodel->load($arr["id"]);
            $params = array(
                'form_key' => $this->_formKey->getFormKey(),
                'product' => $product->getId(), //product Id
                'qty'   => $arr["qty"] //quantity of product
            );
            $this->_cart->addProduct($product, $params);
            $this->_cart->save();
        }
        $checkCouponRecommend = 0;
        $arrRules = [];
        $quote = $this->quoteRepository->getActive($cartId);
        foreach ($rules as $key => $rule) {
            $fakeQuote = clone $quote;
            $fakeQuote->setId(null);
            $itemsCart = $this->_cart->getQuote()->getAllItems();
            foreach ($itemsCart as $itemCart) {
                $productId = $itemCart->getProductId();
                $product = $this->_productmodel->load($productId);
                $itemCart = $this->_productmodel->setProduct($product);
                if ($rule->getActions()->validate($product)) {
                    $this->_quoteItem->setQuote($fakeQuote)->setProduct($product);
                    $this->_quoteItem->setAllItems(array($product));
                    $this->_quoteItem->getProduct()->setProductId($product->getEntityId());
                    $validate = $rule->getConditions()->validate($this->_quoteItem);
                    if ($validate == false) {
                        $conditionArr = $rule->getConditions()->getConditions();
                        $result = [];
                        foreach ($conditionArr as $keyCon => $conArr) {
                            $result[$keyCon]["type"] = $conArr->getData("attribute");
                            $result[$keyCon]["value"] = $conArr->getData("value");
                        }
                        $rule->setData("value_recommend_coupon", $result);
                        $arrRules[$key] = $rule->getData();
                        break;
                    }
                } else {
                    $conditionArr = $rule->getConditions()->getConditions();
                    $result = [];
                    foreach ($conditionArr as $keyCon => $conArr) {
                        $result[$keyCon]["type"] = $conArr->getData("attribute");
                        $result[$keyCon]["value"] = $conArr->getData("value");
                    }
                    $rule->setData("value_recommend_coupon", $result);
                    $arrRules[$key] = $rule->getData();
                    break;
                }
            }
        }
        return $arrRules;
    }


    public function listVendorBySkuProduct($listSku)
    {
        $listSeller = [];
        foreach ($listSku as $sku) {
            $product                = $this->productRepository->get($sku);

            if (null != ($product->getVendorId()) && $product->getVendorId() > 0) {
                $objectManager          = \Magento\Framework\App\ObjectManager::getInstance();
                $id = $product->getVendorId();
                $connection = $objectManager->get('Magento\Framework\App\ResourceConnection')->getConnection('\Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION');
                $namestore = $connection->fetchAll("SELECT vendor_id FROM ves_vendor_entity WHERE entity_id = $id");

                if (!in_array($namestore[0]['vendor_id'], $listSeller)) {
                    $listSeller[] = $namestore[0]['vendor_id'];
                }
            }
        }
        return $listSeller;
    }
    public function renderListSeller($arr)
    {
        $listSeller = [];
        foreach ($arr as $val) {
            $listSeller[] = $val['vendor_id'];
        }
        return $listSeller;
    }

    public function getCouponMallPage($idGroup)
    {
        $currentTime = $this->_stdTimezone->date()->format('Y-m-d'); //get all seller have id group
        $data = [];
        $listIdRule = [];
        $listSellerByGroupId = $this->productManagement->getListSellerByGroupId($idGroup);
        if (count($listSellerByGroupId) > 0) {
            //option coupon/rule of seller -- Store Coupon
            foreach ($listSellerByGroupId as $vendorId) {
                $rules = $this->collection->create()
                    ->addFieldToFilter('is_active', 1)
                    ->addFieldToFilter('to_date', ['gteq' => $currentTime])
                    ->addFieldToFilter('coupon_by_seller', $vendorId['vendor_id']);
                if (count($rules) > 0) {
                    $data[$vendorId['vendor_id']] = $rules->getData();
                    foreach ($rules as $rule) {
                        $listIdRule[] = $rule->getId();
                    }
                }
            }

            //option coupon/rule of market place but have product of seller --MKP coupon
            $rules = $this->collection->create()
                ->addFieldToFilter('is_active', 1)
                ->addFieldToFilter('to_date', ['gteq' => $currentTime]);
            if (count($rules) > 0) {
                // $data[$vendorId['vendor_id']] = $rules->getData();
                foreach ($rules as $rule) {
                    $a = $rule->getId();
                    if (!in_array($rule->getId(), $listIdRule)) {
                        // $vendorId       = $rule->getActionCondition()->getConditions()[0]->getValue();
                        $actionJson = $rule->getActionsSerialized();
                        $action = json_decode($actionJson);
                        $action = get_object_vars($action);

                        //option all seller
                        if (!isset($action['conditions'])) {
                            $data['All_Seller'] = $rule->getData();
                            $listIdRule[] = $rule->getId();
                        } else {
                            $conditions = get_object_vars($action['conditions'][0]);
                            //check codition is vendor or product
                            if ($conditions['attribute'] == "vendor_id") {
                                $vendorId = $conditions['value'];

                                $objectManager =   \Magento\Framework\App\ObjectManager::getInstance();
                                $connection = $objectManager->get('Magento\Framework\App\ResourceConnection')->getConnection('\Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION');
                                $vendorIdName = $connection->fetchAll("SELECT vendor_id FROM ves_vendor_entity  WHERE  entity_id = " . $vendorId);

                                foreach ($listSellerByGroupId as $vendor) {
                                    if ($vendor['vendor_id'] == $vendorIdName[0]['vendor_id']) {
                                        $data[$vendor['vendor_id']] = $rule->getData();
                                        $listIdRule[] = $rule->getId();
                                    }
                                }
                            } else if ($conditions['attribute'] == "sku" && count($listSellerByGroupId) > 0) {
                                $listSku = $conditions['value'];
                                $listSku = explode(',', $listSku);
                                $listSellerFromSkuProduct = $this->listVendorBySkuProduct($listSku);
                                $sellerByGroup = $this->renderListSeller($listSellerByGroupId);

                                if (count($listSellerFromSkuProduct) > 0) {
                                    foreach ($listSellerFromSkuProduct as $namestore) {
                                        if (in_array($namestore, $sellerByGroup) && !in_array($rule->getId(), $listIdRule)) {
                                            $data[$namestore] = $rule->getData();
                                            $listIdRule[] = $rule->getId();
                                            break;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        $tmp = [];
        $tmp[] = $data;
        return $tmp;
    }

    public function checkCouponByCollected($userId, $code)
    {
        $collects = $this->getCollectCouponByUser($userId);
        if ($collects)
            foreach ($collects as $collect) {
                if ($code == $collect->getCode()) return true;
            }
        return false;
    }


    public function getAllCouponByField($field, $value, $customerId)
    {
        $results = [];
        $listcoupons = $this->collection->create()
            ->addFieldToFilter('is_active', 1)
            ->addFieldToFilter('coupon_type', 2)
            ->addFieldToFilter('to_date', array(
                array('null' => true),
                array('gteq' => date('Y-m-d'))
            ))
            ->addFieldToFilter('is_visible_in_listing', 1)
            ->addFieldToFilter($field, $value);
        foreach ($listcoupons as $coupon) {
            $flag = false;
            $couponCodeData = $this->ruleFactory->create();
            $couponCodeData->load($coupon->getRuleId());
            $code =  $couponCodeData->getCouponCode();
            if ($customerId) {
                if ($this->checkCouponByCollected($customerId, $code)) continue;
            }

            if ($coupon->getCouponBySeller() == "MARKETPLACE_SELLER") {
                $sellerId = "MKP";
                $flag = $this->getVendorIdByMKPSeller($sellerId, $coupon);
            } else if ($coupon->getCouponBySeller() != "MARKETPLACE_CODE") {
                $flag = $coupon->getCouponBySeller();
            }
            $data = $this->couponApiFactory->create();
            $data->setData($couponCodeData->getData());
            $data->setCode($code);
            if ($flag != false) {
                $info = $this->setVendorOfCoupon($flag, $coupon);
                $data->setVendor($info);
            }
            $results[] = $data;
        }

        return $results;
    }
    // public function getListCouponRecommend()
    // {
    //     return $this->getAllCouponByField('is_recommend', 1);
    // }

    // public function getListCouponAllpage()
    // {
    //     return $this->getAllCouponByField('is_display_all', 1);
    // }
}
