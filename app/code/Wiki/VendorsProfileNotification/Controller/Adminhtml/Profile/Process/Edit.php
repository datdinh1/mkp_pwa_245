<?php
namespace Wiki\VendorsProfileNotification\Controller\Adminhtml\Profile\Process;

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
        return parent::_isAllowed() && $this->_authorization->isAllowed('Wiki_VendorsProfileNotification::manage_process');
    }
    
    
    /**
     * @return void
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $model = $this->_objectManager->create('Wiki\VendorsProfileNotification\Model\Process');

        if ($id) {
            $model->load($id);
            if (!$model->getProcessId()) {
                $this->messageManager->addError(__('This profile process no longer exists.'));
                $this->_redirect('vendors/*');
                return;
            }
        }

        // set entered data if was error when we do save
        $data = $this->_objectManager->get('Magento\Backend\Model\Session')->getPageData(true);
        if (!empty($data)) {
            $model->addData($data);
        }
        
        $this->_coreRegistry->register('current_process', $model);

        $this->_initAction();
        $this->_view->getPage()->getConfig()->getTitle()->prepend(__('Manage Vendor Profile Process'));
        $this->_view->getPage()->getConfig()->getTitle()->prepend(
            $model->getVendorGroupId() ? $model->getVendorGroupCode() : __('New Profile Process')
        );

        $breadcrumb = $id ? __('Edit Seller Group') : __('New Profile Process');
        $this->_addBreadcrumb($breadcrumb, $breadcrumb);
        $this->_view->renderLayout();
    }
}
