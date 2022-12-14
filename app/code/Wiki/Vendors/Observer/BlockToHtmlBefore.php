<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\Vendors\Observer;

use Magento\Framework\Event\ObserverInterface;

class BlockToHtmlBefore implements ObserverInterface
{

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;
    
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;
    
    /**
     * @var \Wiki\Vendors\Helper\Data
     */
    protected $_vendorHelper;
    
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Framework\Registry $coreRegistry,
        \Wiki\Vendors\Helper\Data $vendorHelper
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->_coreRegistry = $coreRegistry;
        $this->_vendorHelper = $vendorHelper;
    }
    
    /**
     * Add the notification if there are any vendor awaiting for approval.
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $block = $observer->getBlock();
        $moduleNames = $this->_coreRegistry->registry('Wiki_vendors_modules_use_template_from_adminhtml');
        if ($moduleNames === null) {
            /*In the default set all payment method module to use template from adminhtml area.*/
            $paymentMethodData = $this->scopeConfig->getValue('payment');
            $moduleNames = [];
            foreach ($paymentMethodData as $paymentData) {
                if (!isset($paymentData['model'])) {
                    continue;
                }
                $model = explode("\\", $paymentData['model']);
                if (sizeof($model) < 2) {
                    continue;
                }
                
                $moduleName = $model[0]."_".$model[1];
                $moduleNames[$moduleName] = $moduleName;
            }
            
            $moduleNames = array_merge($moduleNames, $this->_vendorHelper->getModulesUseTemplateFromAdminhtml());

            $this->_coreRegistry->register('Wiki_vendors_modules_use_template_from_adminhtml', $moduleNames);
        }
        
        $blockClassNames = $this->_coreRegistry->registry('Wiki_vendors_blocks_use_template_from_adminhtml');
        if ($blockClassNames === null) {
            $blockClassNames = $this->_vendorHelper->getBlocksUseTemplateFromAdminhtml();
            $this->_coreRegistry->register('Wiki_vendors_blocks_use_template_from_adminhtml', $blockClassNames);
        }

        $blockClass = get_class($block);
        $moduleName = $block->extractModuleName($blockClass);
        $blockClass = trim($blockClass, "\\");
        
        if (in_array($moduleName, $moduleNames) || in_array($blockClass, $blockClassNames)) {
            $block->setArea('adminhtml');
        }
    }
}
