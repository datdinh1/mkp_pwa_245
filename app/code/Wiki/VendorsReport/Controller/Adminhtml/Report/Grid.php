<?php
/**
 *
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\VendorsReport\Controller\Adminhtml\Sales123;


use Wiki\VendorsReport\Controller\Adminhtml\Reports;

class Grid extends Reports
{
    public function execute()
    {
        return $this->_resultPageFactory->create();
    }
}
