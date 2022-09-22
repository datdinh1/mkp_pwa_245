<?php
namespace Wiki\VendorsNotification\Controller\Adminhtml\Notification;

use Wiki\VendorsNotification\Controller\Adminhtml\Notification;

class NewAction extends Notification
{
    /**
     * Create new news action
     * @return void
     */
    public function execute()
    {
        $this->_forward('edit');
    }
}