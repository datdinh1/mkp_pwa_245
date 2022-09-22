<?php

namespace Wiki\VendorsSalesRule\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        if (version_compare($context->getVersion(), '0.0.2') < 0) {
            $installer = $setup;
            $installer->getConnection()->addColumn(
                $installer->getTable('salesrule'),
                'image',
                [
                    'type' => Table::TYPE_TEXT,
                    'length' => null,
                    'unsigned' => true,
                    'nullable' => false,
                    'default' => '',
                    'comment' => 'Image Sales Rule',
                ]
            );
        }
        if (version_compare($context->getVersion(), '0.0.3') < 0) {
            $installer = $setup;
            $installer->getConnection()->addColumn(
                $installer->getTable('salesrule'),
                'coupon_by_seller',
                [
                    'type' => Table::TYPE_TEXT,
                    'length' => null,
                    'unsigned' => true,
                    'nullable' => false,
                    'default' => '',
                    'comment' => 'Coupon By Seller',
                ]
            );
        }

        if (version_compare($context->getVersion(), '0.0.4', '<')) {
            $installer = $setup;
            $installer->getConnection()
                ->changeColumn(
                    $installer->getTable('salesrule'),
                    'image',
                    'image',
                    [
                        'type' => Table::TYPE_TEXT,
                        'nullable' => true,
                        'default' => null,
                        'comment' => 'Default of image is change'
                    ]
                );
        }
        if (version_compare($context->getVersion(), '0.0.5', '<')) {
            $installer = $setup;
            $installer->getConnection()
                ->changeColumn(
                    $installer->getTable('salesrule'),
                    'coupon_by_seller',
                    'coupon_by_seller',
                    [
                        'type' => Table::TYPE_TEXT,
                        'nullable' => true,
                        'default' => null,
                        'comment' => 'Default of coupon by seller is change'
                    ]
                );
        }
        if (version_compare($context->getVersion(), '0.0.6') < 0) {
            $installer = $setup;
            $installer->getConnection()->addColumn(
                $installer->getTable('catalogrule'),
                'vendor_id',
                [
                    'type' => Table::TYPE_TEXT,
                    'length' => null,
                    'unsigned' => true,
                    'nullable' => false,
                    'default' => '',
                    'comment' => 'Seller Id',
                ]
            );
        }

        if (version_compare($context->getVersion(), '0.0.7', '<')) {
            $installer = $setup;
            $installer->getConnection()
                ->changeColumn(
                    $installer->getTable('catalogrule'),
                    'vendor_id',
                    'vendor_id',
                    [
                        'type' => Table::TYPE_TEXT,
                        'default' => null,

                    ]
                );
        }

        if (version_compare($context->getVersion(), '0.0.8') < 0) {
            $collect = $setup->getTable('wiki_collect_coupon');
            if ($setup->getConnection()->isTableExists($collect) != true) {
                $tableCollect = $setup->getConnection()
                    ->newTable($collect)
                    ->addColumn(
                        'id',
                        \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                        null,
                        ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                        'Id'
                    )
                    ->addColumn(
                        'customer_id',
                        \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                        null,
                        ['nullable' => false, 'default' => 1],
                        'Status'
                    )->addColumn(
                        'rule_id',
                        \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                        null,
                        ['nullable' => false],
                        'Rule Id'
                    )->addColumn(
                        'created_at',
                        \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                        null,
                        ['nullable' => false],
                        'Created At'
                    )
                    ->setComment('User Collect Coupon ')
                    ->setOption('type', 'InnoDB')
                    ->setOption('charset', 'utf8');
                $setup->getConnection()->createTable($tableCollect);
            }
        }

        if (version_compare($context->getVersion(), '0.0.9') < 0) {
            $installer = $setup;
            $installer->getConnection()->addColumn(
                $installer->getTable('salesrule'),
                'type',
                [
                    'type' => Table::TYPE_TEXT,
                    'nullable' => true,
                    'default' => null,
                    'comment' => 'All products or Some Products'
                ]
            );
        }

        if (version_compare($context->getVersion(), '0.0.10') < 0) {
            $installer = $setup;
            $installer->getConnection()->addColumn(
                $installer->getTable('salesrule'),
                'is_recommend',
                [
                    'type' => Table::TYPE_SMALLINT,
                    'nullable' => true,
                    'default' => 0,
                    'comment' => 'Is Recommend'
                ]
            );
        }
        if (version_compare($context->getVersion(), '0.0.11') < 0) {
            $installer = $setup;
            $installer->getConnection()->addColumn(
                $installer->getTable('salesrule'),
                'is_display_all',
                [
                    'type' => Table::TYPE_SMALLINT,
                    'nullable' => true,
                    'default' => 0,
                    'comment' => 'Show all coupon'
                ]
                );
                
        }
        if (version_compare($context->getVersion(), '0.0.12') < 0) {
            $installer = $setup;
            $installer->getConnection()->addColumn(
                $installer->getTable('wiki_collect_coupon'),
                'code',
                [
                    'type' => Table::TYPE_TEXT,
                    'nullable' => true,
                    'default' => null,
                    'comment' => 'Coupon Code'
                ]
                );
                
        }
        if (version_compare($context->getVersion(), '0.0.13') < 0) {
            $installer = $setup;
            $installer->getConnection()->addColumn(
                $installer->getTable('salesrule'),
                'max_discount_amount',
                [
                    'type' => Table::TYPE_INTEGER,
                    'nullable' => true,
                    'default' => 0,
                    'comment' => 'Max Discount Amount'
                ]
                );
                
        }
        if (version_compare($context->getVersion(), '0.0.14') < 0) {
            $installer = $setup;
            $installer->getConnection()->addColumn(
                $installer->getTable('salesrule'),
                'minimum_price',
                [
                    'type' => Table::TYPE_INTEGER,
                    'nullable' => true,
                    'default' => 0,
                    'comment' => 'Minimum Price'
                ]
                );
                
        }
        if (version_compare($context->getVersion(), '0.0.15') < 0) {
            $installer = $setup;
            $installer->getConnection()->addColumn(
                $installer->getTable('salesrule'),
                'category_id',
                [
                    'type' => Table::TYPE_INTEGER,
                    'nullable' => true,
                    'default' => 0,
                    'comment' => 'Category Id'
                ]
                );
                
        }
        
        if (version_compare($context->getVersion(), '0.1.0') < 0) {
            $setup->getConnection()->addColumn(
                $setup->getTable('salesrule_coupon'),
                'auto_generate',
                [
                    'type' => Table::TYPE_TEXT,
                    'nullable' => true,
                    'default' => null,
                    'comment' => 'Auto Generate'
                ]
            );
            
            $collect = $setup->getTable('wiki_generate_varchar_code');
            if ($setup->getConnection()->isTableExists($collect) != true) {
                $tableCollect = $setup->getConnection()
                    ->newTable($collect)
                    ->addColumn(
                        'id',
                        Table::TYPE_INTEGER,
                        null,
                        ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                        'Id'
                    )
                    ->addColumn(
                        'auto_generate',
                        Table::TYPE_TEXT,
                        12,
                        ['nullable' => false, 'default' => null],
                        'Auto Generate'
                    )
                    ->setComment('Auto Generate Varchar Code')
                    ->setOption('type', 'InnoDB')
                    ->setOption('charset', 'utf8');
                $setup->getConnection()->createTable($tableCollect);
            }
        }
    }
}
