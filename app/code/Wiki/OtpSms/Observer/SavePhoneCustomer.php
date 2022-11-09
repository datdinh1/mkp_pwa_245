<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\OtpSms\Observer;

use Magento\Framework\Event\ObserverInterface;

class SavePhoneCustomer implements ObserverInterface
{
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $customer = $observer->getCustomerDataObject();
        $id = $customer->getId();
        $mobile = $customer->getCustomAttribute('mobile')->getValue();
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $resource = $objectManager->get(\Magento\Framework\App\ResourceConnection::class);
        $tableCustomer = $resource->getTableName('customer_entity');

        $sql = "UPDATE `" . $tableCustomer . "` SET `mobile`= '$mobile' WHERE `entity_id`= $id ";
        $resource->getConnection()->query($sql);
    }
}
