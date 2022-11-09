<?php 
namespace Wiki\VendorsCustomTheme\Controller\Vendors\Cmspages;

class Index extends \Wiki\Vendors\Controller\Vendors\Action
{

    public function execute()
    {
      
        $this->_initAction();
        $this->setActiveMenu('Wiki_Vendors::manage_cmspages');
        $title = $this->_view->getPage()->getConfig()->getTitle();
        // $title->prepend(__("Import"));
        // $title->prepend(__("Import Product"));
        // $this->_addBreadcrumb(__("Import"), __("Import"))->_addBreadcrumb(__("Import Product"), __("Import Product"));
        // $this->_view->renderLayout();

        $title->prepend(__("CMS"));
        $title->prepend(__("Pages"));
        $this->_addBreadcrumb(__("CMS"), __("CMS"))->_addBreadcrumb(__("Cms Page"), __("Cms Page"));
        $this->_view->renderLayout();
    }
}