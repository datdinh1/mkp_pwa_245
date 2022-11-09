<?php
/**
 * Catalog price rules
 *
 * @author      Wiki Team <core@Wiki.com>
 */
namespace Wiki\VendorsCommission\Block\Adminhtml;

class Rule extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_blockGroup = 'Wiki_VendorsCommission';
        $this->_controller = 'adminhtml_rule';
        $this->_headerText = __('Manage Commission Rules');
        parent::_construct();
        $this->_addButtonLabel = __('Add new Rule');
    }
}
