<?php

namespace Wiki\VendorsSales\Controller\Vendors\Shipment\AbstractShipment;

use Magento\Framework\Registry;
use Magento\Framework\Stdlib\DateTime\Filter\Date;

abstract class Index extends \Wiki\Vendors\Controller\Vendors\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    protected $_aclResource = 'Wiki_VendorsSales::sales_shipments';
    
    /**
     * Constructor
     *
     * @param Context $context
     * @param Registry $coreRegistry
     * @param Date $dateFilter
     */
    public function __construct(
        \Wiki\Vendors\App\Action\Context $context
    ) {
        parent::__construct($context);
    }


    /**
     * Init layout, menu and breadcrumb
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    protected function _initAction()
    {
        parent::_initAction();
        $this->_setActiveMenu('Wiki_VendorsSales::sales_shipments')
            ->_addBreadcrumb(__('Sales'), __('Sales'))
            ->_addBreadcrumb(__('Shipments'), __('Shipments'));
    }

    /**
     * Invoices grid
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        $this->getRequest()->setParam('vendor_id', $this->_session->getVendor()->getId());
        $this->_initAction();
        $title = $this->_view->getPage()->getConfig()->getTitle();
        $title->prepend(__("Sales"));
        $title->prepend(__("Shipments"));
        $this->_view->renderLayout();
    }
}
