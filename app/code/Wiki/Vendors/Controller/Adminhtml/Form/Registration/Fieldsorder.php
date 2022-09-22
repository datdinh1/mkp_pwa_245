<?php
/**
 *
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\Vendors\Controller\Adminhtml\Form\Registration;

use Wiki\Vendors\Controller\Adminhtml\Action;

class Fieldsorder extends \Wiki\Vendors\Controller\Adminhtml\Form\Profile\Fieldsorder
{
    /**
     * Is access to section allowed
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return Action::_isAllowed() && $this->_authorization->isAllowed('Wiki_Vendors::vendors_registration_form');
    }
}
