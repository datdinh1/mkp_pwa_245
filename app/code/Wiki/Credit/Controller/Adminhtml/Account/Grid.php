<?php
/**
 *
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\Credit\Controller\Adminhtml\Account;

use Wiki\Credit\Controller\Adminhtml\Action;
use Magento\Customer\Controller\RegistryConstants;

class Grid extends Action
{

    /**
     * @return void
     */
    public function execute()
    {
        $customerId = $this->getRequest()->getParam('id',0);
        $this->_coreRegistry->register(RegistryConstants::CURRENT_CUSTOMER_ID, $customerId);
        
        $grid = $this->_view->getLayout()->createBlock('Wiki\Credit\Block\Adminhtml\Customer\Edit\Tab\Credit\Transaction\Grid');
        $this->getResponse()->setBody($grid->toHtml());
    }
}
