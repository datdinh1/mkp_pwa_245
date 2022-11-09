<?php
/**
 * Copyright (c) 2017 Wiki Co ltd. All rights reserved.
 */

namespace Wiki\VendorsSubAccount\Controller\Vendors\Role;

class NewAction extends \Wiki\Vendors\Controller\Vendors\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    protected $_aclResource = 'Wiki_VendorsQuotation::subaccount_role';
    
    /**
     * Index action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $this->_forward('edit');
    }
}
