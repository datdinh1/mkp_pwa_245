<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\VendorsReport\Block\Vendors\Reports\Product;

use Wiki\VendorsReport\Model\Source\Period;
use Wiki\VendorsReport\Block\Vendors\Reports\LayoutProcessorInterface;

class Ordered implements LayoutProcessorInterface
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
        
        $jsLayout['components']['reports']['graphs_data'][$dateRange['value']]['report_product'] = [
            Period::PERIOD_DAY => $this->_salesReport->getProductSoldDataForGraph(
                $from,
                $to,
                Period::PERIOD_DAY,
                $vendorId
            ),
            Period::PERIOD_MONTH => $this->_salesReport->getProductSoldDataForGraph(
                $from,
                $to,
                Period::PERIOD_MONTH,
                $vendorId
            ),
            Period::PERIOD_QUARTER => $this->_salesReport->getProductSoldDataForGraph(
                $from,
                $to,
                Period::PERIOD_QUARTER,
                $vendorId
            ),
            Period::PERIOD_YEAR => $this->_salesReport->getProductSoldDataForGraph(
                $from,
                $to,
                Period::PERIOD_YEAR,
                $vendorId
            ),
        ];
        
        $jsLayout['components']['reports']['report_url'] = $this->_url->getUrl('reports/product_graph/ordered');
        $jsLayout['components']['reports']['priceFormat'] = $this->_localeFormat->getPriceFormat(null, $this->_storeManager->getStore()->getBaseCurrencyCode());
        return $jsLayout;
    }
}
