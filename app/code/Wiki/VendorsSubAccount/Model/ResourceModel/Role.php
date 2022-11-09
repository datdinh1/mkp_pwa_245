<?php
/**
 * Copyright (c) 2017 Wiki Co ltd. All rights reserved.
 */

namespace Wiki\VendorsSubAccount\Model\ResourceModel;

class Role extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('ves_vendor_subaccount_role', 'role_id');
    }
    
    /**
     * Update resources
     * 
     * @param \Wiki\VendorsSubAccount\Model\Role $role
     * @param array $resources
     * @return \Wiki\VendorsSubAccount\Model\ResourceModel\Role
     */
    public function updateResources(\Wiki\VendorsSubAccount\Model\Role $role, $resources){
        $conn = $this->getConnection();
        $ruleTbl = $this->getTable('ves_vendor_subaccount_rule');
        
        /* Delete exist resources*/
        if($role->getId()){
            $conn->delete(
                $ruleTbl,
                'role_id="'.$role->getId().'"'
            );
        }
        
        /*Insert new resources*/
        if(!$resources || !is_array($resources) || !sizeof($resources)) return;
        $data = [];
        foreach($resources as $resource){
            $data[] = ['role_id' => $role->getId(), 'resource_id' => $resource];
        }
        $conn->insertArray($ruleTbl, ['role_id', 'resource_id'], $data);
        return $this;
    }
    
    /**
     * Get Selected Resources
     * 
     * @param \Wiki\VendorsSubAccount\Model\Role $role
     * @return multitype:
     */
    public function getSelectedResources(\Wiki\VendorsSubAccount\Model\Role $role){
        $conn = $this->getConnection();
        $ruleTbl = $this->getTable('ves_vendor_subaccount_rule');
        $select = $conn->select();
        $select->from(
            $ruleTbl,
            ['resource_id']
        )->where(
            'role_id = (?)', $role->getId()
        );
        
        
        return $conn->fetchCol($select);
    }
    
    /**
     * Delete all related resources.
     * 
     * @see \Magento\Framework\Model\ResourceModel\Db\AbstractDb::_beforeDelete()
     */
    protected function _beforeDelete(\Magento\Framework\Model\AbstractModel $role)
    {
        parent::_beforeDelete($role);
        $conn = $this->getConnection();
        $ruleTbl = $this->getTable('ves_vendor_subaccount_rule');
        
        /* Delete exist resources*/
        if($role->getId()){
            $conn->delete(
                $ruleTbl,
                'role_id="'.$role->getId().'"'
            );
        }
        return $this;
    }
    
    /**
     * Get all user related to the role
     * 
     * @param \Wiki\VendorsSubAccount\Model\Role $role
     */
    public function getAllUserIds(\Wiki\VendorsSubAccount\Model\Role $role){
        $conn = $this->getConnection();
        $userTbl = $this->getTable('ves_vendor_user');
        $select = $conn->select();
        $select->from(
            $userTbl,
            ['customer_id']
        )->where(
            'role_id = (?)', $role->getId()
        );

        return $conn->fetchCol($select);
    }
}
