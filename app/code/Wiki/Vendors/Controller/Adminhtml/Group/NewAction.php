<?php
/**
 *
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\Vendors\Controller\Adminhtml\Group;

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
