<?php

namespace Wiki\SmsNotification\Block\Adminhtml\News;

use Magento\Backend\Block\Widget\Grid as WidgetGrid;

class Grid extends WidgetGrid
{
    protected function _prepareColumns()
    {
        $this->addColumn(
            'image',
            array(
                'header' => __('Image'),
                'index' => 'image',
                'renderer'  => '\Wiki\SmsNotification\Block\Adminhtml\News\Grid\Renderer\Image',
            )
        );

        return parent::_prepareColumns();
    }
}