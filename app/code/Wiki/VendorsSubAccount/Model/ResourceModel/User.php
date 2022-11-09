<?php
/**
 * Copyright (c) 2017 Wiki Co ltd. All rights reserved.
 */

namespace Wiki\VendorsSubAccount\Model\ResourceModel;

use Magento\Framework\Exception\LocalizedException;

class User extends \Wiki\Vendors\Model\ResourceModel\Vendor
{
    /**
     * Add vendor user
     * 
     * @param number $customerId
     * @param number $vendorId
     * @param number $roleId
     * @param number $isActive
     * @return \Wiki\VendorsSubAccount\Model\ResourceModel\User
     */
    public function addVendorUser($customerId, $vendorId, $roleId = 0, $isActive = 1){
        $conn = $this->getConnection();
        $userTbl = $this->getTable('ves_vendor_user');
        $conn->insert($userTbl, ['vendor_id' => $vendorId, 'customer_id' => $customerId, 'is_super_user' => 0, 'is_active_user' => $isActive, 'role_id' =>$roleId]);
        
        return $this;
    }
    
    /**
     * Update user data
     * 
     * @param \Magento\Customer\Model\Customer $customer
     * @throws LocalizedException
     * @return \Wiki\VendorsSubAccount\Model\ResourceModel\User
     */
    public function loadUserData(\Magento\Customer\Model\Customer $customer){
        $conn = $this->getConnection();
        $userTbl = $this->getTable('ves_vendor_user');
        
        $select = $conn->select();
        $select->from(
            $userTbl,
            ['vendor_id', 'is_super_user', 'role_id', 'is_active_user']
        )->where(
            'customer_id = :customer_id'
        );
        $bind = ['customer_id' => $customer->getId()];
        
        $rowData = $conn->fetchRow($select, $bind);
        if($rowData && is_array($rowData)){
            $customer->addData($rowData);
        }
        
        return $this;
    }
    
    /**
     * Get User Data
     * 
     * @param int|\Magento\Customer\Model\Customer $customerId
     * @return multitype:
     */
    public function getUserData($customerId){
        if($customerId instanceof \Magento\Customer\Model\Customer){
            $customerId = $customerId->getId();
        }
        $conn = $this->getConnection();
        $userTbl = $this->getTable('ves_vendor_user');
        
        $select = $conn->select();
        $select->from(
            $userTbl,
            ['vendor_id', 'is_super_user', 'role_id', 'is_active_user']
        )->where(
            'customer_id = :customer_id'
        );
        $bind = ['customer_id' => $customerId];
        
        return $conn->fetchRow($select, $bind);
    }
    
    /**
     * Update user data
     * 
     * @param int|\Magento\Customer\Model\Customer $customerId
     * @param int $roleId
     * @param boolean $isActive
     * @return \Wiki\VendorsSubAccount\Model\ResourceModel\User
     */
    public function updateUserData($customerId, $roleId, $isActive=null){
        if($customerId instanceof \Magento\Customer\Model\Customer){
            $customerId = $customerId->getId();
        }
        $conn = $this->getConnection();
        $userTbl = $this->getTable('ves_vendor_user');
        $bind = ['role_id' => $roleId];
        
        if($isActive !== null){
            $bind['is_active_user'] = $isActive;
        }
        $conn->update($userTbl, $bind,'customer_id='.$customerId);
        
        return $this;
    }
    
    /**
     * Is Super User
     * 
     * @param int|\Magento\Customer\Model\Customer $customerId
     */
    public function isSupserUser($customerId){
        if($customerId instanceof \Magento\Customer\Model\Customer){
            $customerId = $customerId->getId();
        }
        $conn = $this->getConnection();
        $userTbl = $this->getTable('ves_vendor_user');
        
        $select = $conn->select();
        $select->from(
            $userTbl,
            ['is_super_user']
        )->where(
            'customer_id = :customer_id'
        );
        $bind = ['customer_id' => $customerId];
        
        return $conn->fetchOne($select, $bind);
    }
}
