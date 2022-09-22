<?php

/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Wiki\VendorsSales\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

/**
 * @codeCoverageIgnore
 */
class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * {@inheritdoc}
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        if (version_compare($context->getVersion(), '2.0.0', '<')) {
            $setup->getConnection()->addColumn(
                $setup->getTable('quote_item'),
                'vendor_id',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    'unsigned' => true,
                    'nullable' => false,
                    'default' => '0',
                    'after' => 'quote_id',
                    'comment' => 'Vendor Id'
                ]
            );

            $setup->getConnection()->addColumn(
                $setup->getTable('sales_order_item'),
                'vendor_order_id',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    'unsigned' => true,
                    'nullable' => false,
                    'default' => '0',
                    'after' => 'order_id',
                    'comment' => 'Vendor Order Id'
                ]
            );

            $setup->getConnection()->addColumn(
                $setup->getTable('sales_order_item'),
                'vendor_id',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    'unsigned' => true,
                    'nullable' => false,
                    'default' => '0',
                    'after' => 'order_id',
                    'comment' => 'Vendor Id'
                ]
            );

            $setup->getConnection()->addColumn(
                $setup->getTable('sales_invoice_item'),
                'vendor_invoice_id',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    'unsigned' => true,
                    'nullable' => false,
                    'default' => '0',
                    'after' => 'entity_id',
                    'comment' => 'Vendor Id'
                ]
            );

            $setup->getConnection()->addColumn(
                $setup->getTable('sales_shipment'),
                'vendor_order_id',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    'unsigned' => true,
                    'nullable' => false,
                    'default' => '0',
                    'after' => 'entity_id',
                    'comment' => 'Vendor Id'
                ]
            );

            $setup->getConnection()->addColumn(
                $setup->getTable('sales_shipment_grid'),
                'vendor_order_id',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    'unsigned' => true,
                    'nullable' => false,
                    'default' => '0',
                    'after' => 'entity_id',
                    'comment' => 'Vendor Id'
                ]
            );

            $setup->getConnection()->addColumn(
                $setup->getTable('sales_creditmemo'),
                'vendor_order_id',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    'unsigned' => true,
                    'nullable' => false,
                    'default' => '0',
                    'after' => 'entity_id',
                    'comment' => 'Vendor Id'
                ]
            );

            $setup->getConnection()->addColumn(
                $setup->getTable('sales_creditmemo_grid'),
                'vendor_order_id',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    'unsigned' => true,
                    'nullable' => false,
                    'default' => '0',
                    'after' => 'entity_id',
                    'comment' => 'Vendor Id'
                ]
            );
        }
        if (version_compare($context->getVersion(), '2.0.1', '<')) {
            /*Change the created at column*/
            $setup->getConnection()->changeColumn(
                $setup->getTable('ves_vendor_sales_order'),
                'created_at',
                'created_at',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                    'nullable' => false,
                    'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT,
                    'comment' => 'Created At'
                ]
            );

            $setup->getConnection()->addColumn(
                $setup->getTable('ves_vendor_sales_order'),
                'total_qty_ordered',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                    'unsigned' => true,
                    'nullable' => false,
                    'default' => '0',
                    'after' => 'total_paid',
                    'comment' => 'Total Qty Ordered'
                ]
            );
        }

        if (version_compare($context->getVersion(), '2.0.2', '<')) {
            $setup->getConnection()->addColumn(
                $setup->getTable('sales_order_status_history'),
                'vendor_id',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                    'unsigned' => true,
                    'nullable' => false,
                    'default' => '0',
                    'after' => 'parent_id',
                    'comment' => 'Vendor Id'
                ]
            );

            $setup->getConnection()->addColumn(
                $setup->getTable('sales_order_status_history'),
                'vendor_order_status',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                    'unsigned' => true,
                    'nullable' => false,
                    'default' => '0',
                    'after' => 'status',
                    'comment' => 'Vendor Statuc Order'
                ]
            );
        }

        if (version_compare($context->getVersion(), '2.0.2', '<')) {
            $setup->getConnection()->addColumn(
                $setup->getTable('sales_order_status_history'),
                'vendor_id',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                    'unsigned' => true,
                    'nullable' => false,
                    'default' => '0',
                    'after' => 'parent_id',
                    'comment' => 'Vendor Id'
                ]
            );

            $setup->getConnection()->addColumn(
                $setup->getTable('sales_order_status_history'),
                'vendor_order_status',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                    'unsigned' => true,
                    'nullable' => false,
                    'default' => '0',
                    'after' => 'status',
                    'comment' => 'Vendor Statuc Order'
                ]
            );
        }

        if (version_compare($context->getVersion(), '2.0.3', '<')) {
            $setup->getConnection()->addColumn(
                $setup->getTable('ves_vendor_sales_order'),
                'base_tax_canceled',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                    'length' => "12,4",
                    'nullable' => true,
                    'after' => 'total_refunded',
                    'comment' => 'Base Tax Canceled'
                ]
            );

            $setup->getConnection()->addColumn(
                $setup->getTable('ves_vendor_sales_order'),
                'tax_canceled',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                    'length' => "12,4",
                    'nullable' => true,
                    'after' => 'total_refunded',
                    'comment' => 'Tax Canceled'
                ]
            );

            $setup->getConnection()->addColumn(
                $setup->getTable('ves_vendor_sales_order'),
                'base_tax_invoiced',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                    'length' => "12,4",
                    'nullable' => true,
                    'after' => 'total_refunded',
                    'comment' => 'Base Tax Invoiced'
                ]
            );

            $setup->getConnection()->addColumn(
                $setup->getTable('ves_vendor_sales_order'),
                'tax_invoiced',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                    'length' => "12,4",
                    'nullable' => true,
                    'after' => 'total_refunded',
                    'comment' => 'Tax Invoiced'
                ]
            );

            $setup->getConnection()->addColumn(
                $setup->getTable('ves_vendor_sales_order'),
                'base_tax_refunded',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                    'length' => "12,4",
                    'nullable' => true,
                    'after' => 'total_refunded',
                    'comment' => 'Base Tax Refunded'
                ]
            );

            $setup->getConnection()->addColumn(
                $setup->getTable('ves_vendor_sales_order'),
                'tax_refunded',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                    'length' => "12,4",
                    'nullable' => true,
                    'after' => 'total_refunded',
                    'comment' => 'Tax Refunded'
                ]
            );

            $setup->getConnection()->addColumn(
                $setup->getTable('ves_vendor_sales_order'),
                'base_subtotal_incl_tax',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                    'length' => "12,4",
                    'nullable' => true,
                    'after' => 'subtotal_incl_tax',
                    'comment' => 'Base Subtotal Incl Tax'
                ]
            );
        }

        if (version_compare($context->getVersion(), '2.0.4', '<')) {
            $setup->getConnection()->addColumn(
                $setup->getTable('ves_vendor_sales_order'),
                'shipping_tax_refunded',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                    'length' => "12,4",
                    'nullable' => true,
                    'after' => 'shipping_tax_amount',
                    'comment' => 'Shipping Tax Refunded'
                ]
            );

            $setup->getConnection()->addColumn(
                $setup->getTable('ves_vendor_sales_order'),
                'base_shipping_tax_refunded',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                    'length' => "12,4",
                    'nullable' => true,
                    'after' => 'base_shipping_tax_amount',
                    'comment' => 'Base Shipping Tax Refunded'
                ]
            );
        }

        if (version_compare($context->getVersion(), '2.0.5', '<')) {
            $setup->getConnection()->addColumn(
                $setup->getTable('ves_vendor_sales_order'),
                'state',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 32,
                    'nullable' => true,
                    'after' => 'order_id',
                    'comment' => 'State'
                ]
            );

            $setup->getConnection()->update(
                $setup->getTable('ves_vendor_sales_order'),
                ['state' => new \Zend_Db_Expr('status')]
            );
        }
        if (version_compare($context->getVersion(), '2.0.6', '<')) {
            $setup->getConnection()->addColumn(
                $setup->getTable('sales_order'),
                'time_to_receive',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 32,
                    'nullable' => true,
                    'after' => 'entity_id',
                    'comment' => 'Time To Receive'
                ]
            );

            $setup->getConnection()->update(
                $setup->getTable('sales_order'),
                ['state' => new \Zend_Db_Expr('status')]
            );
        }
        if (version_compare($context->getVersion(), '2.0.7', '<')) {
            $setup->getConnection()->addColumn(
                $setup->getTable('sales_order'),
                'wk_status',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 32,
                    'nullable' => true,
                    'after' => 'status',
                    'comment' => 'Wiki Status'
                ]
            );
        }
            if ($setup->getConnection()->isTableExists('wiki_quote_is_active') != true) {
                $table = $setup->getConnection()->newTable('wiki_quote_is_active')
                    ->addColumn(
                        'id',
                        Table::TYPE_INTEGER,
                        null,
                        ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                        'Id'
                    )
                    ->addColumn(
                        'customer_id',
                        Table::TYPE_INTEGER,
                        null,
                        ['nullbale' => false],
                        'Customer Id'
                    )
                    ->addColumn(
                        'quote_id',
                        Table::TYPE_INTEGER,
                        null,
                        ['nullbale' => false],
                        'Quote Id (is active)'
                    )
                    ->setComment('Mapping Quote is active');
                $setup->getConnection()->createTable($table);
            }
            if (version_compare($context->getVersion(), '2.0.9', '<')) {
                if ($setup->getConnection()->isTableExists('wiki_request_return_order') != true) {
                    $table = $setup->getConnection()->newTable('wiki_request_return_order')
                        ->addColumn(
                            'id',
                            Table::TYPE_INTEGER,
                            null,
                            ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                            'Id'
                        )
                        ->addColumn(
                            'order_id',
                            Table::TYPE_INTEGER,
                            null,
                            ['nullbale' => false],
                            'Order Id'
                        )
                        ->addColumn(
                            'items',
                            Table::TYPE_TEXT,
                            null,
                            ['nullbale' => false],
                            'List Items Id'
                        )
                        ->addColumn(
                            'reason',
                            Table::TYPE_TEXT,
                            null,
                            ['nullbale' => false],
                            'The Reason'
                        )
                        ->addColumn(
                            'picture',
                            Table::TYPE_TEXT,
                            null,
                            ['nullbale' => false],
                            'List Image'
                        )
                        ->setComment('Mapping Quote is active');
                    $setup->getConnection()->createTable($table);
                }
            }

            if (version_compare($context->getVersion(), '2.1.0', '<')) {
                $setup->getConnection()->addColumn(
                    $setup->getTable('wiki_request_return_order'),
                    'content_of_seller',
                    [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        'length' => '64k',
                        'nullable' => true,
                        'comment' => 'Content Confirm of Seller'
                    ]
                );

                $setup->getConnection()->addColumn(
                    $setup->getTable('wiki_request_return_order'),
                    'status_of_seller',
                    [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                        'length' => null,
                        'default' => 0,
                        'comment' => '1 - Confirm | 2 - Deny'
                    ]
                );
            }

            if (version_compare($context->getVersion(), '2.1.1', '<')) {
                $setup->getConnection()->addColumn(
                    $setup->getTable('sales_order'),
                    'time_expand',
                    [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                        'length' => null,
                        'default' => false,
                        'after' => 'wk_status',
                        'comment' => 'Time Expand'
                    ]
                );
            }

            if (version_compare($context->getVersion(), '2.1.2', '<')) {
                $setup->getConnection()->addColumn(
                    $setup->getTable('quote_item'),
                    'weight_unit',
                    [
                        'type' => Table::TYPE_TEXT,
                        'length' => 12,
                        'default' => null,
                        'after' => 'weight',
                        'comment' => 'Weight Unit'
                    ]
                );
                $setup->getConnection()->addColumn(
                    $setup->getTable('quote_item'),
                    'size_unit',
                    [
                        'type' => Table::TYPE_TEXT,
                        'length' => 12,
                        'default' => null,
                        'after' => 'weight_unit',
                        'comment' => 'Size Unit'
                    ]
                );
            }

            if (version_compare($context->getVersion(), '2.1.3', '<')) {
                $setup->getConnection()->addColumn(
                    $setup->getTable('ves_vendor_sales_order'),
                    'discount_seller',
                    [
                        'type' => Table::TYPE_DECIMAL,
                        'length' => '12,2',
                        'default' => null,
                        'after' => 'shipping_description',
                        'comment' => 'Discount of Seller Coupon'
                    ]
                );
                $setup->getConnection()->addColumn(
                    $setup->getTable('ves_vendor_sales_order'),
                    'discount_mkp',
                    [
                        'type' => Table::TYPE_DECIMAL,
                        'length' => '12,2',
                        'default' => null,
                        'after' => 'discount_seller',
                        'comment' => 'Discount of MKP Coupon'
                    ]
                );
            }
        $setup->endSetup();
    }
}
