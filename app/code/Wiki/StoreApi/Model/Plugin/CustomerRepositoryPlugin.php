<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\StoreApi\Model\Plugin;

use Wiki\StoreApi\Model\CardFactory;
use Wiki\StoreApi\Model\SettingFactory;
use Wiki\StoreApi\Model\Api\Data\SettingFactory as SettingDataFactory;
use Magento\Customer\Api\Data\CustomerExtensionFactory;

class CustomerRepositoryPlugin
{
    /**
     * @var CardFactory
     */
    private $cardFactory;

    /**
     * @var SettingFactory
     */
    private $settingFactory;

    /**
     * @var SettingDataFactory
     */
    private $settingDataFactory;

    /**
     * @var CustomerExtensionFactory
     */
    private $customerExtensionFactory;

    /**
     * @param CardFactory $cardFactory
     * @param SettingFactory $settingFactory
     * @param SettingDataFactory $settingDataFactory
     * @param CustomerExtensionFactory $customerExtensionFactory
     */
    public function __construct(
        CardFactory $cardFactory,
        SettingFactory $settingFactory,
        SettingDataFactory $settingDataFactory,
        CustomerExtensionFactory $customerExtensionFactory
    ) {
        $this->cardFactory = $cardFactory;
        $this->settingFactory = $settingFactory;
        $this->settingDataFactory = $settingDataFactory;
        $this->customerExtensionFactory = $customerExtensionFactory;
    }

    public function afterGetById($subject, $result)
    {
        $this->addCardInfoExtensionAttribute($result);
        $this->addSettingsExtensionAttribute($result);
        return $result;
    }

    private function addCardInfoExtensionAttribute($customer)
    {
        $customerExtension = ($customer->getExtensionAttributes()) ?: $this->customerExtensionFactory->create();

        $cards = $this->cardFactory->create()->getCollection()->addFieldToSelect(
            '*'
        )->addFieldToFilter(
            'customer_id', $customer->getId()
        )->setOrder(
            'card_id', 'desc'
        );

        $items = ($cards->getItems()) ?: [];
        $customerExtension->setCardInfo($items);
        $customer->setExtensionAttributes($customerExtension);
    }
    
    private function addSettingsExtensionAttribute($customer)
    {
        $customerExtension = ($customer->getExtensionAttributes()) ?: $this->customerExtensionFactory->create();

        $items = [];
        $model = $this->getSettingByCustomer($customer->getId());
        if ($model->getId()) {
            $data = json_decode($model->getSettingData(), true);
            
            foreach ($data as $item) {
                $setting = $this->settingDataFactory->create();
                $items[] = $setting->addData($item);
            }
        }
        
        $customerExtension->setSettings($items);
        $customer->setExtensionAttributes($customerExtension);
    }

    private function getSettingByCustomer($customerId)
    {
        return $this->settingFactory->create()->getCollection()->addFieldToSelect(
            '*'
        )->addFieldToFilter(
            'customer_id', $customerId
        )->setOrder(
            'setting_id', 'desc'
        )->getFirstItem();
    }
}
