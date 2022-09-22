<?php

namespace Wiki\VendorsCustomTheme\Controller\ThemePage;

use Magento\Framework\Registry;
use \Magento\Framework\App\Action\Context;

class View extends \Magento\Framework\App\Action\Action
{
    /**
     * @var Registry
     */
    protected $coreRegistry;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var \Wiki\VendorsPage\Helper\Data
     */
    protected $pageHelper;

    /**
     * @param Context $context
     * @param Registry $coreRegistry
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Wiki\VendorsPage\Helper\Data $pageHelper
     */
    public function __construct(
        Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\View\Element\Context $viewContext,
        Registry $coreRegistry,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Wiki\VendorsPage\Helper\Data $pageHelper,
        \Wiki\VendorsCustomTheme\Helper\AdditionData $helper,
        \Wiki\VendorsCustomTheme\Model\ResourceModel\Theme\Config\Collection $configCollection
    ) {
        $this->coreRegistry         = $coreRegistry;
        $this->scopeConfig          = $viewContext->getScopeConfig();
        $this->resultPageFactory    = $resultPageFactory;
        $this->pageHelper           = $pageHelper;
        $this->helper               = $helper;
        $this->_storeManager        = $storeManager;
        $this->_configCollection     = $configCollection;
        parent::__construct($context);
    }

    /**
     * View CMS page action.
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Framework\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->addHandle('vendor_page');
        /* $resultPage->getConfig()->setPageLayout(''); */
        $resultPage->addHandle('vendorstheme_page_view');
        $currentTheme = $this->coreRegistry->registry('vendor_custom_theme');
        if($layoutUpdate = $currentTheme->getHomeLayoutXml()){
            $resultPage->getLayout()->getUpdate()->addUpdate($layoutUpdate);
        }
        $pageConfig = $resultPage->getConfig();
        $pageConfig->setPageLayout($currentTheme->getHomeLayout());

        $url = $this->helper->getCssUrl($currentTheme->getThemeId());
        $link = '<link  rel="stylesheet" type="text/css"  media="all" href="'.$url .'" /> ';
        $this->getResponse()->appendBody($link);
        $defaultconfigTheme = $currentTheme->getAllConfigs();
        $currentConfigTheme = $this->_configCollection->addFieldToFilter('theme_id', $currentTheme->getThemeId())->addFieldToFilter('vendor_id', $this->getVendor()->getId());
        if(count($currentConfigTheme) > 0){
            $this->addCurrentBodyClasses($currentConfigTheme);
        }else{
            $this->addDefaultBodyClasses($defaultconfigTheme);
        }
        $vendor = $this->getVendor();
//        count($currentTheme)
        $title = $this->pageHelper->getMetaTitle($vendor->getId());
        $title = $title?$title:__("%1's home page", ucfirst($vendor->getVendorId()));
        $pageConfig->getTitle()->set($title);

        $description = $this->pageHelper->getMetaDescription($vendor->getId());
        $pageConfig->setDescription($description);

        $keywords = $this->pageHelper->getMetaKeywords($vendor->getId());
        if ($keywords) {
            $pageConfig->setKeywords($keywords);
        }


        return $resultPage;
    }

    /**
     * Get vendor
     * @return \Wiki\Vendors\Model\Vendor
     */
    public function getVendor(){
        return $this->coreRegistry->registry('vendor');
    }

    /**
     * Add default body classes for current page layout
     *
     * @return $this
     */
    protected function addDefaultBodyClasses($defaultconfigTheme)
    {
        $pageConfig =  $this->resultPageFactory->create()->getConfig();
        foreach($defaultconfigTheme as $path => $value){
            // $elementId = str_replace('/','_', $path);
            $fruits_arr = explode('/', $path);
            if($fruits_arr[1] == "general"){
                if($fruits_arr[2] == "maximum_page_width"){
                    if($value != 'width1200'){
                        $pageConfig->addBodyClass($value);
                    }
                }
                if($fruits_arr[2] == "layout_style"){
                    $pageConfig->addBodyClass($value);
                }
            }
        }
        return $this;
    }

    /**
     * Add default body classes for current page layout
     *
     * @return $this
     */
    protected function addCurrentBodyClasses($currentConfigTheme)
    {
        $pageConfig =  $this->resultPageFactory->create()->getConfig();
        foreach($currentConfigTheme as $config){
            $fruits_ar = explode('/', $config["path"]);
            if($fruits_ar[1] == "general"){
                if($fruits_ar[2] == "maximum_page_width"){
                    if($config["value"] != 'width1200'){
                        $pageConfig->addBodyClass($config["value"]);
                    }
                }
                if($fruits_ar[2] == "layout_style"){
                    $pageConfig->addBodyClass($config["value"]);
                }
            }
        }
        return $this;
    }

    	/* Get system store config */
	public function getStoreConfig($node, $storeId = NULL){
		if($storeId != NULL){
			return $this->scopeConfig->getValue($node, \Magento\Store\Model\ScopeInterface::SCOPE_STORE, $storeId);
		}
		return $this->scopeConfig->getValue($node, \Magento\Store\Model\ScopeInterface::SCOPE_STORE, $this->getStore()->getId());
    }

    public function getStore(){
		return $this->_storeManager->getStore();
	}
}
