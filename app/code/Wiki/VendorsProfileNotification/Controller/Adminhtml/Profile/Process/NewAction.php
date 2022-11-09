<?php
namespace Wiki\VendorsProfileNotification\Controller\Adminhtml\Profile\Process;

use Wiki\Vendors\Controller\Adminhtml\Action;

class NewAction extends Action
{
    /**
     * @return void
     */
    public function execute()
    {
        $this->_forward('edit');
    }
}
