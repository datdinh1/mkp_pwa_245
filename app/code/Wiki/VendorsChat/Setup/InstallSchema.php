<?php
/**
* Copyright © 2016 Magento. All rights reserved.
* See COPYING.txt for license details.
*/

namespace Wiki\VendorsChat\Setup;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

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

         /**-------------------------------------------------------- */
          // Get wk_chat_room table
        $tableName = $setup->getTable('wk_chat_room');

        // Check if the table already exists
        if ($installer->getConnection()->isTableExists($tableName) != true) {
            $table = $installer->getConnection()
                ->newTable($tableName)
                ->addColumn(
                    'chat_id',
                    Table::TYPE_INTEGER,
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
                    'visitor_id',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => false,
                        'unsigned' => true,
                        'nullable' => false
                    ],
                    'Customer ID'
                )
                ->addColumn(
                    'vendor_id',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => false,
                        'unsigned' => true,
                        'nullable' => false
                        
                    ],
                    'Vendor ID'
                )
                ->addColumn(
                    'created_at',
                    Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false , 'default' => Table::TIMESTAMP_INIT],
                    'Created At'
                )
                ->addColumn(
                    'updated_at',
                    Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false , 'default' => Table::TIMESTAMP_INIT],
                    'Updated At'
                )     
                ->setComment('Chat Chat room')
                ->setOption('type', 'InnoDB')
                ->setOption('charset', 'utf8');
            $installer->getConnection()->createTable($table);
        }

       
         /**-------------------------------------------------------- */

          // Get wk_chat_room_action table
          $tableName = $setup->getTable('wk_chat_room_action');

          // Check if the table already exists
          if ($installer->getConnection()->isTableExists($tableName) != true) {
              $table = $installer->getConnection()
                  ->newTable($tableName)
                  ->addColumn(
                      'action_id',
                      Table::TYPE_INTEGER,
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
                      'chat_id',
                      Table::TYPE_INTEGER,
                      null,
                      [
                          'identity' => false,
                          'unsigned' => true,
                          'nullable' => false
                         
                      ],
                      'Chat ID'
                  )
                  ->addColumn(
                      'body',
                      Table::TYPE_TEXT,
                      31,
                      [
                          'nullable' => false
                      ],
                      'Body'
                  )
                  ->addColumn(
                    'sender_id',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => false,
                        'unsigned' => true,
                        'nullable' => false
                       
                    ],
                    'Sender ID'
                )
                ->addColumn(
                    'sender_type',
                    Table::TYPE_SMALLINT,
                    null,
                    [
                        'identity' => false,
                        'unsigned' => true,
                        'nullable' => false,
                        'default' => 0
                    ],
                    'Sender Type(0 => vendor, 1 => customer)'
                )
                  ->addColumn(
                    'join_time',
                    Table::TYPE_TIMESTAMP,
                    null,
                    [
                        'nullable' => false, 
                        'default' => Table::TIMESTAMP_INIT
                    ],
                    'Created At'
                )
                  ->setComment('Chat Room Action')
                  ->setOption('type', 'InnoDB')
                  ->setOption('charset', 'utf8');
              $installer->getConnection()->createTable($table);
          }

		$installer->endSetup();


    }
}