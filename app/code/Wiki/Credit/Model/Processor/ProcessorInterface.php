<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\Credit\Model\Processor;

use \Wiki\Credit\Model\Credit\Transaction;

interface ProcessorInterface 
{
    public function process($data = array());
    
    public function processAmount($amount);
    
    public function getTitle();
    
    public function getCode();
    
    public function getDescription(Transaction $transaction);
    
    public function sendNotificationEmail(Transaction $transaction);
}
