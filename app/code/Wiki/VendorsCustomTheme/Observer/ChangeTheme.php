<?php

namespace Wiki\VendorsCustomTheme\Observer;

use Magento\Framework\Event\ObserverInterface;
use Wiki\VendorsCredit\Model\CreditProcessor\OrderPayment;
use Wiki\VendorsCredit\Model\CreditProcessor\ItemCommission;

class ChangeTheme implements ObserverInterface
{
    /**
     * @var \Wiki\VendorsCustomTheme\Model\Design
     */
    protected $_vendorDesign;
    
    /**
     * @var \Magento\Framework\Registry
     */
    protected $_registry;
    
    /**
     * @var \Wiki\VendorsCustomTheme\Model\ThemeFactory
     */
    protected $_themeFactory;
    
    /**
     * @var \Wiki\VendorsCustomTheme\Helper\Data
     */
    protected $helper;
    
    /**
     * @param \Magento\Framework\Registry $registry
     * @param \Wiki\VendorsCustomTheme\Model\ThemeFactory $themeFactory
     * @param \Wiki\VendorsCustomTHeme\Helper\Data $helper
     * @param \Wiki\VendorsCustomTheme\Model\Design $vendorDesign
     */
    public function __construct(
        \Magento\Framework\Registry $registry,
        \Wiki\VendorsCustomTheme\Model\ThemeFactory $themeFactory,
        \Wiki\VendorsCustomTheme\Helper\Data $helper,
        \Wiki\VendorsCustomTheme\Model\Design $vendorDesign
    ){
        $this->_vendorDesign = $vendorDesign;
        $this->_registry = $registry;
        $this->_themeFactory = $themeFactory;
        $this->helper = $helper;
    }

    /**
     * Add multiple vendor order row for each vendor.
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return self
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $om = \Magento\Framework\App\ObjectManager::getInstance();
        $config = $om->get('Magento\Framework\App\Config\ScopeConfigInterface');
        $vendor = $this->_registry->registry('vendor');
        if(!$vendor || !$vendor->getId()) return;
        
        $themeId = $this->helper->getVendorTheme($vendor);
        
        $theme = $this->_themeFactory->create()->load($themeId);
        if ($theme->getThemeId() && $theme->isEnabled()) {
            // Check theme register or not
            if (!$this->_registry->registry('vendor_custom_theme')) {
                $this->_registry->register('vendor_custom_theme', $theme);
            }
            $this->_vendorDesign->applyCustomDesign($theme);
        }
        return $this;
    }
}
