<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\Credit\Observer;

use Magento\Framework\Event\ObserverInterface;
use Wiki\Credit\Model\Product\Type\Credit as CreditType;
use Wiki\Credit\Model\Processor\BuyCredit as BuyCreditProcessor;


class QuoteSubmitBeforeObserver implements ObserverInterface
{
    /**
     * Set credit amount to order
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $quote = $observer->getQuote();
    	$order = $observer->getOrder();
    	
    	$order->setCreditAmount($quote->getCreditAmount());
    	$order->setBaseCreditAmount($quote->getBaseCreditAmount());

    	
    	foreach($order->getAllItems() as $orderItem){
    	    $quoteItem = $quote->getItemById($orderItem->getQuoteItemId());
    	    $orderItem->setCreditAmount($quoteItem->getCreditAmount());
    	    $orderItem->setBaseCreditAmount($quoteItem->getBaseCreditAmount());
    	}
    	
    }
}
