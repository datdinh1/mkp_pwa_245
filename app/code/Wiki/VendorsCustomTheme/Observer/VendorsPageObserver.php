<?php

namespace Wiki\VendorsCustomTheme\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Registry;
use Magento\Framework\App\ObjectManager;


class VendorsPageObserver implements ObserverInterface
{
    /**
     * @var Registry
     */
    protected $coreRegistry;
    
    /**
     * @var \Wiki\VendorsCustomTheme\Helper\Data
     */
    protected $helper;
    
    /**
     * @var \Wiki\VendorsCustomTheme\Model\ThemeFactory
     */
    protected $themeFactory;
    
    /**
     * @param Registry $coreRegistry
     * @param \Wiki\VendorsCustomTheme\Model\ThemeFactory $themeFactory
     * @param \Wiki\VendorsCustomTheme\Helper\Data $helper
     */
    public function __construct(
        Registry $coreRegistry,
        \Wiki\VendorsCustomTheme\Model\ThemeFactory $themeFactory,
        \Wiki\VendorsCustomTheme\Helper\Data $helper
    ) {
        $this->coreRegistry = $coreRegistry;
        $this->helper = $helper;
        $this->themeFactory = $themeFactory;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     * @return \Magento\Framework\App\ActionInterface
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
		$vendor = $this->getVendor();
        if (!$vendor || !$vendor->getId()) return;
        $themeId = $this->helper->getVendorTheme($vendor);
        if(!$themeId) return;
        $theme = $this->themeFactory->create()->load($themeId);
        if (!$theme->getThemeId() || !$theme->isEnabled()) return;
        
		if(class_exists('Wiki\VendorsCms\Helper\Page')){
		    $cmsHelper = ObjectManager::getInstance()->get('Wiki\VendorsCms\Helper\Page');
		    $pageIdentifier = $cmsHelper->getVendorHomePage();
		    if($pageIdentifier) return;
		}
		
		$condition = $observer->getCondition();
		if(!trim($condition->getRequestPath())){
		    /*Vendor home page*/
		    $request = $condition->getRequest();
		    
		    $condition->setRequestPath('themepage/view');
		}
    }

    /**
     * @return mixed|\Wiki\Vendors\Model\Vendor
     */
    public function getVendor()
    {
        return $this->coreRegistry->registry('vendor');
    }
}
