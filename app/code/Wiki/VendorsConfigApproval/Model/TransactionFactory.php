<?php

namespace Wiki\VendorsConfigApproval\Model;

class TransactionFactory extends \Magento\Framework\DB\TransactionFactory
{    
    /**
     * Factory constructor
     *
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     * @param string $instanceName
     */
    public function __construct(
        \Magento\Framework\ObjectManagerInterface $objectManager,
        $instanceName = '\\Wiki\\VendorsConfigApproval\\Model\\Transaction'
    ) {
        $this->_objectManager = $objectManager;
        $this->_instanceName = $instanceName;
    }
}
