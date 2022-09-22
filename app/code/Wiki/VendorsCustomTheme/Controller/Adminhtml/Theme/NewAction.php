<?php
/**
 *
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\VendorsCustomTheme\Controller\Adminhtml\Theme;

use Magento\Backend\App\Action;

class NewAction extends Action
{
    /**
     * Is access to section allowed
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return parent::_isAllowed() && $this->_authorization->isAllowed('Wiki_VendorsCommission::commission_configuration');
    }
    
    /**
     * @return void
     */
    public function execute()
    {
        $this->_forward('edit');
    }
}
