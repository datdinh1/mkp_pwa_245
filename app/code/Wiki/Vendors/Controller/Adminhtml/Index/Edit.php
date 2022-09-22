<?php
namespace Wiki\Vendors\Controller\Adminhtml\Index;

use Wiki\Vendors\Controller\Adminhtml\Action;

class Edit extends Action
{
    /**
     * Is access to section allowed
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return parent::_isAllowed() && $this->_authorization->isAllowed('Wiki_Vendors::vendors_sellers');
    }
    
    
    /**
     * @return void
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $model = $this->_objectManager->create('Wiki\Vendors\Model\Vendor');

        if ($id) {
            $model->load($id);
            if (!$model->getEntityId() || $model->getStatus()==0) {
                $this->messageManager->addError(__('This Seller no longer exists.'));
                $this->_redirect('vendors/*');
                return;
            }
        }

        // set entered data if was error when we do save
        $data = $this->_objectManager->get('Magento\Backend\Model\Session')->getVendorData(true);
        if (!empty($data)) {
            $model->addData($data);
        }
        
        $this->_coreRegistry->register('current_vendor', $model);

        $this->_initAction();
        $this->_view->getPage()->getConfig()->getTitle()->prepend(__('Manage Seller'));
        $this->_view->getPage()->getConfig()->getTitle()->prepend(
            $model->getId() ? $model->getName() : __('New Seller')
        );

        $breadcrumb = $id ? __('Edit Seller') : __('New Seller');
        $this->_addBreadcrumb($breadcrumb, $breadcrumb);
        $this->_view->renderLayout();
    }
}
