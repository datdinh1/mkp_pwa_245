<?php

namespace Wiki\VendorsNotification\Setup;

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
        // if (version_compare($context->getVersion(), '2.0.1') < 0) {
        //     $installer = $setup;
        //     $installer->getConnection()->addColumn(
        //     $installer->getTable('ves_vendor_notification'),
        //         'customer_id',
        //             [
        //             'type' => Table::TYPE_TEXT,
        //             'length' => null,
        //             'unsigned' => true,
        //             'nullable' => false,
        //             'default' => '',
        //             'comment' => 'ID Customer',
        //             ]
        //     );

        // }

        $setup->startSetup();
        if (version_compare($context->getVersion(), '2.0.1') < 0) {

            // Get module table
            $tableName = $setup->getTable('ves_vendor_notification');

            // Check if the table already exists
            if ($setup->getConnection()->isTableExists($tableName) == true) {
                // Declare data
                $columns = [
                    'customer_id' => [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                        'nullable' => false,
                        'comment' => 'id customer',
                    ],
                ];

                $connection = $setup->getConnection();
                foreach ($columns as $name => $definition) {
                    $connection->addColumn($tableName, $name, $definition);
                }
            }
        }
        if (version_compare($context->getVersion(), '2.0.1') < 0) {

            // Get module table
            $tableName = $setup->getTable('ves_vendor_notification');

            // Check if the table already exists
            if ($setup->getConnection()->isTableExists($tableName) == true) {
                // Declare data
                $columns = [
                    'customer_id' => [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                        'nullable' => false,
                        'comment' => 'id customer',
                    ],
                ];

                $connection = $setup->getConnection();
                foreach ($columns as $name => $definition) {
                    $connection->addColumn($tableName, $name, $definition);
                }
            }
        }
        if (version_compare($context->getVersion(), '2.0.2') < 0) {
            $installer = $setup;
            $installer->getConnection()->addColumn(
            $installer->getTable('ves_vendor_notification'),
                'noti_admin_id',
                    [
                    'type' => Table::TYPE_INTEGER,
                    'length' => null,
                    'unsigned' => true,
                    'nullable' => false,
                    'default' => 0,
                    'comment' => 'Admin Notification ID',
                    ]
            );
           
        }
        
        if (version_compare($context->getVersion(), '2.0.3') < 0) {
            $installer = $setup;
            $installer->getConnection()->addColumn(
            $installer->getTable('ves_vendor_notification'),
                'content',
                    [
                    'type' => Table::TYPE_TEXT,
                    'length' => null,
                    'unsigned' => true,
                    'nullable' => false,
                    'comment' => 'Content cancel Order',
                    ]
            );
           
        }

        if (version_compare($context->getVersion(), '2.0.4') < 0) {
            $installer = $setup;
            $installer->getConnection()->addColumn(
            $installer->getTable('ves_vendor_notification'),
                'notification_of',
                    [
                    'type' => Table::TYPE_SMALLINT,
                    'length' => null,
                    'unsigned' => true,
                    'nullable' => false,
                    'default' => 0,
                    'comment' => '0 - All, 1 - Customers, 2 - Vendors',
                    ]
            );
           
        }

        if (version_compare($context->getVersion(), '2.0.5') < 0) {
            $setup->getConnection()->addColumn(
                $setup->getTable('ves_vendor_notification'),
                'image',
                [
                    'type' => Table::TYPE_TEXT,
                    'length' => 255,
                    'default' => null,
                    'comment' => 'Image'
                ]
            );

            $setup->getConnection()->changeColumn(
                $setup->getTable('ves_vendor_notification'),
                'customer_id',
                'customer_id',
                [
                    'type' => Table::TYPE_INTEGER,
                    'size' => 10,
                    'default' => null,
                ]
            );

            $setup->getConnection()->changeColumn(
                $setup->getTable('ves_vendor_notification'),
                'vendor_id',
                'vendor_id',
                [
                    'type' => Table::TYPE_INTEGER,
                    'size' => 10,
                    'unsigned' => true,
                    'nullable' => true,
                    'default' => null,
                    'comment' => 'Vendor Id'
                ]
            );
        }
        $setup->endSetup();
    }
}
