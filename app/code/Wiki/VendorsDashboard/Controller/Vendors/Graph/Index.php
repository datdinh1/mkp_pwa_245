<?php
/**
 *
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\VendorsDashboard\Controller\Vendors\Graph;

use Magento\Framework\Registry;
use Magento\Framework\Stdlib\DateTime\Filter\Date;

class Index extends \Wiki\Vendors\Controller\Vendors\Action
{
    protected $_aclResource = 'Wiki_Vendors::dashboard';
    
    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $_resultJsonFactory;
    
    /**
     * @var \Wiki\VendorsDashboard\Model\Graph
     */
    protected $_graph;
    
    /**
     * @var \Wiki\Vendors\Model\VendorFactory
     */
    protected $_vendorFactory;
    
    /**
     * Constructor
     * @param \Wiki\Vendors\App\Action\Context $context
     * @param \Wiki\Vendors\App\ConfigInterface $config
     * @param Registry $coreRegistry
     * @param Date $dateFilter
     * @param \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
     * @param \Wiki\Vendors\Model\VendorFactory $vendorFactory
     * @param \Wiki\VendorsDashboard\Model\Graph $graph
     */
    public function __construct(
        \Wiki\Vendors\App\Action\Context $context,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Wiki\Vendors\Model\VendorFactory $vendorFactory,
        \Wiki\VendorsDashboard\Model\Graph $graph
    ) {
        parent::__construct($context);
        $this->_resultJsonFactory = $resultJsonFactory;
        $this->_vendorFactory = $vendorFactory;
        $this->_graph = $graph;
    }
    
    /**
     * @return void
     */
    public function execute()
    {
        $response = new \Magento\Framework\DataObject();
        $period = $this->getRequest()->getParam('period');
        $vendor = $this->_session->getVendor();
        $vendorId = $vendor->getId();
        $customerId = $vendor->getCustomer()->getId();
        
        switch ($period) {
            case '2y':
                $data = [
                    'transaction_chart' => $this->_graph->getTransactionDataLast2Years($customerId),
                    'order_chart' => $this->_graph->getOrdersDataLast2Years($vendorId),
                    'amount_chart' => $this->_graph->getAmountsDataLast2Years($vendorId),
                ];
                break;
            case '1y':
                $data = [
                    'transaction_chart' => $this->_graph->getTransactionDataLastYear($customerId),
                    'order_chart' => $this->_graph->getOrdersDataLastYear($vendorId),
                    'amount_chart' => $this->_graph->getAmountsDataLastYear($vendorId),
                ];
                break;
            case '1m':
                $data = [
                    'transaction_chart' => $this->_graph->getTransactionDataLastMonth($customerId),
                    'order_chart' => $this->_graph->getOrdersDataLastMonth($vendorId),
                    'amount_chart' => $this->_graph->getAmountsDataLastMonth($vendorId),
                ];
                break;
            case '7d':
                $data = [
                    'transaction_chart' => $this->_graph->getTransactionDataLast7Days($customerId),
                    'order_chart' => $this->_graph->getOrdersDataLast7Days($vendorId),
                    'amount_chart' => $this->_graph->getAmountsDataLast7Days($vendorId),
                ];
                break;
            case '24h':
            default:
                $data = [
                    'transaction_chart' => $this->_graph->getTransactionsDataLast24Hours($customerId),
                    'order_chart' => $this->_graph->getOrdersDataLast24Hours($vendorId),
                    'amount_chart' => $this->_graph->getAmountsDataLast24Hours($vendorId),
                ];
        }
        $response->setData($data);
        return $this->_resultJsonFactory->create()->setJsonData($response->toJson());
    }
}
