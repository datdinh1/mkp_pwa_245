<?php

/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Wiki\VendorsProduct\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use \Wiki\VendorsProduct\Model\Source\Approval;
use Magento\Reports\Model\ResourceModel\Product\Sold\CollectionFactory as ReportCollectionFactory;
use Magento\Catalog\Model\ProductRepository;
use Magento\Catalog\Model\ResourceModel\Eav\AttributeFactory;

/**
 * @SuppressWarnings(PHPMD.LongVariable)
 */
class Data extends AbstractHelper
{
    const XML_CATALOG_ALLOW_VENDOR_SET_WEBSITE  = 'vendors/catalog/can_set_website';
    const XML_CATALOG_NEW_PRODUCT_APPROVAL      = 'vendors/catalog/new_product_approval';
    const XML_CATALOG_UPDATE_PRODUCT_APPROVAL   = 'vendors/catalog/update_product_approval';
    const XML_CATALOG_UPDATE_ATTRIBUTE_APPROVAL_FLAG   = 'vendors/catalog/attribute_approval_flag';
    const XML_CATALOG_UPDATE_ATTRIBUTE_APPROVAL   = 'vendors/catalog/attribute_approval';
    const XML_CATALOG_EMAIL_SENDER              = 'vendors/catalog/sender_email_identity';
    const XML_CATALOG_ADMIN_EMAIL               = 'vendors/catalog/admin_email_identity';
    const XML_CATALOG_PRODUCT_TYPE_RESTRICTION  = 'vendors/catalog/product_type_restriction';
    const XML_CATALOG_ATTRIBUTE_SET_RESTRICTION = 'vendors/catalog/attribute_set_restriction';
    const XML_CATALOG_ATTRIBUTE_RESTRICTION     = 'vendors/catalog/attribute_restriction';
    const XML_CATALOG_NEW_PRODUCT_APPROVAL_EMAIL_ADMIN      = 'vendors/catalog/new_product_approval_email_admin';
    const XML_CATALOG_UPDATE_PRODUCT_APPROVAL_EMAIL_ADMIN   = 'vendors/catalog/update_product_approval_email_admin';
    const XML_CATALOG_PRODUCT_APPROVED_EMAIL_VENDOR         = 'vendors/catalog/product_approved_email_vendor';
    const XML_CATALOG_UPDATE_PRODUCT_APPROVED_EMAIL_VENDOR  = 'vendors/catalog/update_product_approved_email_vendor';
    const XML_CATALOG_PRODUCT_DENIED_EMAIL_VENDOR           = 'vendors/catalog/product_denied_email_vendor';
    const XML_CATALOG_UPDATE_PRODUCT_DENIED_EMAIL_VENDOR    = 'vendors/catalog/update_product_denied_email_vendor';

    protected $productFactory;

    /**
     * @var AttributeFactory
     */
    protected $atrributeFactory;


    /**
     * These attributes will not be saved from vendor cpanel.
     * @var array
     */
    protected $_notAllowedProductAttributes;

    /**
     * @var \Wiki\Vendors\Helper\Email
     */
    protected $_emailHelper;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * These attributes will not be saved from vendor cpanel.
     * @var array
     */
    protected $_joinProductAttribute;

    /**
     * @var ReportCollectionFactory
     */
    protected $reportCollectionFactory;

    /**
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Framework\App\Route\Config $routeConfig
     * @param \Magento\Framework\Locale\ResolverInterface $locale
     * @param \Wiki\Vendors\Model\UrlInterface $backendUrl
     * @param \Magento\Backend\Model\Auth $auth
     * @param \Wiki\Vendors\App\Area\FrontNameResolver $frontNameResolver
     * @param \Magento\Framework\Math\Random $mathRandom
     * @param array $notSaveVendorAttribute
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Wiki\Vendors\Helper\Email $emailHelper,
        ReportCollectionFactory $reportCollectionFactory,
        array $notAllowedProductAttributes = [],
        array $joinProductAttribute = [],
        ProductRepository $productRepository,
        AttributeFactory $atrributeFactory,
        \Magento\Catalog\Model\ProductFactory $productFactory
    ) {
        parent::__construct($context);
        $this->scopeConfig                  = $context->getScopeConfig();
        $this->_notAllowedProductAttributes = $notAllowedProductAttributes;
        $this->_joinProductAttribute        = $joinProductAttribute;
        $this->reportCollectionFactory      = $reportCollectionFactory;
        $this->_emailHelper                 = $emailHelper;
        $this->productRepository            = $productRepository;
        $this->atrributeFactory             = $atrributeFactory;
        $this->productFactory               = $productFactory;
    }


    /**
     * Get the list of product attributes which will not be used on vendor cpanel.
     * @return array
     */
    public function getJoinProductAttribute()
    {
        return $this->_joinProductAttribute;
    }


    /**
     * Get the list of product attributes which will not be used on vendor cpanel.
     * @return array
     */
    public function getNotUsedVendorAttributes()
    {
        $attributeRestriction = $this->scopeConfig->getValue(self::XML_CATALOG_ATTRIBUTE_RESTRICTION);
        $attributeRestriction = $attributeRestriction ? explode(',', $attributeRestriction) : [];

        return array_merge($this->_notAllowedProductAttributes, $attributeRestriction);
    }

    /**
     * Can vendor set website id for product
     * 
     * @return boolean
     */
    public function canVendorSetWebsite()
    {
        return (bool)$this->scopeConfig->getValue(self::XML_CATALOG_ALLOW_VENDOR_SET_WEBSITE);
    }

    /**
     * Is Required approval for new products
     * @return boolean
     */
    public function isNewProductsApproval()
    {
        return $this->scopeConfig->getValue(self::XML_CATALOG_NEW_PRODUCT_APPROVAL);
    }

    /**
     * Is Required approval for updating product info
     * @return boolean
     */
    public function isUpdateProductsApproval()
    {
        return $this->scopeConfig->getValue(self::XML_CATALOG_UPDATE_PRODUCT_APPROVAL);
    }


    /**
     * Is Required approval for updating product info
     * @return boolean
     */
    public function getUpdateProductsApprovalFlag()
    {
        return $this->scopeConfig->getValue(self::XML_CATALOG_UPDATE_ATTRIBUTE_APPROVAL_FLAG);
    }

    /**
     * Is Required approval for updating product info
     * @return array|null
     */
    public function getUpdateProductsApprovalAttributes()
    {
        return explode(",", $this->scopeConfig->getValue(self::XML_CATALOG_UPDATE_ATTRIBUTE_APPROVAL));
    }

    /**
     * If the product have these approval status, it will be displayed in frontend.
     * @return array
     */
    public function getAllowedApprovalStatus()
    {
        return [
            Approval::STATUS_APPROVED,
            Approval::STATUS_PENDING_UPDATE,
        ];
    }
    /**
     * Send new product approval notification email to admin.
     * @param \Magento\Catalog\Model\Product $product
     * @param \Wiki\Vendors\Model\Vendor $vendor
     */
    public function sendNewProductApprovalEmailToAdmin(
        \Magento\Catalog\Model\Product $product,
        \Wiki\Vendors\Model\Vendor $vendor
    ) {
        $adminEmail = $this->scopeConfig->getValue(self::XML_CATALOG_ADMIN_EMAIL, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        if (!$adminEmail) {
            return;
        }
        $adminEmail = str_replace(" ", "", $adminEmail);
        $adminEmail = explode(",", $adminEmail);
        try {
            $this->_emailHelper->sendTransactionEmail(
                self::XML_CATALOG_NEW_PRODUCT_APPROVAL_EMAIL_ADMIN,
                \Magento\Framework\App\Area::AREA_FRONTEND,
                self::XML_CATALOG_EMAIL_SENDER,
                $adminEmail,
                ['product' => $product, 'vendor' => $vendor]
            );
        } catch (\Exception $e) {
        }
    }

    /**
     * Send Update product approval notification email to admin
     * @param \Magento\Catalog\Model\Product $product
     * @param \Wiki\Vendors\Model\Vendor $vendor
     */
    public function sendUpdateProductApprovalEmailToAdmin(
        \Magento\Catalog\Model\Product $product,
        \Wiki\Vendors\Model\Vendor $vendor
    ) {
        $adminEmail = $this->scopeConfig->getValue(self::XML_CATALOG_ADMIN_EMAIL, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        if (!$adminEmail) {
            return;
        }
        $adminEmail = str_replace(" ", "", $adminEmail);
        $adminEmail = explode(",", $adminEmail);

        try {
            $this->_emailHelper->sendTransactionEmail(
                self::XML_CATALOG_UPDATE_PRODUCT_APPROVAL_EMAIL_ADMIN,
                \Magento\Framework\App\Area::AREA_FRONTEND,
                self::XML_CATALOG_EMAIL_SENDER,
                $adminEmail,
                ['product' => $product, 'vendor' => $vendor]
            );
        } catch (\Exception $e) {
        }
    }

    /**
     * Send new product approved notification email to vendor
     * @param \Magento\Catalog\Model\Product $product
     * @param \Wiki\Vendors\Model\Vendor $vendor
     */
    public function sendProductApprovedEmailToVendor(
        \Magento\Catalog\Model\Product $product,
        \Wiki\Vendors\Model\Vendor $vendor
    ) {
        try {
            $this->_emailHelper->sendTransactionEmail(
                self::XML_CATALOG_PRODUCT_APPROVED_EMAIL_VENDOR,
                \Magento\Framework\App\Area::AREA_FRONTEND,
                self::XML_CATALOG_EMAIL_SENDER,
                $vendor->getCustomer()->getEmail(),
                ['product' => $product, 'vendor' => $vendor]
            );
        } catch (\Exception $e) {
        }
    }

    /**
     * Send update product approved notification email to vendor
     * @param \Magento\Catalog\Model\Product $product
     * @param \Wiki\Vendors\Model\Vendor $vendor
     */
    public function sendUpdateProductApprovedEmailToVendor(
        \Magento\Catalog\Model\Product $product,
        \Wiki\Vendors\Model\Vendor $vendor,
        \Wiki\VendorsProduct\Model\ResourceModel\Product\Update\Collection $updateCollection
    ) {
        try {
            $this->_emailHelper->sendTransactionEmail(
                self::XML_CATALOG_UPDATE_PRODUCT_APPROVED_EMAIL_VENDOR,
                \Magento\Framework\App\Area::AREA_FRONTEND,
                self::XML_CATALOG_EMAIL_SENDER,
                $vendor->getCustomer()->getEmail(),
                ['product' => $product, 'vendor' => $vendor, 'updates' => $updateCollection]
            );
        } catch (\Exception $e) {
        }
    }

    /**
     * Send new product unapproved notification email to vendor
     * @param \Magento\Catalog\Model\Product $product
     * @param \Wiki\Vendors\Model\Vendor $vendor
     */
    public function sendProductUnapprovedEmailToVendor(
        \Magento\Catalog\Model\Product $product,
        \Wiki\Vendors\Model\Vendor $vendor
    ) {
        try {
            $this->_emailHelper->sendTransactionEmail(
                self::XML_CATALOG_PRODUCT_DENIED_EMAIL_VENDOR,
                \Magento\Framework\App\Area::AREA_FRONTEND,
                self::XML_CATALOG_EMAIL_SENDER,
                $vendor->getCustomer()->getEmail(),
                ['product' => $product, 'vendor' => $vendor]
            );
        } catch (\Exception $e) {
        }
    }

    /**
     * Send update product unapproved notification email to vendor
     * @param \Magento\Catalog\Model\Product $product
     * @param \Wiki\Vendors\Model\Vendor $vendor
     */
    public function sendUpdateProductUnapprovedEmailToVendor(
        \Magento\Catalog\Model\Product $product,
        \Wiki\Vendors\Model\Vendor $vendor,
        \Wiki\VendorsProduct\Model\ResourceModel\Product\Update\Collection $updateCollection
    ) {
        try {
            $this->_emailHelper->sendTransactionEmail(
                self::XML_CATALOG_UPDATE_PRODUCT_DENIED_EMAIL_VENDOR,
                \Magento\Framework\App\Area::AREA_FRONTEND,
                self::XML_CATALOG_EMAIL_SENDER,
                $vendor->getCustomer()->getEmail(),
                ['product' => $product, 'vendor' => $vendor, 'updates' => $updateCollection]
            );
        } catch (\Exception $e) {
        }
    }

    /**
     * Get product type restriction
     * @return \Magento\Framework\App\Config\mixed
     */
    public function getProductTypeRestriction()
    {
        return explode(",", $this->scopeConfig->getValue(self::XML_CATALOG_PRODUCT_TYPE_RESTRICTION));
    }

    /**
     * Get attribute set restriction
     * @return \Magento\Framework\App\Config\mixed
     */
    public function getAttributeSetRestriction()
    {
        return explode(",", $this->scopeConfig->getValue(self::XML_CATALOG_ATTRIBUTE_SET_RESTRICTION));
    }

    public function getSoldQtyByProductId($productId)
    {
        $soldProducts = $this->reportCollectionFactory->create();
        $soldProducts->addOrderedQty()->addAttributeToFilter('product_id', $productId);

        if (!$soldProducts->count())
            return 0;

        $product = $soldProducts->getFirstItem();
        return (int)$product->getData('ordered_qty');
    }

    public function checkAuctionProduct($sku)
    {
        $productOfSku = $this->productRepository->get($sku);
        $extension = $productOfSku->getExtensionAttributes();
        if ($extension->getIsAuctions()) {
            return true;
        }

        return false;
    }

    public function setJsonAttributeProduct($frontendLabel, $attributeCode, $options)
    {

        $data = [
            "is_wysiwyg_enabled" => false,
            "is_html_allowed_on_front" => false,
            "used_for_sort_by" => false,
            "is_filterable" => true,
            "is_filterable_in_search" => true,
            "is_used_in_grid" => true,
            "is_visible_in_grid" => false,
            "is_filterable_in_grid" => true,
            "position" => 0,
            "apply_to" => [],
            "is_searchable" => "1",
            "is_visible_in_advanced_search" => "1",
            "is_comparable" => "1",
            "is_used_for_promo_rules" => "0",
            "is_visible_on_front" => "0",
            "used_in_product_listing" => "1",
            "is_visible" => true,
            "scope" => "global",
            "frontend_input" => "select",
            "entity_type_id" => "4",
            "is_required" => false,
            "is_user_defined" => true,
            // "default_frontend_label" => $attributeCode,
            "frontend_labels" => null,
            "backend_type" => "int",
            "source_model" => "Magento\Eav\Model\Entity\Attribute\Source\Table",
            "default_value" => "",
            "is_unique" => "0",
            //"options" => $options,
            "attribute_code" => $attributeCode,
        ];
        $model = $this->atrributeFactory->create();
        $model->setData($data);
        $model->setDefaultFrontendLabel($frontendLabel)->setOptions($options);
        //$model->setAttributeCode($attributeCode)->setOptions($options);
        return $model;
    }

    public function setAttributeValueToProduct($sku , $productVariants){
        $product = $this->productRepository->get($sku);
        if(!$product){
            return false;
        }
        foreach ($productVariants as $attr) {
            $attributeCode = $attr->getAttributeCode();
            $optionLabel = $attr->getOptions()[0]->getLabel();
            $productTmp = $this->productFactory->create();
            $isAttributeExist = $productTmp->getResource()->getAttribute($attributeCode);

            if ($isAttributeExist && $isAttributeExist->usesSource()) {
                $attributeValue = $isAttributeExist->getSource()->getOptionId($optionLabel);
                $product->setData($attributeCode, $attributeValue);
            }
        }
        
        try {
            return $product->save();
        } catch (\Exception $ex) {
            return false;
        }
    }
    public function setConfigProductConfigurable($sku, $listAttribute, $associatedProductIds)
    {
        $productConfig = $this->productRepository->get($sku);
        if (!$productConfig) return false;

        $productConfig->getTypeInstance()->setUsedProductAttributeIds($listAttribute, $productConfig);
        $configurableAttributesData = $productConfig->getTypeInstance()->getConfigurableAttributesAsArray($productConfig);
        
        $productConfig->setCanSaveConfigurableAttributes(true);
        $productConfig->setConfigurableAttributesData($configurableAttributesData);
        $productConfig->setConfigurableProductsData([]);

        $productConfig->setAssociatedProductIds($associatedProductIds); // Setting Associated Products
        $productConfig->setCanSaveConfigurableAttributes(true);

        try {
            return $productConfig->save();
        } catch (\Exception $ex) {
            return false;
        }
    }
}
