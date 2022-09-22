<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\Vendors\Block\Vendors\Page;

/**
 * Vendor footer block
 *
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Footer extends \Wiki\Vendors\Block\Vendors\AbstractBlock
{
    /**
     * @var \Magento\Framework\Module\ModuleList
     */
    protected $_moduleList;
    
    /**
     * @var \Wiki\Vendors\Helper\Data
     */
    protected $_helper;
    
    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Wiki\Vendors\Model\UrlInterface $url
     * @param \Wiki\Vendors\Helper\Data $vendorHelper
     * @param \Magento\Framework\App\DeploymentConfig $deploymentConfig
     * @param \Magento\Framework\Component\ComponentRegistrarInterface $componentRegistrar
     * @param \Magento\Framework\Filesystem\Directory\ReadFactory $readFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Wiki\Vendors\Model\UrlInterface $url,
        \Wiki\Vendors\Helper\Data $vendorHelper,
        \Magento\Framework\App\DeploymentConfig $deploymentConfig,
        \Magento\Framework\Component\ComponentRegistrarInterface $componentRegistrar,
        \Magento\Framework\Filesystem\Directory\ReadFactory $readFactory,
        array $data = []
    ) {
        $this->_helper              = $vendorHelper;
        $this->deploymentConfig     = $deploymentConfig;
        $this->componentRegistrar   = $componentRegistrar;
        $this->readFactory          = $readFactory;
        parent::__construct($context, $url, $data);
        $this->setCacheLifetime(2592000); /*30 days*/
    }
    
    /**
     * Get module composer version
     *
     * @param $moduleName
     * @return \Magento\Framework\Phrase|string|void
     */
    public function getComposerVersion($moduleName)
    {
        $path = $this->componentRegistrar->getPath(
            \Magento\Framework\Component\ComponentRegistrar::MODULE,
            $moduleName
        );
        $directoryRead = $this->readFactory->create($path);
        $composerJsonData = $directoryRead->readFile('composer.json');
        $data = json_decode($composerJsonData);
    
        return !empty($data->version) ? $data->version : false;
    }
    
    /**
     * Get current version of the extension.
     * @return string
     */
    public function getVersion()
    {
        return $this->getComposerVersion('Wiki_Vendors');
        /* 
        if (!$this->_moduleList) {
            $om = \Magento\Framework\App\ObjectManager::getInstance();
            $this->_moduleList = $om->create("Magento\Framework\Module\ModuleList");
        }
        $extensionInfo = $this->_moduleList->getOne('Wiki_Vendors');
        return $extensionInfo['setup_version']; */
    }
    
    /**
     * Get footer text
     *
     * @return string
     */
    public function getFooterText()
    {
        return $this->_helper->getFooterText();
    }
}
