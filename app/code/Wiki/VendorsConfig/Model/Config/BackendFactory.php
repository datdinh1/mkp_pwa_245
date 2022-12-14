<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\VendorsConfig\Model\Config;

class BackendFactory
{
    /**
     * Object manager
     *
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $_objectManager;

    /**
     * @param \Magento\Framework\ObjectManagerInterface $objectmanager
     */
    public function __construct(\Magento\Framework\ObjectManagerInterface $objectmanager)
    {
        $this->_objectManager = $objectmanager;
    }

    /**
     * Create backend model by name
     *
     * @param string $modelName
     * @return \Magento\Framework\App\Config\ValueInterface
     * @throws \InvalidArgumentException
     */
    public function create($modelName)
    {
        $model = $this->_objectManager->create($modelName);
        return $model;
    }
}
