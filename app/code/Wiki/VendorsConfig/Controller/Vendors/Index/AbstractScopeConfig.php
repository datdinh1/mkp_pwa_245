<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Wiki\VendorsConfig\Controller\Vendors\Index;

use Magento\Config\Controller\Adminhtml\System\ConfigSectionChecker;

abstract class AbstractScopeConfig extends \Wiki\VendorsConfig\Controller\Vendors\AbstractConfig
{
    /**
     * @var \Magento\Config\Model\Config
     */
    protected $_backendConfig;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Config\Model\Config\Structure $configStructure
     * @param ConfigSectionChecker $sectionChecker
     * @param \Magento\Config\Model\Config $backendConfig
     */
    public function __construct(
        \Wiki\Vendors\App\Action\Context $context,
        \Magento\Config\Model\Config\Structure $configStructure,
        ConfigSectionChecker $sectionChecker,
        \Magento\Config\Model\Config $backendConfig
    ) {
        $this->_backendConfig = $backendConfig;
        parent::__construct($context, $configStructure, $sectionChecker);
    }

    /**
     * Sets scope for backend config
     *
     * @param string $sectionId
     * @return bool
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    protected function isSectionAllowed($sectionId)
    {
        return true;
    }
}
