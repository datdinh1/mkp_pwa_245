<?php

namespace Wiki\VendorsSales\Controller\Vendors\Order\Creditmemo;

class Index extends \Wiki\VendorsSales\Controller\Vendors\Creditmemo\AbstractCreditmemo\Index
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    protected $_aclResource = 'Wiki_VendorsSales::sales_creditmemo';
    
    /**
     * Index page
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        return parent::execute();
    }
}
