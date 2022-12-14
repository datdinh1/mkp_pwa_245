<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

/**
 * Create product attribute set selector
 *
 * @author     Magento Core Team <core@magentocommerce.com>
 */
namespace Wiki\VendorsProduct\Block\Vendors\Product\Edit;

class AttributeSet extends \Wiki\Vendors\Block\Vendors\Widget\Form
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    /**
     * Get options for suggest widget
     *
     * @return array
     */
    public function getSelectorOptions()
    {
        return [
            'source' => $this->getUrl('catalog/product/suggestAttributeSets'),
            'className' => 'category-select',
            'showRecent' => true,
            'storageKey' => 'product-template-key',
            'minLength' => 0,
            'currentlySelected' => $this->_coreRegistry->registry('product')->getAttributeSetId()
        ];
    }
}
