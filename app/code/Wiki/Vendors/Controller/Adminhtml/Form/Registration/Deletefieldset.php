<?php
/**
 *
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\Vendors\Controller\Adminhtml\Form\Registration;

use Wiki\Vendors\Controller\Adminhtml\Action;

class Deletefieldset extends \Wiki\Vendors\Controller\Adminhtml\Form\Profile\Deletefieldset
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
    /**
     * Get fieldset block.
     */
    public function getFieldsetBlock()
    {
        return $this->_view->getLayout()->createBlock('Wiki\Vendors\Block\Adminhtml\Registration\Form')
        ->setTemplate('Wiki_Vendors::profile/container_ajax.phtml');
    }
}
