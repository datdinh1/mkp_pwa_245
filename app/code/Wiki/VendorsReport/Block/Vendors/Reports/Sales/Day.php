<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\VendorsReport\Block\Vendors\Reports\Sales;

use Wiki\VendorsReport\Model\Source\Period;
use Wiki\VendorsReport\Block\Vendors\Reports\LayoutProcessorInterface;

class Day implements LayoutProcessorInterface
{
    /**
     * @var \Wiki\VendorsReport\Model\Report\Sales
     */
    protected $_salesReport;
    
    /**
     * @var \Wiki\Vendors\Model\Session
     */
    protected $_vendorSession;
    
    /**
     * Backend URL instance
     *
     * @var \Wiki\Vendors\Model\UrlInterface
     */
    protected $_url;
    
    /**
     * @var \Magento\Framework\Locale\FormatInterface
     */
    protected $_localeFormat;
    
    /**
     * Store manager
     *
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;
    
    /**
     *
     * @param \Wiki\VendorsReport\Model\Report\Sales $salesReport
     * @param \Wiki\Vendors\Model\Session $vendorSession
     */
    public function __construct(
        \Wiki\VendorsReport\Model\Report\Sales $salesReport,
        \Wiki\Vendors\Model\UrlInterface $url,
        \Magento\Framework\Locale\FormatInterface $localeFormat,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Wiki\Vendors\Model\Session $vendorSession
    ) {
        $this->_salesReport = $salesReport;
        $this->_vendorSession = $vendorSession;
        $this->_localeFormat = $localeFormat;
        $this->_storeManager = $storeManager;
        $this->_url = $url;
    }
    
    public function process($jsLayout)
    {
        $dateRange = $jsLayout['components']['reports']['date_range'];
        $range = explode("_", $dateRange['value']);
        $from = $range[0];
        $to = strtotime($range[1]);
        
        $vendorId = $this->_vendorSession->getVendor()->getId();
        
        $jsLayout['components']['reports']['graphs_data'][$dateRange['value']]['report_sales'] = [
            Period::PERIOD_DAY => $this->_salesReport->getOrderTotalsByDay(
                $from,
                $to,
                $vendorId
            ),
        ];
        
        $jsLayout['components']['reports']['report_url'] = $this->_url->getUrl('reports/sales_graph/day');
        $jsLayout['components']['reports']['priceFormat'] = $this->_localeFormat->getPriceFormat(null, $this->_storeManager->getStore()->getBaseCurrencyCode());
        return $jsLayout;
    }
}
