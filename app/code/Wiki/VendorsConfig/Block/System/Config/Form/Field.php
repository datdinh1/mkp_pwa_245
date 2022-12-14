<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

// @codingStandardsIgnoreFile

/**
 * Abstract config form element renderer
 *
 * @author     Magento Core Team <core@magentocommerce.com>
 *
 */
namespace Wiki\VendorsConfig\Block\System\Config\Form;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @SuppressWarnings(PHPMD.NumberOfChildren)
 */
class Field extends \Magento\Config\Block\System\Config\Form\Field
{
    
    /**
     * Retrieve HTML markup for given form element
     *
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return string
     */
    public function render(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $isCheckboxRequired = $this->_isInheritCheckboxRequired($element);

        // Disable element if value is inherited from other scope. Flag has to be set before the value is rendered.
        if ($element->getInherit() == 1 && $isCheckboxRequired) {
            $element->setDisabled(true);
        }

        $html = '<label class="col-sm-4 control-label" for="' .
            $element->getHtmlId() .
            '">' .
            $element->getLabel() .
            '</label>';
        $html .= $this->_renderValue($element);

        if ($isCheckboxRequired) {
            $html .= $this->_renderInheritCheckbox($element);
        }

        $html .= $this->_renderScopeLabel($element);
        $html .= $this->_renderHint($element);

        return $this->_decorateRowHtml($element, $html);
    }

    /**
     * Render element value
     *
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return string
     */
    protected function _renderValue(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $html = $element->getTooltip()?
            '<div class="col-sm-5 control value">'.$this->_getElementHtml($element):
            '<div class="col-sm-5 control value with-tooltip">'.$this->_getElementHtml($element)
            .'<div class="tooltip"><span class="help"><span></span></span><div class="tooltip-content">'
            . $element->getTooltip() . '</div></div>';
        
        if ($element->getComment()) {
            $html .= '<p class="note"><span>' . $element->getComment() . '</span></p>';
        }
        $html .= '</div>';
        return $html;
    }

    /**
     * Render inheritance checkbox (Use Default or Use Website)
     *
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return string
     */
    protected function _renderInheritCheckbox(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $htmlId = $element->getHtmlId();
        $namePrefix = preg_replace('#\[value\](\[\])?$#', '', $element->getName());
        $checkedHtml = $element->getInherit() == 1 ? 'checked="checked"' : '';

        $html = '<div class="col-sm-3 use-default">';
        $html .= '<input id="' .
            $htmlId .
            '_inherit" name="' .
            $namePrefix .
            '[inherit]" type="checkbox" value="1"' .
            ' class="checkbox config-inherit" ' .
            $checkedHtml .
            ' onclick="toggleValueElements(this, Element.previous(this.parentNode))" /> ';
        $html .= '<label for="' . $htmlId . '_inherit" class="inherit">' . $this->_getInheritCheckboxLabel(
            $element
        ) . '</label>';
        $html .= '</div>';

        return $html;
    }

    /**
     * Check if inheritance checkbox has to be rendered
     *
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return bool
     */
    protected function _isInheritCheckboxRequired(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        return $element->getCanUseWebsiteValue() || $element->getCanUseDefaultValue();
    }

    /**
     * Retrieve label for the inheritance checkbox
     *
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return string
     */
    protected function _getInheritCheckboxLabel(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $checkboxLabel = __('Use Default');
        if ($element->getCanUseWebsiteValue()) {
            $checkboxLabel = __('Use Website');
        }
        return $checkboxLabel;
    }

    /**
     * Render scope label
     *
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return string
     */
    protected function _renderScopeLabel(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        return '';
        $html = '<div class="col-sm-2 field-'.$element->getId().' scope-label">';
        if ($element->getScope() && false == $this->_storeManager->isSingleStoreMode()) {
            $html .= $element->getScopeLabel();
        }
        $html .= '</div>';
        return $html;
    }

    /**
     * Render field hint
     *
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return string
     */
    protected function _renderHint(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $html = '<td class="">';
        if ($element->getHint()) {
            $html .= '<div class="hint"><div style="display: none;">' . $element->getHint() . '</div></div>';
        }
        $html .= '</td>';
        return $html;
    }

    /**
     * Decorate field row html
     *
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @param string $html
     * @return string
     */
    protected function _decorateRowHtml(
        \Magento\Framework\Data\Form\Element\AbstractElement $element,
        $html
    ) {
        return '<div id="row_' . $element->getHtmlId() . '" class="form-group field-'.$element->getId().'">' . $html . '</div>';
    }
}
