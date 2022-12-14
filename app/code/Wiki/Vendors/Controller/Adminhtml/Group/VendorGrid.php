<?php
/**
 *
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\Vendors\Controller\Adminhtml\Group;

use Wiki\Vendors\Controller\Adminhtml\Action;

class VendorGrid extends Action
{
    /**
     * Is access to section allowed
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Wiki_Vendors::vendors_groups') && parent::_isAllowed();
    }
    
    /**
     * @return void
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $model = $this->_objectManager->create('Wiki\Vendors\Model\Group');
        if ($id) {
            $model->load($id);
            if (!$model->getVendorGroupId()) {
                $this->messageManager->addError(__('This group no longer exists.'));
                $this->_redirect('vendors/*');
                return;
            }
        }
        
        $this->_coreRegistry->register('current_group', $model);
        
        $grid = $this->_view->getLayout()->createBlock('Wiki\Vendors\Block\Adminhtml\Group\Edit\Tab\Vendor\Grid');
        return $this->getResponse()->setBody($grid->toHtml());
    }
}
