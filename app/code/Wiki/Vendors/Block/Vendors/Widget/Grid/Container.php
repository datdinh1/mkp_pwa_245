<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\Vendors\Block\Vendors\Widget\Grid;

class Container extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     * @var string
     */
    protected $_blockGroup = 'Wiki_Vendors';
    
    /**
     * @var string
     */
    protected $_template = 'Wiki_Vendors::widget/grid/container.phtml';
    
    /**
     * Create "New" button
     *
     * @return void
     */
    protected function _addNewButton()
    {
        $this->addButton(
            'add',
            [
                'label' => $this->getAddButtonLabel(),
                'onclick' => 'setLocation(\'' . $this->getCreateUrl() . '\')',
                'class' => 'btn-success add primary'
            ]
        );
    }
}
