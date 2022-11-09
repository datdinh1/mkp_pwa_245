<?php
namespace Wiki\Core\Controller\Adminhtml\Licenses;

use Wiki\Core\Controller\Adminhtml\Action;

class NewAction extends Action
{
    /**
     * @return void
     */
    public function execute()
    {
        $model = $this->_objectManager->create('Wiki\Core\Model\Key');

        $this->_coreRegistry->register('current_license', $model);
        $this->_coreRegistry->register('license', $model);

        $this->_initAction();
        $this->_view->getPage()->getConfig()->getTitle()->prepend(__('License Info'));
        $this->_view->getPage()->getConfig()->getTitle()->prepend( __('New License'));


        $breadcrumb = __('New License');
        $this->_addBreadcrumb($breadcrumb, $breadcrumb);
        $this->_view->renderLayout();
    }
}
