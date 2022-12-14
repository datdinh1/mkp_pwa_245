<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

// @codingStandardsIgnoreFile

namespace Wiki\Vendors\Block\Vendors\Widget\Form\Renderer;

use Magento\Framework\Data\Form\Element\AbstractElement;

/**
 * Form fieldset default renderer
 *
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Fieldset extends \Magento\Backend\Block\Template implements \Magento\Framework\Data\Form\Element\Renderer\RendererInterface
{
    /**
     * @var AbstractElement
     */
    protected $_element;

    /**
     * @var string
     */
    protected $_template = 'Wiki_Vendors::widget/form/renderer/fieldset.phtml';

    /**
     * @return AbstractElement
     */
    public function getElement()
    {
        return $this->_element;
    }

    /**
     * @param AbstractElement $element
     * @return string
     */
    public function render(AbstractElement $element)
    {
        $this->_element = $element;
        return $this->toHtml();
    }
}
