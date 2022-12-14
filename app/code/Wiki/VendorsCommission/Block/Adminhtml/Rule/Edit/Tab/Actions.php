<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\VendorsCommission\Block\Adminhtml\Rule\Edit\Tab;

use Magento\Backend\Block\Widget\Form;
use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab\TabInterface;

class Actions extends Generic implements TabInterface
{
    /**
     * Prepare content for tab
     *
     * @return \Magento\Framework\Phrase
     * @codeCoverageIgnore
     */
    public function getTabLabel()
    {
        return __('Actions');
    }

    /**
     * Prepare title for tab
     *
     * @return \Magento\Framework\Phrase
     * @codeCoverageIgnore
     */
    public function getTabTitle()
    {
        return __('Actions');
    }

    /**
     * Returns status flag about this tab can be showen or not
     *
     * @return bool
     * @codeCoverageIgnore
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * Returns status flag about this tab hidden or not
     *
     * @return bool
     * @codeCoverageIgnore
     */
    public function isHidden()
    {
        return false;
    }

    /**
     * @return Form
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    protected function _prepareForm()
    {
        $model = $this->_coreRegistry->registry('commission_rule');

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();
        $form->setHtmlIdPrefix('rule_');

        $fieldset = $form->addFieldset(
            'action_fieldset',
            ['legend' => __('Calculate Commission Using The Following Information')]
        );

        $fieldset->addField(
            'commission_by',
            'select',
            [
                'label' => __('Commission By'),
                'onchange'  => 'hideShowCommissionAction()',
                'name' => 'commission_by',
                'options' => [
                    'by_fixed' => __('Fixed Amount'),
                    'by_percent' => __('Percent Of Product Price'),
                ]
            ]
        );
        
        $fieldset->addField(
            'commission_action',
            'select',
            [
                'label' => __('Calculate Commission Based On'),
                'name' => 'commission_action',
                'options' => [
                    'by_price_incl_tax' => __('Product Price (Incl. Tax)'),
                    'by_price_excl_tax' => __('Product Price (Excl. Tax)'),
                    'by_price_after_discount_incl_tax' => __('Product Price After Discount (Incl. Tax)'),
                    'by_price_after_discount_excl_tax' => __('Product Price After Discount (Excl. Tax)'),
                ]
            ]
        );

        $fieldset->addField(
            'commission_amount',
            'text',
            [
                'name' => 'commission_amount',
                'required' => true,
                'class' => 'validate-not-negative-number',
                'label' => __('Commission')
            ]
        );


        $fieldset->addField(
            'stop_rules_processing',
            'select',
            [
                'label' => __('Discard subsequent rules'),
                'title' => __('Discard subsequent rules'),
                'name' => 'stop_rules_processing',
                'options' => ['1' => __('Yes'), '0' => __('No')]
            ]
        );

        $form->setValues($model->getData());


        $this->setForm($form);

        return parent::_prepareForm();
    }
}
