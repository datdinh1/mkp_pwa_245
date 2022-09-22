<?php
namespace Wiki\VendorsProduct\Model\Plugin;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Api\Data\ProductExtensionFactory;
use Magento\SalesRule\Model\ResourceModel\Rule\CollectionFactory;
use Wiki\Vendors\Model\VendorFactory;
use Wiki\Vendors\Model\GroupFactory;
use Wiki\VendorsProduct\Helper\Data as WikiVendorsProductData;
use Wiki\VendorsConfig\Helper\Data as WikiVendorData;
use Wiki\VendorsProduct\Model\Api\Data\SellerDataFactory;
use Wiki\VendorsProduct\Model\Api\Data\ProductVariantsFactory;

class ProductAttributeGroupSeller
{
    protected $ruleCollectionFactory;
    protected $productExtensionFactory;
    protected $vendor;
    protected $configHelper;
    protected $groupVendor;
    protected $sellerDataFactory;

    /**
     * @var WikiVendorsProductData
     */
    protected $wikiVendorsProductData;

    /**
     * @var ProductVariantsFactory
     */
    protected $attributeProductVariants;

    public function __construct(
        ProductExtensionFactory         $productExtensionFactory,
        CollectionFactory               $ruleCollectionFactory,
        WikiVendorData                  $configHelper,
        GroupFactory                    $groupVendor,
        SellerDataFactory               $sellerDataFactory,
        WikiVendorsProductData          $wikiVendorsProductData,
        VendorFactory                   $vendor,
        ProductVariantsFactory          $attributeProductVariants
    ) 
    {
        $this->productExtensionFactory  = $productExtensionFactory;
        $this->ruleCollectionFactory    = $ruleCollectionFactory;
        $this->configHelper             = $configHelper;
        $this->groupVendor              = $groupVendor;
        $this->sellerDataFactory        = $sellerDataFactory;
        $this->wikiVendorsProductData   = $wikiVendorsProductData;
        $this->vendor                   = $vendor;
        $this->attributeProductVariants = $attributeProductVariants;
    }

    public function afterGet(
        ProductRepositoryInterface      $subject,
        ProductInterface                $product
    ){
        /** Get Current Extension Attributes from Product */
        $productExtension = $product->getExtensionAttributes();
        $extensionAttributes = $productExtension ? $productExtension : $this->productExtensionFactory->create();
        $seller = $this->seller($product);
        if ( $seller !== false ){
            $extensionAttributes->setVendor($seller);
        }

        /** add attribute product variant to configurable product */
        if ( method_exists($product->getTypeInstance(), 'getUsedProducts') && $product->getVendorId() ){
            $attributeOptions = $product->getTypeInstance()->getConfigurableAttributesAsArray($product);
            foreach ( $attributeOptions as $attribute ){
                if ( strpos($attribute["attribute_code"], "v_") === 0 ){
                    $attributeInterface = $this->attributeProductVariants->create();
                    $attributeInterface->setData($attribute);
                    $dataAttribute[] = $attributeInterface;
                }

            }
            if ( isset($dataAttribute) && !empty($dataAttribute) ){
                $extensionAttributes->setProductVariants($dataAttribute);
            }
        }
        $extensionAttributes->setIsFreeship($this->checkProductFreeShip($product));
        $product->setExtensionAttributes($extensionAttributes);
        /** add sold product */
        $product->setData('sold', $this->wikiVendorsProductData->getSoldQtyByProductId($product->getId()));
       // $product->getResource()->saveAttribute($product, 'sold');
        return $product;
    }

    public function afterGetList($subject, $searchCriteria) 
    {
        $products = [];
        foreach ( $searchCriteria->getItems() as $key => $entity ){
            /** Get Current Extension Attributes from Product */
            $productExtension = $entity->getExtensionAttributes();
            $extensionAttributes = $productExtension ? $productExtension : $this->productExtensionFactory->create();
            $seller = $this->seller($entity);
            if ( $seller !== false ){
                $extensionAttributes->setVendor($seller);
            }
            $extensionAttributes->setIsFreeship($this->checkProductFreeShip($entity));
            $entity->setExtensionAttributes($extensionAttributes);
            /** add sold product */
            $entity->setData('sold', $this->wikiVendorsProductData->getSoldQtyByProductId($entity->getId()));
            $entity->getResource()->saveAttribute($entity, 'sold');
            $products[$key] = $entity;  
        }
        $searchCriteria->setItems($products);
        return $searchCriteria;
    }

    /**
     * @param Magento\Catalog\Model\Product\Interceptor
     * @return int
     */
    protected function seller($product)
    {
        $info = $this->sellerDataFactory->create();
        $vendorId = $product->getVendorId();
        if ( empty($vendorId) )
            return false;
        $logoSeller = $this->getLogoSeller($vendorId);
        $storeName = $this->getStoreNameSeller($vendorId);
        $vendor = $this->vendor->create()->load($vendorId);
        $groupId = empty($vendor->getData()) ? 0 : $vendor->getGroupId();
        $groupName = $this->groupVendor->create()->load($groupId)->getVendorGroupCode();
        $info->setData(empty($vendor->getData()) ? null : $vendor->getData());
        $info->setGroupName($groupName);
        $info->setLogo($logoSeller);
        $info->setStoreName($storeName);
        return $info;
    }

    protected function getLogoSeller($vendorId)
    {   $basePath = 'ves_vendors/logo/';
        $img = $this->configHelper->getVendorConfig('general/store_information/logo_image_seller', $vendorId);
        return empty($img) ? null : $basePath . $img;
    }

    public function getStoreNameSeller($vendorId){
        $storeName = $this->configHelper->getVendorConfig('general/store_information/name', $vendorId);
        return empty($storeName) ? null : $storeName;
    }

    /**
     * @param Magento\Catalog\Model\Product\Interceptor
     * @return int
     */
    protected function checkProductFreeShip($product)
    {
        $sku = $product->getSku();
        $rules = $this->ruleCollectionFactory->create()
                        ->addFieldToFilter('is_active', 1)
                        ->addFieldToFilter('to_date', ['gteq' => date('Y-m-d')])
                        ->addFieldToFilter('coupon_type', 2)
                        ->addFieldToFilter('is_visible_in_listing', 1);
                    
        foreach ( $rules as $rule ){
            $value = $rule->getActions()->getData()['actions'];
            if ( !empty($value) ){
                $value = $value[0]->getValue();
                if ( in_array($sku, explode(',', preg_replace('/\s+/', '', $value))) ){
                    return true;
                }
            }
        }
        return false;
    }
}