<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\StoreApi\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class Upgrade_1_0_4
{
    /**
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public static function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        // CREATE TABLE "wiki_user_setting"
        if (!$setup->tableExists('wiki_user_setting')) {
            $table = $setup->getConnection()
                ->newTable($setup->getTable('wiki_user_setting'))
                ->addColumn(
                    'setting_id', 
                    Table::TYPE_INTEGER, 
                    null, 
                    ['identity' => true, 'nullable' => false, 'primary' => true, 'unsigned' => true],
                    'Setting Id'
                )
                ->addColumn(
                    'customer_id', 
                    Table::TYPE_INTEGER, 
                    null, 
                    ['nullable' => false, 'unsigned' => true], 
                    'Customer Id'
                )
                ->addColumn(
                    'setting_data', 
                    Table::TYPE_TEXT, 
                    null, 
                    ['nullable' => true, 'default' => null], 
                    'Setting Data'
                )
                ->addForeignKey(
                    $setup->getFkName(
                        'wiki_user_setting',
                        'customer_id',
                        'customer_entity',
                        'entity_id'
                    ),
                    'customer_id',
                    $setup->getTable('customer_entity'),
                    'entity_id',
                    Table::ACTION_CASCADE
                )
                ->setComment('Wiki User Setting');

            $setup->getConnection()->createTable($table);
        }
    }
}
