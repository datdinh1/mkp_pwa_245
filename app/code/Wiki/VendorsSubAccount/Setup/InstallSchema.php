<?php
/**
 * Copyright (c) 2017 Wiki Co ltd. All rights reserved.
 */

namespace Wiki\VendorsSubAccount\Setup;

use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\InstallSchemaInterface;

class InstallSchema implements InstallSchemaInterface
{
    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
    
        /**
         * Create table 'ves_vendor_subaccount_role'
        */
        $table = $installer->getConnection()->newTable(
            $installer->getTable('ves_vendor_subaccount_role')
        )->addColumn(
            'role_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
            'Id'
        )->addColumn(
            'vendor_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['unsigned' => true, 'nullable' => false,],
            'Vendor Id'
        )->addColumn(
            'role_name',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            [],
            'Role Name'
        )->addForeignKey(
            $installer->getFkName('ves_vendor_subaccount_role', 'vendor_id', 'ves_vendor_entity', 'entity_id'),
            'vendor_id',
            $installer->getTable('ves_vendor_entity'),
            'entity_id',
            \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
        )->setComment(
            'Vendor Role'
        );
        $installer->getConnection()->createTable($table);
        
        
        /**
         * Create table 'ves_vendor_subaccount_rule'
         */
        $table = $installer->getConnection()->newTable(
            $installer->getTable('ves_vendor_subaccount_rule')
        )->addColumn(
            'rule_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
            'Id'
        )->addColumn(
            'role_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['unsigned' => true, 'nullable' => false,],
            'Role Id'
        )->addColumn(
            'resource_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            [],
            'Resource Id'
        )->addForeignKey(
            $installer->getFkName('ves_vendor_subaccount_rule', 'vendor_id', 'ves_vendor_subaccount_role', 'role_id'),
            'role_id',
            $installer->getTable('ves_vendor_subaccount_role'),
            'role_id',
            \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
        )->setComment(
            'Vendor Role'
        );
        $installer->getConnection()->createTable($table);
    
        
        $installer->getConnection()->addColumn(
            $setup->getTable('ves_vendor_user'),
            'role_id',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                'unsigned' => true,
                'nullable' => false,
                'default' => '0',
                'after' => 'is_super_user',
                'comment' => 'Role Id'
            ]
        );
        
        $installer->getConnection()->addColumn(
            $setup->getTable('ves_vendor_user'),
            'is_active_user',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_BOOLEAN,
                'unsigned' => true,
                'nullable' => false,
                'default' => '1',
                'after' => 'role_id',
                'comment' => 'Is Active'
            ]
            );
        
        $installer->endSetup();
    }
}
