<?php

namespace Wiki\VendorsCustomTheme\Block\Adminhtml\System\Config\Form\Field;

class Theme extends \Magento\Config\Block\System\Config\Form\Field
{
    protected function _getElementHtml(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $html = $element->getElementHtml();
        $block = $this->getLayout()->createBlock('Wiki\VendorsCustomTheme\Block\Adminhtml\System\Config\Form\Field\Theme\ThemeList');
        $block->setElement($element);

        return $block->toHtml();
    }
    
}
