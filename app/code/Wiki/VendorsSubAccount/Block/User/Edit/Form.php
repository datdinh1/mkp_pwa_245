<?php
namespace Wiki\VendorsSubAccount\Block\User\Edit;

use Magento\Backend\Block\Widget\Form as WidgetForm;

class Form extends \Wiki\Vendors\Block\Vendors\Widget\Form\Generic
{
    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('user_form');
        $this->setTitle(__('User Information'));
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
    
    /**
     * Get Save Url
     * @return string
     */
    protected function _getSaveUrl()
    {
        return $this->getUrl('subaccount/user/save');
    }
}
