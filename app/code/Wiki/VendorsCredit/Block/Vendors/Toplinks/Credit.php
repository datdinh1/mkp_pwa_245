<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

// @codingStandardsIgnoreFile

namespace Wiki\VendorsCredit\Block\Vendors\Toplinks;

use \Wiki\Credit\Model\ResourceModel\Credit\Transaction\CollectionFactory;

/**
 * Vendor Notifications block
 */
class Credit extends \Wiki\Vendors\Block\Vendors\AbstractBlock
{
    /**
     * @var \Wiki\Vendors\Model\Session
     */
    protected $_vendorSession;
    
    /**
     * @var \Wiki\Credit\Model\CreditFactory
     */
    protected $_creditFactory;
    
    /**
     * @var CollectionFactory
     */
    protected $_collectionFactory;
    
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Wiki\Vendors\Model\UrlInterface $url,
        \Wiki\Vendors\Model\Session $vendorSession,
        \Wiki\Credit\Model\CreditFactory $creditAccountFactory,
        CollectionFactory $collectionFactory,
        array $data = [])
    {
        parent::__construct($context, $url, $data);
        $this->_vendorSession = $vendorSession;
        $this->_creditFactory = $creditAccountFactory;
        $this->_collectionFactory = $collectionFactory;
    }
    
    /**
     * Get credit account
     * 
     * @return \Wiki\Credit\Model\Credit
     */
    public function getCreditAccount(){
        if(!$this->getData('credit_account')){
            $creditAccount = $this->_creditFactory->create();
            $creditAccount->loadByCustomerId($this->_vendorSession->getCustomer()->getId());
            $this->setData('credit_account',$creditAccount);
        }
        
        return $this->getData('credit_account');
    }
    
    /**
     * Get credit
     * 
     * @return number
     */
    public function getCredit(){
        return $this->getCreditAccount()->getCredit();
    }
    
    /**
     * Format credit in base currency
     * @param number $credit
     * @return string
     */
    public function formatCredit($credit){
        return $this->_storeManager->getStore()->getBaseCurrency()->formatPrecision($credit, 2, [], false);
    }
    
    /**
     * Get transaction collection
     * 
     * @return \Wiki\Credit\Model\ResourceModel\Credit\Transaction\Collection
     */
    public function getTransactionCollection(){
        if(!$this->getData('trans_collection')){
            $collection = $this->_collectionFactory->create();
            $collection->addFieldToFilter('customer_id',$this->_vendorSession->getCustomer()->getId());
            $collection->setOrder('transaction_id','desc');
            $collection->setPageSize(5);
            $this->setData('trans_collection',$collection);
        }
        
        return $this->getData('trans_collection');
    }
    
    /**
     * Get Withdraw URL
     * 
     * @return string
     */
    public function getWithdrawUrl(){
        return $this->getUrl('credit/withdraw');
    }
    
    /**
     * Get Withdrawal History URL
     *
     * @return string
     */
    public function getWithdrawalHistoryUrl(){
        return $this->getUrl('credit/withdraw/history');
    }
    
    /**
     * Get Credit Transactions URL
     * 
     * @return string
     */
    public function getCreditTransactionsUrl(){
        return $this->getUrl('credit/transactions');
    }
    
    /**
     * Is Enabled Escrow Transaction
     * 
     * @return boolean
     */
    public function isEnabledEscrowTransaction(){
        return $this->_scopeConfig->getValue('vendors/credit/enable_escrow');
    }
    
    /**
     * Get Total Pending Credit.
     * 
     * @return string
     */
    public function getTotalPendingCredit(){
        $vendor = $this->_vendorSession->getVendor();
        $om = \Magento\Framework\App\ObjectManager::getInstance();
        /** @var \Wiki\VendorsCredit\Model\ResourceModel\Escrow */
        $escrowResource = $om->create('Wiki\VendorsCredit\Model\ResourceModel\Escrow');
        return $escrowResource->getTotalPendingCredit($vendor);
    }
    
    /**
     * Get Pending Credit URL
     * 
     * @return string
     */
    public function getPendingCreditUrl(){
        return $this->getUrl('credit/pending');
    }
}
