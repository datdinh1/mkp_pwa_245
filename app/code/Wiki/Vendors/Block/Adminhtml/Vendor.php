<?php
/**
 * Catalog price rules
 *
 * @author      Wiki Team <core@Wiki.com>
 */
namespace Wiki\Vendors\Block\Adminhtml;

class Vendor extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_blockGroup = 'Wiki_Vendors';
        $this->_controller = 'adminhtml_vendor';
        $this->_headerText = __('Manage Vendors');
        parent::_construct();
        //$this->removeButton('add');
        $this->_addButtonLabel = __('Add New Vendor');
    }
    
    protected function _prepareLayout()
    {
        /* $addButtonProps = [
            'id' => 'add_new_block',
            'label' => __('Add New Block'),
            'class' => 'add',
            'button_class' => '',
            'class_name' => 'Wiki\AutoRelatedProduct\Block\Widget\Button\SplitButton',
            'options' => $this->_getAddProductButtonOptions(),
        ];
        $this->buttonList->add('add_new', $addButtonProps); */
        return parent::_prepareLayout();
    }
}
