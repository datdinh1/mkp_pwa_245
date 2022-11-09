<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Wiki\VendorsCoupon\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * @codeCoverageIgnore
 */
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
         * Create table 'ves_vendor_coupon'
         */
        $table = $installer->getConnection()->newTable(
            $installer->getTable('ves_vendor_coupon')
        )->addColumn(
            'coupon_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
            'Coupon Id'
        )->addColumn(
            'vendor_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['unsigned' => true, 'nullable' => false,],
            'Vendor Id'
        )->addColumn(
            'code',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            [],
            'Coupon Code'
        )->addColumn(
            'amount',
            \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
            '12,4',
            ['nullable' => false, 'default' => 0, 'unsigned' => true],
            'Discount Amount'
        )->addColumn(
            'usage_limit',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['nullable' => false, 'default' => 0, 'unsigned' => true],
            'Usage Limit'
        )->addColumn(
            'usage_per_customer',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['nullable' => false, 'default' => 0, 'unsigned' => true],
            'Usage per Customer'
        )->addColumn(
            'times_used',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['nullable' => false, 'default' => 0, 'unsigned' => true],
            'Times Used'
        )->addColumn(
            'created_at',
            \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false],
            'Created At'
        )->addColumn(
            'from_date',
            \Magento\Framework\DB\Ddl\Table::TYPE_DATE,
            null,
            [],
            'From Date'
        )->addColumn(
            'to_date',
            \Magento\Framework\DB\Ddl\Table::TYPE_DATE,
            null,
            [],
            'To Date'
        )->addIndex(
            $installer->getIdxName(
                'ves_vendor_coupon',
                ['vendor_id'],
                \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE
            ),
            ['vendor_id'],
            ['type' => \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE]
        )->addForeignKey(
            $installer->getFkName('ves_vendor_coupon', 'vendor_id', 'ves_vendor_entity', 'entity_id'),
            'vendor_id',
            $installer->getTable('ves_vendor_entity'),
            'entity_id',
            \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
        )->setComment(
            'Store Coupon Table'
        )->setOption('type', 'InnoDB')
        ->setOption('charset', 'utf8');
        $installer->getConnection()->createTable($table);
        $installer->endSetup();

    }
}
