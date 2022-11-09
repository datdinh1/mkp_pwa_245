<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\StoreApi\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class Upgrade_1_0_3
{
    /**
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public static function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        // CREATE TABLE "wiki_card_token"
        if (!$setup->tableExists('wiki_card_token')) {
            $table = $setup->getConnection()
                ->newTable($setup->getTable('wiki_card_token'))
                ->addColumn(
                    'card_id', 
                    Table::TYPE_INTEGER, 
                    null, 
                    ['identity' => true, 'nullable' => false, 'primary' => true, 'unsigned' => true],
                    'Card Id'
                )
                ->addColumn(
                    'customer_id', 
                    Table::TYPE_INTEGER, 
                    null, 
                    ['nullable' => false, 'unsigned' => true], 
                    'Customer Id'
                )
                ->addColumn(
                    'token', 
                    Table::TYPE_TEXT, 
                    null, 
                    ['nullable' => true, 'default' => null], 
                    'Token'
                )
                ->addColumn(
                    'type', 
                    Table::TYPE_TEXT, 
                    null, 
                    ['nullable' => false], 
                    'Type'
                )
                ->addColumn(
                    'created_at', 
                    Table::TYPE_TIMESTAMP, 
                    null, 
                    ['nullable' => false, 'default' => Table::TIMESTAMP_INIT], 
                    'Created At'
                )
                ->addForeignKey(
                    $setup->getFkName(
                        'wiki_card_token',
                        'customer_id',
                        'customer_entity',
                        'entity_id'
                    ),
                    'customer_id',
                    $setup->getTable('customer_entity'),
                    'entity_id',
                    Table::ACTION_CASCADE
                )
                ->setComment('Wiki Card Token');

            $setup->getConnection()->createTable($table);
        }
    }
}
