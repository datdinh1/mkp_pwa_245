<?php

namespace Wiki\VendorsCustomTheme\Observer;

use Magento\Framework\Event\ObserverInterface;
use Wiki\VendorsConfig\Helper\Data;
use Wiki\VendorsCustomTheme\Helper\Data as Helper;

class ProcessFieldConfig implements ObserverInterface
{
    public function __construct(
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Wiki\Vendors\Model\Session $vendorSession,
        \Magento\Framework\Module\Manager $moduleManager
    ) {
        $this->_objectManager = $objectManager;
        $this->_vendorSession = $vendorSession;
        $this->moduleManager = $moduleManager;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $vendorGroupId = $this->_vendorSession->getVendor()->getGroupId();
        if (
            !class_exists('Wiki\VendorsGroup\Helper\Data') ||
            !$this->moduleManager->isOutputEnabled('Wiki_VendorsGroup')
        ) return;

        /** @var \Wiki\VendorsGroup\Helper\Data $groupHelper */
        $groupHelper = $this->_objectManager->create('Wiki\VendorsGroup\Helper\Data');
        if(
            !$this->getConfigName($observer,'custom_theme') ||
            $groupHelper->getConfig(Helper::XML_PATH_VENDOR_CUSTOM_THEME, $vendorGroupId)
        ) return;

        $transport = $observer->getTransport();
        $html = '<div class="alert alert-danger alert-dismissible">
                <h4><i class="icon fa fa-ban"></i> '.__('Warning !').'</h4>'
                .__('You are not allowed to access this feature.').'
              </div>';
        $transport->setHtml($html);
        $transport->setForceReturn(true);
    }

    public function getConfigName(\Magento\Framework\Event\Observer $observer, $name){
        $transport = $observer->getTransport();
        foreach ($transport->getFieldset()->getElements() as $field){
            if(strpos((string)$field->getId(), $name) !== false){
                return true;
            }
        }
        return false;
    }
}
