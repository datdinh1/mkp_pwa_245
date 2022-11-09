<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace MGS\Brand\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class Upgrade_2_0_1
{
    const BRAND_TABLE = 'mgs_brand';
    const BRAND_CATEGORY_TABLE = 'mgs_brand_category';
    const CATALOG_CATEGORY_ENTITY_TABLE = 'catalog_category_entity';

    /**
     * {@inheritdoc}
     */
    public static function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        if (!$setup->tableExists(self::BRAND_CATEGORY_TABLE)) {
            $table = $setup->getConnection()
                ->newTable($setup->getTable(self::BRAND_CATEGORY_TABLE))
                ->addColumn(
                    'brand_id',
                    Table::TYPE_INTEGER,
                    null,
                    ['nullable' => false, 'unsigned' => true],
                    'Brand Id'
                )
                ->addColumn(
                    'category_id',
                    Table::TYPE_INTEGER,
                    null,
                    ['nullable' => false, 'unsigned' => true],
                    'Category Id'
                )
                ->addIndex(
                    $setup->getIdxName(
                        $setup->getTable(self::BRAND_CATEGORY_TABLE), 
                        ['category_id']
                    ),
                    ['category_id']
                )
                ->addForeignKey(
                    $setup->getFkName(self::BRAND_CATEGORY_TABLE, 'brand_id', self::BRAND_TABLE, 'brand_id'),
                    'brand_id',
                    $setup->getTable(self::BRAND_TABLE),
                    'brand_id',
                    Table::ACTION_CASCADE
                )
                ->addForeignKey(
                    $setup->getFkName(self::BRAND_CATEGORY_TABLE, 'category_id', self::CATALOG_CATEGORY_ENTITY_TABLE, 'entity_id'),
                    'category_id',
                    $setup->getTable(self::CATALOG_CATEGORY_ENTITY_TABLE),
                    'entity_id',
                    Table::ACTION_CASCADE
                )
                ->setComment('MGS Brand Category Match');
            
            $setup->getConnection()->createTable($table);
        }
    }
}
