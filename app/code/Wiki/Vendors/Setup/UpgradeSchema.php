<?php

/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Wiki\Vendors\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * Upgrade the Catalog module DB scheme
 */
class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * {@inheritdoc}
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        if ($setup->getConnection()->isTableExists('cart_multiple_shop') == false) {
            $table = $setup->getConnection()->newTable(
                $setup->getTable('cart_multiple_shop')
            )->addColumn(
                'card_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true]
            )->addColumn(
                'customer_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                20,
                ['unsigned' => true, 'nullable' => true]
            )->addColumn(
                'product',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                null,
                ['nullable' => true]
            );
            $setup->getConnection()->createTable($table);
        }
        if (version_compare($context->getVersion(), '2.2.1') < 0) {
            $setup->getConnection()->addColumn(
                $setup->getTable('ves_vendor_eav_attribute'),
                'hide_from_vendor_panel',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                    'nullable' => true,
                    'after' => 'is_used_in_registration_form',
                    'default' => '0',
                    'comment' => 'Hide Attribute From Vendor Panel'
                ]
            );
        }

        if (version_compare($context->getVersion(), '2.2.4') < 0) {
            $setup->getConnection()->addColumn(
                $setup->getTable('customer_entity'),
                'mobile',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'nullable' => true,
                    'after' => 'email',
                    'default' => '',
                    'comment' => 'Phone Number Of Customer.'
                ]
            );
        }
        if (version_compare($context->getVersion(), '2.2.8') < 0) {
            $setup->getConnection()->addColumn(
                $setup->getTable('ves_vendor_entity'),
                'main_address',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    'size' => 10,
                    'nullable' => true,
                    'unsigned' => true,
                    'default' => null,
                    'comment' => 'Main Address.'
                ]
            );
            $setup->getConnection()->addColumn(
                $setup->getTable('ves_vendor_entity'),
                'shipping_address',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    'size' => 10,
                    'nullable' => true,
                    'unsigned' => true,
                    'default' => null,
                    'comment' => 'Shipping Address.'
                ]
            );

            $setup->getConnection()->addColumn(
                $setup->getTable('ves_vendor_entity'),
                'return_address',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    'size' => 10,
                    'nullable' => true,
                    'unsigned' => true,
                    'default' => null,
                    'comment' => 'Return Address.'
                ]
            );
        }

        if (version_compare($context->getVersion(), '2.2.9') < 0) {
            $setup->getConnection()->addColumn(
                $setup->getTable('ves_vendor_entity'),
                'novice',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                    'nullable' => false,
                    'after' => 'status',
                    'default' => 1,
                    'comment' => 'Novice Seller'
                ]
            );
        }

        if (version_compare($context->getVersion(), '2.2.10', '<')) {
            $setup->getConnection()->changeColumn(
                $setup->getTable('ves_vendor_entity'),
                'novice',
                'is_novice',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                    'nullable' => false,
                    'after' => 'status',
                    'default' => 1,
                    'comment' => 'Novice Seller'
                ]
            );
        }


        $setup->endSetup();
    }
}
