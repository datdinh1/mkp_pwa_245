<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\VendorsCredit\Block\Adminhtml\Withdraw\View;

class Form extends \Magento\Backend\Block\Widget\Form\Generic
{

    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('withdrawal_form');
        $this->setTitle(__('Withdrawal Request'));
    }
    
    /**
     * Get Save URL
     *
     * @return string
     */
    protected function _getSaveUrl()
    {
        return $this->getUrl('*/*/complete');
    }
    
    /**
     * @return WidgetForm
     */
    protected function _prepareForm()
    {
        /** @var \Magento\Framework\Data\Form $form */
        $saveUrl = $this->_getSaveUrl();
        $form = $this->_formFactory->create(
            [
                'data' => [
                    'id' => 'edit_form',
                    'action' => $saveUrl,
                    'method' => 'post',
                ],
            ]
        );
        $form->setUseContainer(true);
        $this->setForm($form);
    
        return parent::_prepareForm();
    }
}
