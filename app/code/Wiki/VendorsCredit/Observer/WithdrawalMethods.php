<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\VendorsCredit\Observer;

use Magento\Framework\Event\ObserverInterface;
use Wiki\VendorsCredit\Model\CreditProcessor\OrderPayment;
use Wiki\VendorsCredit\Model\CreditProcessor\ItemCommission;

class WithdrawalMethods implements ObserverInterface
{
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
     * Constructor
     *
     * @param \Magento\Framework\Event\ManagerInterface $eventManager
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Wiki\Vendors\Model\VendorFactory $vendorFactory
     * @param \Wiki\Credit\Model\Processor $creditProcessor
     * @param \Wiki\Credit\Model\CreditFactory $creditAccountFactory
     * @param \Wiki\Credit\Model\Credit\TransactionFactory $transactionFactory
     */
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        $this->_scopeConfig = $scopeConfig;
    }
    
    /**
     * Add multiple vendor order row for each vendor.
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return self
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $transport = $observer->getTransport();
        $fieldset = $transport->getFieldset();
        $methodName = str_replace("withdrawal_", "", $fieldset->getId());
        $methods = $this->_scopeConfig->getValue('withdrawal_methods');
        if (!isset($methods[$methodName])) {
            return;
        }
        
        $isEnabledMethod = isset($methods[$methodName]['active']) && $methods[$methodName]['active'];
        $transport->setData('force_return', !$isEnabledMethod);
    }
}
