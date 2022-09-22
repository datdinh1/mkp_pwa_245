<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Wiki\VendorsSalesRule\Model;

use Magento\Catalog\Model\ProductRepository;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollection;
use Magento\SalesRule\Model\Rule\Condition\AddressFactory as RuleConditionAddress;
use Magento\SalesRule\Model\RuleRepository;
use Magento\SalesRule\Model\CouponRepository;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\CatalogRule\Model\CatalogRuleRepository;
use Wiki\VendorsCoupon\Model\Api\CouponFactory as CouponApiFactory;
use Wiki\Vendors\Model\VendorFactory;
use Wiki\VendorsSalesRule\Model\CollectCouponFactory as WikiCollectionSalesRule;
use Wiki\Vendors\Model\SellerManagement;
use Wiki\VendorsCoupon\Model\CouponManagement;
use Wiki\VendorsProduct\Model\Api\Data\SellerDataFactory;
use Wiki\Vendors\Model\GroupFactory;
use Wiki\VendorsSalesRule\Helper\Data;
use Wiki\VendorsCoupon\Api\CouponManagementInterface;
use Magento\SalesRule\Model\RuleFactory as ModelRuleFactory;
use Wiki\VendorsCoupon\Model\Api\ItemsFactory;

/**
 * Handle various customer account actions
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @SuppressWarnings(PHPMD.TooManyFields)
 * @SuppressWarnings(PHPMD.ExcessiveClassComplexity)
 * @SuppressWarnings(PHPMD.CookieAndSessionMisuse)
 */
class SalesRuleManagement
{

    /**
     * @var ItemsFactory
     */
    protected $itemsPageFactory;

    /**
     * @var ModelRuleFactory
     */
    protected $modelRuleFactory;

    protected $couponManagementInterface;


    /**
     * @var GroupFactory
     */
    protected $groupVendor;

    /**
     * @var SellerDataFactory
     */
    protected $sellerDataFactory;

    protected $couponManagement;

    protected $coupon;

    protected $saleRule;

    protected $productRuleFactory;

    /**
     * Object manager
     *
     * @var \Magento\Framework\ObjectManagerInterface
     */
    private $_objectManager;

    protected $sellerManagement;

    /**
     * @var ResourceModel\Rule
     */
    protected $ruleResource;

    /**
     * @var RuleFactory
     */
    protected $ruleFactory;

    protected $ruleMagento;

    protected $CouponMagento;

    protected $ruleCatalogMagento;

    protected $customerRepository;

    /**
     * @var DateTime
     */
    protected $date;
    /**
     * @var \Magento\SalesRule\Api\RuleRepositoryInterface
     */
    protected $ruleRepositoryInterface;

    /**
     * @var CouponApiFactory
     */
    protected $couponApiFactory;

    /**
     * @var VendorFactory
     */
    protected $vendorFactory;

    /**
     * @var WikiCollectionSalesRule
     */
    protected $wikiCollectionSalesRule;

    /**
     * @var ProductRepository
     */
    protected $productRepository;

    /**
     * @var ProductCollection
     */
    protected $productCollection;

    /**
     * @var RuleConditionAddress
     */
    protected $ruleConditionAddress;

    /**
     * @var Data
     */
    protected $helperData;

    /**
     * @param \Magento\SalesRule\Api\RuleRepositoryInterface $ruleRepositoryInterface
     * @param DateTime $date
     *
     * @param ResourceModel\Rule $ruleResource
     * @param RuleFactory $ruleFactory
     *
     */
    public function __construct(
        ItemsFactory $itemsPageFactory,
        ModelRuleFactory          $modelRuleFactory,
        CouponManagementInterface  $couponManagementInterface,
        GroupFactory $groupVendor,
        SellerDataFactory $sellerDataFactory,
        CouponManagement $couponManagement,
        \Magento\SalesRule\Model\Coupon $coupon,
        \Magento\SalesRule\Model\Rule $saleRule,
        \Magento\SalesRule\Model\Rule\Condition\ProductFactory $productRuleFactory,
        \Magento\Framework\ObjectManagerInterface        $objectManager,
        SellerManagement                                 $sellerManagement,
        \Magento\SalesRule\Api\RuleRepositoryInterface   $ruleRepositoryInterface,
        RuleRepository                                   $ruleMagento,
        CouponRepository                                 $CouponMagento,
        \Wiki\Vendors\Model\Vendor                       $vendorsModel,
        \Magento\SalesRule\Model\CouponFactory           $couponFactory,
        DateTime                                         $date,
        \Magento\Customer\Model\Customer                 $customerModel,
        \Magento\CatalogRule\Model\RuleFactory           $ruleFactory,
        \Magento\CatalogRule\Model\ResourceModel\Rule    $ruleResource,
        \Magento\Indexer\Model\Indexer\CollectionFactory $indexerCollectionFactory,
        \Magento\Customer\Api\CustomerRepositoryInterfaceFactory $customerRepositoryFactory,
        CatalogRuleRepository                            $ruleCatalogMagento,
        WikiCollectionSalesRule                          $wikiCollectionSalesRule,
        CouponApiFactory $couponApiFactory,
        \Magento\SalesRule\Model\ResourceModel\Rule\CollectionFactory  $collection,
        ProductRepository                                $productRepository,
        ProductCollection                                $productCollection,
        RuleConditionAddress                             $ruleConditionAddress,
        VendorFactory                                    $vendorsFactory,
        Data                                             $helperData
    ) {
        $this->modelRuleFactory         = $modelRuleFactory;
        $this->couponManagementInterface                 = $couponManagementInterface;
        $this->groupVendor              = $groupVendor;
        $this->sellerDataFactory        = $sellerDataFactory;
        $this->couponManagement         = $couponManagement;
        $this->coupon                   = $coupon;
        $this->saleRule                 = $saleRule;
        $this->productRuleFactory       = $productRuleFactory;
        $this->_objectManager           = $objectManager;
        $this->sellerManagement         = $sellerManagement;
        $this->ruleMagento              = $ruleMagento;
        $this->CouponMagento            = $CouponMagento;
        $this->_vendorsModel            = $vendorsModel;
        $this->couponFactory            = $couponFactory;
        $this->date                     = $date;
        $this->_customerModel           = $customerModel;
        $this->ruleFactory              = $ruleFactory;
        $this->ruleResource             = $ruleResource;
        $this->indexerCollectionFactory = $indexerCollectionFactory;
        $this->ruleCatalogMagento       = $ruleCatalogMagento;
        $this->customerRepository       = $customerRepositoryFactory->create();
        $this->ruleRepositoryInterface  = $ruleRepositoryInterface;
        $this->couponApiFactory         = $couponApiFactory;
        $this->vendorsFactory           = $vendorsFactory;
        $this->collection               = $collection;
        $this->productRepository        = $productRepository;
        $this->productCollection        = $productCollection;
        $this->ruleConditionAddress     = $ruleConditionAddress;
        $this->wikiCollectionSalesRule  = $wikiCollectionSalesRule;
        $this->helperData               = $helperData;
        $this->itemsPageFactory         = $itemsPageFactory;
    }
    public function checkSkuOfVendor($listSku, $vendor)
    {
        $listItemsVendor = $this->sellerManagement->getItemsByVendorId($vendor);
        $listSkuVendor = [];
        if (empty($listItemsVendor)) return false;
        foreach ($listItemsVendor as $item) {
            $listSkuVendor[] = $item->getSku();
        }
        if (count($listSkuVendor) == 0) return false;
        foreach ($listSku as $sku) {
            if (!in_array($sku, $listSkuVendor)) return false;
        }
        return true;
    }
    public function createCouponSalesRule($rule)
    {
        $vendor = $this->vendorsFactory->create()->loadByVendorId($rule->getVendorId());
        /** @var $model \Magento\SalesRule\Model\Rule */
        $model = $this->_objectManager->create(\Magento\SalesRule\Model\Rule::class);
        // $model->setData($rule->getData());
        $tmpData = [];
        $tmpData = $rule->getData();
        $tmpData['uses_per_customer'] = 100;
        $tmpData['is_active'] = 1;
        $tmpData['is_advanced'] = 1;
        $tmpData['coupon_type'] = 2;
        $tmpData['is_rss'] = 1;
        $tmpData['website_ids'] = [1];
        $tmpData['customer_group_ids'] = [0, 1, 2, 3];
        $tmpData['is_visible_in_listing'] = 1;
        $tmpData['discount_qty'] = 1;

        $model->setData($tmpData);
        $model->setCouponCode($rule->getCode());
        $actions = $this->productRuleFactory->create();
        $actions->setType('Magento\SalesRule\Model\Rule\Condition\Product');
        if ($tmpData['type'] == 'product_coupon') {
            $listSkuProduct = implode(",", $tmpData['list_sku']);
            if (!$this->checkSkuOfVendor($tmpData['list_sku'], $tmpData['vendor_id'])) return false;
            $actions->setAttribute('sku');
            $actions->setOperator('()');
            $actions->setValue($listSkuProduct);
        } else {
            $actions->setAttribute('vendor_id');
            $actions->setOperator('==');
            $actions->setValue($vendor->getId());
        }
        $model->getActions()->addCondition($actions);

        if ($rule->getMinimumPrice()) {
            $condition = $this->ruleConditionAddress->create();
            $condition->setType('Magento\SalesRule\Model\Rule\Condition\Address')
                ->setAttribute('base_subtotal')
                ->setOperator('>')
                ->setValue($rule->getMinimumPrice());
            $model->getConditions()->addCondition($condition);
        }

        if (isset($tmpData['image']) && $tmpData['image'] != "string") {
            $image = $this->helperData->uploadImage($tmpData['image']);
            if ($image) {
                $model->setImage($image);
            }
        }

        $ruleSave       = $model->save();
        $idRule         = $ruleSave->getRuleId();
        $vendorId   = $tmpData['vendor_id'];
        $objectManager  = \Magento\Framework\App\ObjectManager::getInstance();
        $connection     = $objectManager->get('Magento\Framework\App\ResourceConnection')->getConnection('\Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION');

        try {
            if (isset($vendorId)) {
                //save field
                $data           = ["coupon_by_seller" => $vendorId];
                $where          = ['rule_id = ?' => (int)$idRule];
                $tableSaleRule  = $connection->getTableName('salesrule');
                $updatedRows    = $connection->update($tableSaleRule, $data, $where);
            }
            return true;
        } catch (AuthenticationException $e) {
            return "Invalid login or password.";
        }
    }

    public function updateCouponSalesRule($id, $rules)
    {
        $vendor = $this->vendorsFactory->create()->loadByVendorId($rules->getVendorId());
        $model = $this->saleRule->load($id);
        if (!$model->getData()) {
            return false;
        }

        $deleteImage = $model->getImage();
        $model->addData($rules->getData());

        /** reset actions default */
        $action['type'] = "Magento\SalesRule\Model\Rule\Condition\Product\Combine";
        $action['aggregator'] = "all";
        $action['value'] = 1;
        $action['new_child'] = "";
        $actions[1] = $action;
        $data['actions'] = $actions;
        /** reset conditions default */
        $condition['type'] = "Magento\SalesRule\Model\Rule\Condition\Combine";
        $condition['aggregator'] = "all";
        $condition['value'] = 1;
        $condition['new_child'] = "";
        $conditions[1] = $condition;
        $data['conditions'] = $conditions;
        $model->loadPost($data);

        $actions = $this->productRuleFactory->create();
        $actions->setType('Magento\SalesRule\Model\Rule\Condition\Product');
        if ($rules->getType() == 'product_coupon') {
            $actions->setAttribute('sku');
            $actions->setOperator('()');
            $actions->setValue(implode(",", $rules->getListSku()));
        } else {
            $actions->setAttribute('vendor_id');
            $actions->setOperator('==');
            $actions->setValue($vendor->getId());
        }
        $model->getActions()->addCondition($actions);

        if ($rules->getMinimumPrice()) {
            $condition = $this->ruleConditionAddress->create();
            $condition->setType('Magento\SalesRule\Model\Rule\Condition\Address')
                ->setAttribute('base_subtotal')
                ->setOperator('>')
                ->setValue($rules->getMinimumPrice());
            $model->getConditions()->addCondition($condition);
        }

        if ($rules->getImage() && $rules->getImage() != "string") {
            $image = $this->helperData->uploadImage($rules->getImage());
            if ($image) {
                $this->helperData->deleteImage($deleteImage);
                $model->setImage($image);
            }
        } else if ($rules->getImage() || $rules->getImage() == "") {
            $this->helperData->deleteImage($deleteImage);
            $model->setImage('');
        }

        $model->save();
        return true;
    }

    public function deleteCouponSalesRule($id)
    {
        $model = $this->saleRule->load($id);
        if ($model->getData()) {
            $model->delete();
            return true;
        }
        return false;
    }

    public function getCouponSalesRule($id)
    {
        $model = $this->saleRule->load($id);
        if (!$model->getCouponCode()) {
            return false;
        }
        $value = [];
        $actions = $model->getActions()->getActions();
        if ($actions) {
            foreach ($actions as $action) {
                if ($action->getAttribute() == "sku") {
                    if ($action->getOperator() == "()") {
                        $value = array_merge($value, explode(',', $action->getValue()));
                    }
                    if ($action->getOperator() == "==") {
                        $value[] = $action->getValue();
                    }
                }
            }
        }

        $ruleCoupon = $this->couponApiFactory->create();
        $ruleCoupon->setData($model->getData());
        $ruleCoupon->setCode($model->getCouponCode());
        if ( $model->getPrimaryCoupon() ){
            $codeGenerate = $model->getPrimaryCoupon()->getAutoGenerate();
            $ruleCoupon->setCodeGenerate($codeGenerate ? $codeGenerate : '');
        }
        $ruleCoupon->setListSku($value);

        /** get info vendor if it isset */
        $flag = false;
        if ($model->getCouponBySeller() == "MARKETPLACE_SELLER") {
            $sellerId = "MKP";
            $flag = $this->couponManagement->getVendorIdByMKPSeller($sellerId, $model);
        } else if ($model->getCouponBySeller() != "MARKETPLACE_CODE") {
            $flag = $model->getCouponBySeller();
        }
        if ($flag != false) {
            $info = $this->couponManagement->setVendorOfCoupon($flag, $model);
            $ruleCoupon->setVendor($info);
        }
        return $ruleCoupon;
    }

    public function checkCouponCode($couponCode)
    {
        $couponCode = trim($couponCode);
        $couponFac = $this->couponFactory->create();
        $collection = $couponFac->loadByCode($couponCode)->getId();

        if ($collection) {
            return true;
        }
        return false;
    }

    public function getAllPromotionByVendorId($vendorID)
    {
        try {
            $vendor                 = $this->_vendorsModel->loadByIdentifier($vendorID);
            $id                     = $vendor->getId();
            $customer               = $this->_customerModel->setWebsiteId(1)->loadByEmail($vendor->getEmail());
            $customerVendor         = $this->_vendorsModel->loadByCustomer($customer);
            $objectManager  = \Magento\Framework\App\ObjectManager::getInstance();

            if (count($customerVendor->getData()) == 0) {
                return "This is not account Seller";
            } else {
                // $invoice = $this->collectionInvoice->create();
                // $collection  = $invoice->getCollection()->addFilter('vendor_id', $id);

                // $tmp[] = $collection->getData();

                /** @var \Magento\CatalogRule\Model\Rule $rule */
                $rule = $this->ruleFactory->create();
                // $ruleCollection = $rule->getCollection()->addFieldToFilter('rule_id',2);
                $data = $rule->getCollection()->addFieldToFilter('vendor_id', $vendorID)->getData();
                return $data;
            }
        } catch (AuthenticationException $e) {
            return "Invalid login or password.";
        }
    }
    public function getPromotionRunningByVendorId($vendorID, $statusTime)
    {
        $data = $this->getAllPromotionByVendorId($vendorID);
        $tmp = [];
        $today = strtotime(date('Y-m-d'));
        $statusTime = trim($statusTime);
        foreach ($data as $value) {
            $fromDate = strtotime($value['from_date']);
            $toDate = strtotime($value['to_date']);


            if ($value['is_active'] == 1) {


                if ($statusTime == 'RUNNING') {

                    if ($today >=  $fromDate && $today <= $toDate) {
                        $tmp[] = $value;
                    }
                } else if ($statusTime == 'SOON') {

                    if ($today <  $fromDate) {
                        $tmp[] = $value;
                    }
                } else if ($statusTime == 'EXPIRE') {

                    if ($today >  $toDate) {
                        $tmp[] = $value;
                    }
                }
            }
        }
        return $tmp;
    }

    /**
     * @inheritdoc
     */
    public function createPromotion($data)
    {
        $ruleCata = $this->ruleFactory->create();
        if (isset($data["rule_id"])) {
            $ruleCata->setRuleId($data['rule_id']);
        }
        $ruleCata->setName($data['name']);
        $ruleCata->setDescription($data['description']);
        $ruleCata->setFromDate($data['from_date']);
        $ruleCata->setToDate($data['to_date']);
        $ruleCata->setIsActive($data['is_active']);
        //$ruleCata->setConditions($data['conditions_serialized']);
        $ruleCata->setActions($data['actions_serialized']);
        $ruleCata->setStopRulesProcessing($data['stop_rules_processing']);
        $ruleCata->setSortOrder($data['sort_order']);
        $ruleCata->setSimpleAction($data['simple_action']);
        $ruleCata->setDiscountAmount($data['discount_amount']);
        $ruleCata->setVendorId($data['vendor_id']);
        $ruleCata->setData('conditions_serialized', $data['conditions_serialized']);

        $ruleCata->setWebsiteIds($data['website_ids']);
        $ruleCata->setCustomerGroupIds($data['customer_group_ids']);
        $ruleCata->save();

        $tmp = [];
        $tmp[] = $ruleCata->getData();

        $indexers = $this->indexerCollectionFactory->create()->getItems();
        foreach ($indexers as $indexer) {
            $indexer->reindexAll();
        }
        return $tmp;
    }

    /**
     * @inheritdoc
     */
    public function deleteById($ruleId)
    {
        return $this->ruleCatalogMagento->deleteById($ruleId);
    }

    public function checkCouponCollected($code, $id)
    {
        $collects = $this->getCollectCouponByUser($id);
        if ($collects)
            foreach ($collects as $collect) {
                if ($code == $collect->getCode())
                    return true;
            }
        return false;
    }

    /**
     * @inheritdoc
     */
    public function collectCouponSalesRule($code, $customer_id)
    {
        //check user isset
        try {
            $checkUser = $this->customerRepository->getById($customer_id);
        } catch (\Exception $e) {
            return false;
        }
        //check code isset 

        $checkCodeIsCollect = $this->checkCouponCollected($code, $customer_id);
        if ($checkCodeIsCollect) return true;


        //check rule  
        try {
            $ruleId =   $this->coupon->loadByCode($code)->getRuleId();
            $rule = $this->saleRule->load($ruleId);
        } catch (\Exception $e) {
            return false;
        }
        if (empty($ruleId)) return false;

        $collection = $this->wikiCollectionSalesRule->create()->getCollection()
            ->addFieldToFilter('customer_id', $customer_id)
            ->addFieldToFilter('rule_id', $ruleId);

        if (!empty($collection->getData()))
            return $this->wikiCollectionSalesRule->create()->setData($collection->getData()[0]);

        $collect = $this->wikiCollectionSalesRule->create();
        $data = [
            'customer_id'   => $customer_id,
            'rule_id'       => $ruleId,
            'code'          => $code
        ];
        $collect->setData($data);
        $collect->save();

        return true;
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
                $flag = $this->couponManagement->getVendorIdByMKPSeller($sellerId, $rule);
            } else {
                $flag = $rule->getCouponBySeller();
            }

            if ($flag != false) {
                $info = $this->couponManagement->setVendorOfCoupon($flag, $rule);
                $data->setVendor($info);
            }

            $dataRule[] = $data;
        }
        return $dataRule ?: null;
    }

    public function removeCollectCouponByUser($customerId, $ruleId)
    {
        $collection = $this->wikiCollectionSalesRule->create()->getCollection();
        $collection->addFieldToFilter('customer_id', $customerId)->addFieldToFilter('rule_id', $ruleId);
        if ( $collection->getSize() == 1 ){
            $collection->getLastItem()->delete();
            return true;
        }
        return false;
    }

    public function getListCouponRecommend($customerId)
    {
        return $this->couponManagement->getAllCouponByField('is_recommend', 1, $customerId);
    }

    public function getListCouponAllpage($customerId)
    {
        return $this->couponManagement->getAllCouponByField('is_display_all', 1, $customerId);
    }

    public function getCouponCodeByRuleId($id)
    {

        $couponCodeData = $this->couponFactory->create()
            ->getCollection()
            ->addFieldToFilter('rule_id', $id)->getFirstItem();

        $listCode = $couponCodeData->getcode();
        return $listCode ? $listCode : [];
    }
   
    public function getListCouponByVendorId($vendorId, $status = null, $pageSize = null, $currentPage = null)
    {
        return $this->couponManagementInterface->getListCouponByVendorId($vendorId, $status, $pageSize, $currentPage);
    }

    public function getCouponsAllCategory($customerId, $pageSize, $currentPage)
    {
        $listIdCategory = $result = [];
        $listcoupons = $this->collection->create()
            ->addFieldToFilter('is_active', 1)
            ->addFieldToFilter('coupon_type', 2)
            ->addFieldToFilter('to_date', array(
                array('null' => true),
                array('gteq' => date('Y-m-d'))
            ))
            ->addFieldToFilter('is_visible_in_listing', 1);

        foreach ($listcoupons as $coupon) {
            $listIdCategory[] = $coupon->getCategoryId();
        }
        $listIdCategory = array_unique($listIdCategory);

        foreach ($listIdCategory as $id) {
            $couponById = $this->getCouponsByCategoryId($customerId, $id, $pageSize, $currentPage);
            if(!empty($couponById)){
                $result[] =  $couponById;
            }
        }
        return  $result;
    }

    public function getCouponsByCategoryId($customerId, $category, $pageSize, $currentPage)
    {

        $rulesIds = $dataRule =  [];
        $listcoupons = $this->collection->create()
            ->addFieldToFilter('is_active', 1)
            ->addFieldToFilter('coupon_type', 2)
            ->addFieldToFilter('to_date', array(
                array('null' => true),
                array('gteq' => date('Y-m-d'))
            ))
            ->addFieldToFilter('is_visible_in_listing', 1);
        if (!empty($category)) {
            $listcoupons->addFieldToFilter('category_id', $category);
        }
        foreach ($listcoupons as $coupon) {
            $couponCodeData = $this->modelRuleFactory->create();
            $couponCodeData->load($coupon->getRuleId());
            $code =  $couponCodeData->getCouponCode();
            if ($customerId) {
                if ($this->couponManagementInterface->checkCouponByCollected($customerId, $code)) continue;
            }

            $rulesIds[] = $coupon->getRuleId();
        }


       
        if (count($rulesIds) >0 ) {
            $pageSize = $pageSize ? $pageSize : 10;
            $rules = $this->collection->create()->addFieldToFilter('rule_id', $rulesIds);
            $countTotal = count($rulesIds);
            $rules->setPageSize($pageSize)->setCurPage($currentPage);

            foreach ($rules as $rule) {
                $flag = false;
                if ($rule->getCouponBySeller() == "MARKETPLACE_SELLER") {
                    $sellerId = "MKP";
                    $flag = $this->couponManagementInterface->getVendorIdByMKPSeller($sellerId, $rule);
                } else if ($rule->getCouponBySeller() != "MARKETPLACE_CODE") {
                    $flag = $rule->getCouponBySeller();
                }
                $couponCodeData = $this->modelRuleFactory->create();
                $couponCodeData->load($rule->getRuleId());
                $code =  $couponCodeData->getCouponCode();

                $data = $this->couponApiFactory->create();
                $data->setData($couponCodeData->getData());
                
                $data->setCode($code);
                if ($flag != false) {
                    $info = $this->couponManagementInterface->setVendorOfCoupon($flag, $rule);
                    $data->setVendor($info);
                }
                $dataRule[] = $data;
            }
            $dataItems = $this->itemsPageFactory->create();
            $infoCategory = $this->helperData->getCategoryById($category);
            $dataItems->setCategory($infoCategory);
            $dataItems->setItems($dataRule ?: []);
            $dataItems->setTotalCount($countTotal);
            return $dataItems;
        } else return [];
       
    }

    public function getCouponsByCategory($customerId, $category = null, $pageSize = null, $currentPage = null)
    {
        if ($category == 'all'  || empty($category)) {
            return $this->getCouponsAllCategory($customerId, $pageSize, $currentPage);
        } else if (!empty($category)) {
            $result[] =  $this->getCouponsByCategoryId($customerId, $category, $pageSize, $currentPage);
            return $result;
        }
    }
}
