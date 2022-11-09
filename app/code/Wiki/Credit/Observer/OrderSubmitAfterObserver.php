<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\Credit\Observer;

use Magento\Framework\Event\ObserverInterface;
use Wiki\Credit\Model\Product\Type\Credit as CreditType;
use Wiki\Credit\Model\Processor\BuyCredit as BuyCreditProcessor;
use Wiki\Credit\Model\Processor\SpendCredit as SpendCreditProcessor;

class OrderSubmitAfterObserver implements ObserverInterface
{
    /**
     * @var \Wiki\Credit\Model\Processor
     */
    protected $creditProcessor;
    
    /**
     * @var \Wiki\Credit\Model\CreditFactory
     */
    protected $creditAccountFactory;
    
    /**
     * @var \Wiki\Credit\Model\Credit\TransactionFactory
     */
    protected $transactionFactory;
    
    public function __construct(
        \Wiki\Credit\Model\Processor $creditProcessor,
        \Wiki\Credit\Model\CreditFactory $creditAccountFactory,
        \Wiki\Credit\Model\Credit\TransactionFactory $transactionFactory
    ) {
        $this->transactionFactory   = $transactionFactory;
        $this->creditAccountFactory = $creditAccountFactory;
        $this->creditProcessor      = $creditProcessor;
    }
    
    /**
     * Add the notification if there are any vendor awaiting for approval. 
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
    	$order		= $observer->getOrder();
    	/*Spend credit*/
    	$this->processSpendCredit($order);
    }
    
    
    /**
     * Process spend credit
     * @param \Magento\Sales\Model\Order $order
     */
    public function processSpendCredit(\Magento\Sales\Model\Order $order){
        if(!$order->getBaseCreditAmount()) return;
        
        $customerId = $order->getCustomerId();
        if(!$customerId) return;
            
        /*Return if the transaction for the invoice is already exist.*/
        $trans = $this->transactionFactory->create()->getCollection()
            ->addFieldToFilter('type',SpendCreditProcessor::TYPE)
            ->addFieldToFilter(
                'additional_info',
                array('like'=>'order|'.$order->getId())
            );
        if($trans->count()) return;
        
        $creditAccount = $this->creditAccountFactory->create();
        $creditAccount->loadByCustomerId($customerId);
        
        $creditAmount = abs($order->getBaseCreditAmount());
        if($creditAmount == 0) return;
        
        $data = array(
            'type'		=> SpendCreditProcessor::TYPE,
            'amount'	=> $creditAmount,
            'order'		=> $order,
        );
         
        $this->creditProcessor->process($creditAccount,$data);
    }
}
