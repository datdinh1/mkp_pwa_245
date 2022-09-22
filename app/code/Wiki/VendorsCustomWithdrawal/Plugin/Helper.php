<?php

namespace Wiki\VendorsCustomWithdrawal\Plugin;

use Wiki\VendorsCustomWithdrawal\Model\ResourceModel\Method\CollectionFactory;
use Magento\Framework\ObjectManagerInterface;

class Helper
{
    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;
    
    /**
     * @var ObjectManagerInterface
     */
    protected $objectManager;
    
    /**
     * @param CollectionFactory $collectionFactory
     * @param ObjectManagerInterface $objectManager
     */
    public function __construct(
        CollectionFactory $collectionFactory,
        ObjectManagerInterface $objectManager
    ) {
        $this->collectionFactory    = $collectionFactory;
        $this->objectManager        = $objectManager;
    }

    /**
     * @param \Wiki\VendorsCredit\Helper\Data $subject
     * @param array $result
     * @return array
     */
    public function afterGetWithdrawalMethods(
        \Wiki\VendorsCredit\Helper\Data $subject,
        $result
    ) {
        $collection = $this->collectionFactory->create()
            ->addFieldToFilter('is_enabled', 1);
        
        foreach($collection as $method){
            $withdrawalMethod = $this->objectManager
                ->create('Wiki\VendorsCustomWithdrawal\Model\Withdrawal\Method\Custom')
                ->setMethodObj($method);
            $result[$method->getCode()] = $withdrawalMethod;
        } 
        return $result;
    }
}
