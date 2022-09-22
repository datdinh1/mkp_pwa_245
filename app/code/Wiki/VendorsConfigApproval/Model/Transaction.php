<?php

namespace Wiki\VendorsConfigApproval\Model;

use Wiki\VendorsConfigApproval\Model\Config;

class Transaction extends \Magento\Framework\DB\Transaction
{
    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $objectManager;
    
    /**
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     */
    public function __construct(
        \Magento\Framework\ObjectManagerInterface $objectManager
    ){
        $this->objectManager = $objectManager;
    }
    /**
     * (non-PHPdoc)
     * @see \Magento\Framework\DB\Transaction::save()
     * @SuppressWarnings(PHPMD.ElseExpression)
     */
    public function save()
    {
        /** @var \Wiki\VendorsConfigApproval\Helper\Data $helper */
        $helper = $this->objectManager->get('Wiki\VendorsConfigApproval\Helper\Data');
        
        $this->_startTransaction();
        $error = false;
        /** @var \Wiki\VendorsConfig\Helper\Data $configHelper */
        $configHelper = $this->objectManager->get('Wiki\VendorsConfig\Helper\Data');
        
        $fieldsRestriction = $helper->getFieldsRestriction();
        try {
            foreach ($this->_objects as $object) {
                /*These attributes will not need to be approved*/
                if(!in_array($object->getPath(), $fieldsRestriction)){
                    $object->save();
                    continue;
                }
                $object->beforeSave();
                $data = $object->getData();
                if(!isset($data['value'])) continue;
                
                /* Check if the config is already pending for approval*/
                $configCollection = $this->objectManager->create('Wiki\VendorsConfigApproval\Model\ResourceModel\Config\Collection');
                $configCollection->addFieldToFilter('vendor_id', $object->getVendorId())
                    ->addFieldToFilter('store_id', $object->getStoreId())
                    ->addFieldToFilter('path', $object->getPath());
                
                $originValue = $configHelper->getVendorConfig($object->getPath(), $object->getVendorId());
                
                if($configCollection->count()){
                    $configUpdate = $configCollection->getFirstItem();
                    if($object->getValue() == $originValue){
                        $configUpdate->delete();
                    }else{
                        $configUpdate->setValue($object->getValue())->setStatus(Config::STATUS_PENDING)->save();
                    }
                }else{
                    if($object->getValue() == $originValue) continue;
                    $configUpdate = $this->objectManager->create('Wiki\VendorsConfigApproval\Model\Config');
                    $configUpdate->setData([
                        'config_id' => $object->getData('config_id'),
                        'vendor_id' => $object->getData('vendor_id'),
                        'store_id'  => $object->getData('store_id'),
                        'path'      => $object->getData('path'),
                        'value'     => $object->getData('value'),
                        'status'    => Config::STATUS_PENDING,
                    ])->save();
                }
            }
        } catch (\Exception $e) {
            $error = $e;
        }
    
        if ($error === false) {
            try {
                $this->_runCallbacks();
            } catch (\Exception $e) {
                $error = $e;
            }
        }
    
        if ($error) {
            $this->_rollbackTransaction();
            throw $error;
        }
        
        $this->_commitTransaction();
    
        return $this;
    }
    
    public function delete(){
        $this->_startTransaction();
        $error = false;
        
        try {
            foreach ($this->_objects as $object) {
                /*Delete all pending update relate to this config*/
                $connection = $this->objectManager->create('Wiki\VendorsConfigApproval\Model\ResourceModel\Config')->getConnection();
                $connection->delete(
                    $object->getCollection()->getTable('ves_vendor_config_update'),
                    ['path=?' => $object->getPath(), 'vendor_id=?' => $object->getVendorId(), 'store_id=?' => $object->getStoreId()]
                );
                $object->delete();
            }
        } catch (\Exception $e) {
            $error = $e;
        }
        
        if ($error === false) {
            try {
                $this->_runCallbacks();
            } catch (\Exception $e) {
                $error = $e;
            }
        }
        
        if ($error) {
            $this->_rollbackTransaction();
            throw $error;
        } else {
            $this->_commitTransaction();
        }
        return $this;
    }
}
