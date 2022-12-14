<?php
/**
 *
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\VendorsDashboard\Controller\Vendors\Grid;

use Magento\Framework\Registry;
use Magento\Framework\Stdlib\DateTime\Filter\Date;

class Bestseller extends \Wiki\Vendors\Controller\Vendors\Action
{
    protected $_aclResource = 'Wiki_Vendors::dashboard';
    
    /**
     * @var \Magento\Framework\Controller\Result\RawFactory
     */
    protected $_resultRawFactory;
    
    /**
     * constructor
     *
     * @param \Wiki\Vendors\App\Action\Context $context
     * @param \Wiki\Vendors\App\ConfigInterface $config
     * @param Registry $coreRegistry
     * @param Date $dateFilter
     * @param \Magento\Framework\Controller\Result\RawFactory $resultRawFactory
     */
    public function __construct(
        \Wiki\Vendors\App\Action\Context $context,
        \Magento\Framework\Controller\Result\RawFactory $resultRawFactory
    ) {
        parent::__construct($context);
        $this->_resultRawFactory = $resultRawFactory;
    }
    
    /**
     * Gets the list of most active customers
     *
     * @return \Magento\Framework\Controller\Result\Raw
     */
    public function execute()
    {
        $this->_coreRegistry->register('vendor', $this->_session->getVendor());
        $this->_coreRegistry->register('current_vendor', $this->_session->getVendor());
        $output = $this->_view->getLayout()
            ->createBlock('Wiki\VendorsDashboard\Block\Vendors\Dashboard\Bestseller\Grid')
            ->toHtml();
        $resultRaw = $this->_resultRawFactory->create();
        return $resultRaw->setContents($output);
    }
}
