<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\Credit\Model\Processor;

use Magento\Framework\Exception\LocalizedException;

class AdminAddCredit extends \Wiki\Credit\Model\Processor\AbstractProcessor
{
    const TYPE = 'admin_add_credit';
    
    protected $_action = 'add';
        
    /**
     * @see \Wiki\Credit\Model\Processor\AbstractProcessor::getTitle()
     */
    public function getTitle(){
        return __("Admin Add Credit");
    }
    
    /**
     * @see \Wiki\Credit\Model\Processor\AbstractProcessor::getCode()
     */
    public function getCode(){
        return self::TYPE;
    }
    
    /**
     * Process data
     * @see \Wiki\Credit\Model\Processor\AbstractProcessor::process()
     */
    public function process($data=array()){
        if(!isset($data['amount'])) 
            throw new LocalizedException(__("Amout is not set in %1 on line %2", "<strong>".__FILE__."</strong>","<strong>".__LINE__."</strong>"));

        /*Process the credit amout*/
        $this->processAmount($data['amount']);
        
        $additionalInfo = '';
        $description = isset($data['description']) && $data['description']?$data['description']:__("Admin add %1 credits to your credit account.",$this->_creditAccount->formatBaseCurrency($data['amount']));
        /*Create transasction*/
        $transData = [
            'customer_id'		=> $this->getCreditAccount()->getCustomerId(),
            'type'				=> self::TYPE,
            'amount'			=> $data['amount'],
            'balance'			=> $this->getCreditAccount()->getCredit(),
            'description'		=> $description,
            'additional_info'	=> $additionalInfo,
            'created_at'		=> $this->date->timestamp(),
        ];
        $transaction = $this->transactionFactory->create();
        $transaction->setData($transData)->save();
        
        $this->sendNotificationEmail($transaction);
    }
}
