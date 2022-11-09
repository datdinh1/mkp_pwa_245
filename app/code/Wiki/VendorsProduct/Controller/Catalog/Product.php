<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\VendorsProduct\Controller\Catalog;

use Wiki\Vendors\App\Action\Frontend\Context;
use Magento\Catalog\Controller\Adminhtml\Product\Builder;

/**
 * Catalog product controller
 * @SuppressWarnings(PHPMD.NumberOfChildren)
 */
abstract class Product extends \Wiki\Vendors\Controller\AbstractAction
{
    /**
     * @var \Magento\Catalog\Controller\Adminhtml\Product\Builder
     */
    protected $productBuilder;

    /**
     * @param \Wiki\Vendors\App\Action\Context $context
     * @param \Wiki\Vendors\App\ConfigInterface $config
     * @param Registry $coreRegistry
     * @param Date $dateFilter
     * @param \Magento\Catalog\Controller\Adminhtml\Product\Builder $productBuilder
     */
    public function __construct(
        Context $context,
        Builder $productBuilder
    ) {
        $this->productBuilder = $productBuilder;
        parent::__construct($context);
    }
}
