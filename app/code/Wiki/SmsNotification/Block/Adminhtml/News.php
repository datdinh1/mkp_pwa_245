<?php

namespace Wiki\SmsNotification\Block\Adminhtml;

use Magento\Backend\Block\Widget\Grid\Container;

class News extends Container
{
   /**
     * Constructor
     *
     * @return void
     */
   protected function _construct()
    {
        $this->_controller = 'adminhtml_news';
        $this->_blockGroup = 'Wiki_SmsNotification';
        $this->_headerText = __('Manage Notification');
        $this->_addButtonLabel = __('Add Notification');
        parent::_construct();
    }
}