<?php

namespace Wiki\VendorsChat\Setup;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\DB\Ddl\Table;

/**
 * Upgrade the Sales_Order Table to remove extra field
 */
class UpgradeSchema implements UpgradeSchemaInterface
{

    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        if (version_compare($context->getVersion(), '0.0.2', '<')) {
            $setup->getConnection()->changeColumn(
                $setup->getTable('wk_chat_room'),
                'visitor_id',
                'customer_id',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER
                ]
            );
            $setup->getConnection()->changeColumn(
                $setup->getTable('wk_chat_room_action'),
                'sender_type',
                'sender_type',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 20,
                ]
            );
        }
        if (version_compare($context->getVersion(), '0.0.3', '<')) {
            $setup->getConnection()->changeColumn(
                $setup->getTable('wk_chat_room_action'),
                'join_time',
                'created_at',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                    'length' => null,
                    'nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT,
                    'Created At'
                ]
            );
        }
        if (version_compare($context->getVersion(), '0.0.4', '<')) {
            $setup->getConnection()->changeColumn(
                $setup->getTable('wk_chat_room'),
                'vendor_id',
                'vendor_id',
                [
                    'type'     => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length'   => 50,
                    'nullable' => false
                ]
            );
            $setup->getConnection()->changeColumn(
                $setup->getTable('wk_chat_room_action'),
                'sender_id',
                'sender_id',
                [
                    'type'     => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length'   => 50,
                    'nullable' => false
                ]
            );
        }

        if (version_compare($context->getVersion(), '0.0.5', '<')) {

            // $setup->getConnection()->addColumn(
            //     $setup->getTable('wk_chat_room_action'),
            //     'request_cancel',
            //     [
            //         'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            //         'length' => 50,
            //         'nullable' => false,
            //         'comment' => 'Request Cancel'
            //     ]
            // );
            $setup->getConnection()->changeColumn(
                $setup->getTable('wk_chat_room_action'),
                'body',
                'body',
                [
                    'type'     => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'nullable' => false
                ]
            );
            // Get module table
            $tblImageChat = $setup->getTable('wk_chat_message_image');
            // Check if the table already exists
            if ($setup->getConnection()->isTableExists($tblImageChat) != true) {
                $table = $setup->getConnection()
                    ->newTable($tblImageChat)
                    ->addColumn(
                        'id',
                        \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                        null,
                        [
                            'identity' => true,
                            'unsigned' => true,
                            'nullable' => false,
                            'primary' => true
                        ],
                        'ID'
                    )
                    ->addColumn(
                        'action_id',
                        \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                        null,
                        [
                            'identity' => false,
                            'unsigned' => true,
                            'nullable' => false

                        ],
                        'Chat ID'
                    )
                    ->addColumn(
                        'image',
                        \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        null,
                        [
                            'nullable' => false
                        ],
                        'Image'
                    )
                    ->addColumn(
                        'created_at',
                        \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                        null,
                        [
                            'nullable' => false,
                            'default' =>\Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT
                        ],
                        'Created At'
                    )
                    ->setComment('Chat Message Image')
                    ->setOption('type', 'InnoDB')
                    ->setOption('charset', 'utf8');
                $setup->getConnection()->createTable($table);
            }
        }
        if (version_compare($context->getVersion(), '0.0.6', '<')) {
            $setup->getConnection()->addColumn(
                $setup->getTable('wk_chat_room_action'),
                'from_system',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    'length' => 10,
                    'nullable' => true,
                    'comment' => 'From System'
                ]
            );
        }
        if (version_compare($context->getVersion(), '0.0.7', '<')) {
            $setup->getConnection()->addColumn(
                $setup->getTable('wk_chat_room'),
                'id_ticket',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    'length' => 10,
                    'nullable' => true,
                    'comment' => 'ID Ticket'
                ]
            );
        }

        if (version_compare($context->getVersion(), '0.0.8', '<')) {
            $setup->getConnection()->changeColumn(
                $setup->getTable('wk_chat_room_action'),
                'body',
                'message',
                [
                    'type'     => Table::TYPE_TEXT,
                    'nullable' => true
                ]
            );
            $setup->getConnection()->addColumn(
                $setup->getTable('wk_chat_room'),
                'is_read',
                [
                    'type' => Table::TYPE_SMALLINT,
                    'length' => 4,
                    'nullable' => true,
                    'default' => 0,
                    'after' => 'vendor_id',
                    'comment' => 'Is Read Message'
                ]
            );
            // update ForeignKey 
            $setup->getConnection()->addForeignKey(
                $setup->getFkName(
                    $setup->getTable('wk_chat_room_action'),
                    'chat_id',
                    $setup->getTable('wk_chat_room'),
                    'chat_id'
                ),
                $setup->getTable('wk_chat_room_action'),
                'chat_id',
                $setup->getTable('wk_chat_room'),
                'chat_id',
                Table::ACTION_CASCADE
            );
            $setup->getConnection()->addForeignKey(
                $setup->getFkName(
                    $setup->getTable('wk_chat_message_image'),
                    'action_id',
                    $setup->getTable('wk_chat_room_action'),
                    'action_id'
                ),
                $setup->getTable('wk_chat_message_image'),
                'action_id',
                $setup->getTable('wk_chat_room_action'),
                'action_id',
                Table::ACTION_CASCADE
            );
        }
        if (version_compare($context->getVersion(), '0.0.9', '<')) {
            $setup->getConnection()->changeColumn(
                $setup->getTable('wk_chat_room_action'),
                'from_system',
                'from_system',
                [
                    'type' => Table::TYPE_SMALLINT,
                    'length' => 4,
                    'nullable' => true,
                    'default' => 0,
                    'comment' => 'From System'
                ]
            );
        }
        $setup->endSetup();
    }
}
