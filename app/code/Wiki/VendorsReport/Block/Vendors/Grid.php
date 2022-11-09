<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Wiki\VendorsReport\Block\Vendors;

class Grid extends \Magento\Reports\Block\Adminhtml\Grid
{
    /**
     * @var \Wiki\Vendors\Model\Session
     */
    protected $_vendorSession;
    
    /**
     * Constructor
     *
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Backend\Helper\Data $backendHelper
     * @param \Wiki\Vendors\Model\Session $vendorSession
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Wiki\Vendors\Model\Session $vendorSession,
        array $data = []
    ) {
        $this->_vendorSession = $vendorSession;
        parent::__construct($context, $backendHelper, $data);
    }
    /**
     * Block template file name
     *
     * @var string
     */
    protected $_template = 'Wiki_VendorsReport::grid.phtml';
    
    /**
     * (non-PHPdoc)
     * @see \Magento\Reports\Block\Adminhtml\Grid::_prepareCollection()
     */
    protected function _prepareCollection()
    {
        parent::_prepareCollection();
        $this->getCollection()->setVendorId($this->_vendorSession->getVendor()->getId());
    }
}
