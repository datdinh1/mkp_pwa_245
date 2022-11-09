<?php
/**
 *
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\VendorsProduct\Controller\Adminhtml\Catalog\Product;

use Wiki\Vendors\Controller\Adminhtml\Action;

class Grid extends Action
{

    /**
     * @return void
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $model = $this->_objectManager->create('Wiki\Vendors\Model\Vendor');
        $model->load($id);
        $this->_coreRegistry->register('current_vendor', $model);
        
        $grid = $this->_view->getLayout()->createBlock('Wiki\VendorsProduct\Block\Adminhtml\Vendor\Edit\Tab\Products\Grid');
        return $this->getResponse()->setBody($grid->toHtml());
    }
}
