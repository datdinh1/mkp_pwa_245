<?php
/**
 * Default application path for backend area
 *
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\Vendors\App;

class DefaultPath implements \Magento\Framework\App\DefaultPathInterface
{
    /**
     * @var array
     */
    protected $_parts;

    /**
     * @param \Magento\Backend\App\ConfigInterface $config
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function __construct(\Wiki\Vendors\App\ConfigInterface $config)
    {
        $pathParts = explode('/', $config->getValue('web/default/vendors'));

        $this->_parts = [
            'area' => isset($pathParts[0]) ? $pathParts[0] : '',
            'module' => isset($pathParts[1]) ? $pathParts[1] : 'vendors',
            'controller' => isset($pathParts[2]) ? $pathParts[2] : 'index',
            'action' => isset($pathParts[3]) ? $pathParts[3] : 'index',
        ];
    }

    /**
     * Retrieve default path part by code
     *
     * @param string $code
     * @return string
     */
    public function getPart($code)
    {
        return isset($this->_parts[$code]) ? $this->_parts[$code] : null;
    }
}
