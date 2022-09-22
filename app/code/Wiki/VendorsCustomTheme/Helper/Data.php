<?php
namespace Wiki\VendorsCustomTheme\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\ObjectManager;

/**
 * @SuppressWarnings(PHPMD.LongVariable)
 */
class Data extends AbstractHelper
{
    const XML_PATH_ENABLE_REGISTRATION_FORM = 'vendors/custom_theme/register_form';
    const XML_PATH_VENDOR_SELECTED_THEME    = 'custom_theme/general/theme';
    
    
    const XML_PATH_THEME_CONFIG_HOME_CONTENT = 'custom_theme/home/content';

    const XML_PATH_VENDOR_CUSTOM_THEME  = 'custom_theme/enabled';

    /**
     * @var \Wiki\VendorsConfig\Helper\Data
     */
    protected $configHelper;
		
    /**
		 * @var string[]
		 */
		protected $notAllowedConfigGroupPaths;
		
		 /**
		 * @var string[]
		 */
		protected $notAllowedConfigFieldPaths;
		
    /**
     * @param Context $context
     * @param \Wiki\VendorsConfig\Helper\Data $configHelper
		 * @param string[] $notAllowedConfigGroupPaths
		 * @param string[] $notAllowedConfigFieldPaths
     */
    public function __construct(
        Context $context,
        \Wiki\VendorsConfig\Helper\Data $configHelper,
				$notAllowedConfigGroupPaths = [],
				$notAllowedConfigFieldPaths = []
    ) {
        $this->configHelper = $configHelper;
				$this->notAllowedConfigGroupPaths = $notAllowedConfigGroupPaths;
				$this->notAllowedConfigFieldPaths = $notAllowedConfigFieldPaths;
        parent::__construct($context);
    }
    
    /**
     * @return boolean
     */
    public function isEnableForRegister(){
        return (bool)$this->scopeConfig->getValue(self::XML_PATH_ENABLE_REGISTRATION_FORM);
    }
    
    /**
     * Get vendor theme
     * 
     * @param int|\Wiki\Vendors\Model\Vendor $vendorId
     */
    public function getVendorTheme($vendorId){
        $om = ObjectManager::getInstance();
        if($vendorId instanceof \Wiki\Vendors\Model\Vendor){
            $vendor = $vendorId;
            $vendorId = $vendorId->getId();
        }else{
            $vendor = $om->create('Wiki\Vendors\Model\Vendor')->load($vendorId);
        }

        if (
            class_exists('Wiki\VendorsGroup\Helper\Data')
        ){
            /** @var \Wiki\VendorsGroup\Helper\Data $groupHelper */
            $groupHelper = $om->create('Wiki\VendorsGroup\Helper\Data');
            if(!$groupHelper->getConfig(self::XML_PATH_VENDOR_CUSTOM_THEME, $vendor->getGroupId())){
                return '';
            }
        }

        return $this->configHelper->getVendorConfig(self::XML_PATH_VENDOR_SELECTED_THEME, $vendorId);
    }
		
    /**
     * @return string[]
     */
    public function getNotAllowedConfigGroupPaths(){
            return $this->notAllowedConfigGroupPaths;
    }
    
    /**
     * @return string[]
     */
    public function getNotAllowedConfigFieldPaths(){
            return $this->notAllowedConfigFieldPaths;
    }

    public function getFonts() {
        return [
            ['css-name' => 'Lato', 'font-name' => __('Lato')],
            ['css-name' => 'Open+Sans', 'font-name' => __('Open Sans')],
            ['css-name' => 'Roboto', 'font-name' => __('Roboto')],
            ['css-name' => 'Roboto Slab', 'font-name' => __('Roboto Slab')],
            ['css-name' => 'Oswald', 'font-name' => __('Oswald')],
            ['css-name' => 'Source+Sans+Pro', 'font-name' => __('Source Sans Pro')],
            ['css-name' => 'PT+Sans', 'font-name' => __('PT Sans')],
            ['css-name' => 'PT+Serif', 'font-name' => __('PT Serif')],
            ['css-name' => 'Droid+Serif', 'font-name' => __('Droid Serif')],
            ['css-name' => 'Josefin+Slab', 'font-name' => __('Josefin Slab')],
            ['css-name' => 'Montserrat', 'font-name' => __('Montserrat')],
            ['css-name' => 'Ubuntu', 'font-name' => __('Ubuntu')],
            ['css-name' => 'Titillium+Web', 'font-name' => __('Titillium Web')],
            ['css-name' => 'Noto+Sans', 'font-name' => __('Noto Sans')],
            ['css-name' => 'Lora', 'font-name' => __('Lora')],
            ['css-name' => 'Playfair+Display', 'font-name' => __('Playfair Display')],
            ['css-name' => 'Bree+Serif', 'font-name' => __('Bree Serif')],
            ['css-name' => 'Vollkorn', 'font-name' => __('Vollkorn')],
            ['css-name' => 'Alegreya', 'font-name' => __('Alegreya')],
            ['css-name' => 'Noto+Serif', 'font-name' => __('Noto Serif')],
            ['css-name' => 'Libre+Baskerville', 'font-name' => __('Libre Baskerville')],
            ['css-name' => 'Poppins', 'font-name' => __('Poppins')]
        ];
    }
}
