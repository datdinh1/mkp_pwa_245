<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\StoreApi\Model\Api;

use Wiki\StoreApi\Model\SettingFactory;
use Wiki\StoreApi\Api\StoreManagementInterface;
use Wiki\StoreApi\Model\Api\Data\ShippingMethodFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Shipping\Model\Config;

class StoreManagement implements StoreManagementInterface
{
    /**
     * @var SettingFactory
     */
    private $settingFactory;

    /**
     * @var ShippingMethodFactory
     */
    protected $shippingMethodFactory;

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var Config
     */
    protected $shipconfig;

    /**
     * @param SettingFactory $settingFactory
     */
    public function __construct(
        SettingFactory                  $settingFactory,
        ShippingMethodFactory           $shippingMethodFactory,
        ScopeConfigInterface            $scopeConfig,
        Config                          $shipconfig
    ) {
        $this->settingFactory           = $settingFactory;
        $this->shippingMethodFactory    = $shippingMethodFactory;
        $this->shipconfig               = $shipconfig;
        $this->scopeConfig              = $scopeConfig;
    }

    /**
	 * {@inheritdoc}
	 */
    public function saveSetting($customerId, $settings = [])
    {
        try {
            $data = [];
            foreach ($settings as $item) {
                $data[] = $item->getData();
            }

            if (!empty($data)) {
                $model = $this->getSettingByCustomer($customerId);
                if (!$model->getId()) {
                    $model->setCustomerId($customerId);
                }
                $model->setSettingData(json_encode($data, JSON_UNESCAPED_UNICODE));
                $model->save();
            }
        }
        catch (\Exception $e) {
            return false;
        }
        return true;
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

    public function getShippingMethods()
    {
        $activeCarriers = $this->shipconfig->getActiveCarriers();
        $methods = [];
        foreach ( $activeCarriers as $carrierCode => $carrierModel ){
           if ( $carrierMethods = $carrierModel->getAllowedMethods() ){
               foreach ( $carrierMethods as $methodCode => $methodTitle ){
                   $data['carrier_code'] = $carrierCode;
                   $data['method_title'] = $methodTitle;
               }
               $data['carrier_title'] = $this->scopeConfig->getValue('carriers/' . $carrierCode . '/title');
            }
            $shippingMethod = $this->shippingMethodFactory->create();
            $shippingMethod->setData($data);
            //$shippingMethod->setLogoShippop($this->helperShippop->getLogo($carrierCode));
            $methods[] = $shippingMethod;
        }
    
        return $methods;    
    }
}
