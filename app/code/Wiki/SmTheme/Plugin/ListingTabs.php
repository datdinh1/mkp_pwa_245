<?php
namespace Wiki\SmTheme\Plugin;


class ListingTabs
{
    /**
     * @var \Magento\Framework\Event\Manager
     */
    protected $eventManager;

    /**
     * @var \Magento\Framework\Module\Manager
     */
    protected $moduleManager;
    
    /**
     * @param \Magento\Framework\Event\Manager $eventManager
     * @param \Magento\Framework\Module\Manager $moduleManager
     */
    public function __construct(
        \Magento\Framework\Event\Manager $eventManager,
        \Magento\Framework\Module\Manager $moduleManager
    ) {
        $this->eventManager = $eventManager;
        $this->moduleManager = $moduleManager;
    }

    /**
     * Modify the product collection of Sm FilterProducts extension
     * 
     * @param \Sm\FilterProducts\Block\FilterProducts $subject
     * @param \Closure $method
     * @return unknown
     */
    public function around_getProductsBasic(
        \Sm\ListingTabs\Block\ListingTabs $subject,
        \Closure $method,
        $catids = null,
        $count = false ,
        $tab = false
    ){
        $collection = $method($catids, $count, $tab);
        if(!$collection instanceof \Magento\Catalog\Model\ResourceModel\Product\Collection) return $collection;
        $collection->addAttributeToFilter('approval', \Wiki\VendorsProduct\Model\Source\Approval::STATUS_APPROVED);
        if ($this->moduleManager->isOutputEnabled('Wiki_Quotation')) {
            $collection->addAttributeToSelect('ves_enable_order')
                ->addAttributeToSelect('ves_enable_quote');
        }elseif($this->moduleManager->isOutputEnabled('Wiki_VendorsListingFee')){
            $collection->addAttributeToFilter('listing_fee', \Wiki\VendorsListingFee\Model\Source\ListingFee::LISTING_FEE_PAID);
        }
        $this->eventManager->dispatch('sm_theme_filterproducts_collection', ['collection' => $collection]);
        return $collection;
    }
}