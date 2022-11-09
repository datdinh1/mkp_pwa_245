<?php
namespace Wiki\VendorsNotification\Controller\Adminhtml\Notification;

use Wiki\VendorsNotification\Controller\Adminhtml\Notification;

class Grid extends Notification
{
    /**
     * @return void
     */
    public function execute()
    {
        return $this->_resultPageFactory->create();
    }
}