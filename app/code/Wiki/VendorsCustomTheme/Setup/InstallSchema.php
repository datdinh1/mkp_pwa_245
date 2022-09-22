<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Wiki\VendorsCustomTheme\Setup;

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
         * Create table 'ves_vendor_theme'
         */
        $table = $installer->getConnection()->newTable(
            $installer->getTable('ves_vendor_theme')
        )->addColumn(
            'theme_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
            'Theme Id'
        )->addColumn(
            'base_theme_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['unsigned' => true, 'nullable' => false],
            'Base Theme Id'
        )->addColumn(
            'title',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable' => false, 'default' => ''],
            'Theme Title'
        )->addColumn(
            'preview_image',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable' => false, 'default' => ''],
            'Preview Image'
        )->addColumn(
            'home_content',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            '2M',
            ['nullable' => false, 'default' => ''],
            'Home Content'
        )->addColumn(
            'home_layout',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable' => false, 'default' => ''],
            'Layout'
        )->addColumn(
            'home_layout_xml',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            '2M',
            ['nullable' => false, 'default' => ''],
            'Layout Update Xml'
        )->addColumn(
            'status',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['unsigned' => true, 'nullable' => false, 'default' => '1'],
            'Status'
        )->addForeignKey(
            $installer->getFkName('ves_vendor_theme', 'base_theme_id', 'theme', 'theme_id'),
            'base_theme_id',
            $installer->getTable('theme'),
            'theme_id',
            \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
        )->setComment(
            'Vendor Theme'
        );
        $installer->getConnection()->createTable($table);
        
        /**
         * Create table 'ves_vendor_theme_config_section'
         */
        $table = $installer->getConnection()->newTable(
            $installer->getTable('ves_vendor_theme_config_section')
        )->addColumn(
            'section_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
            'Section Id'
        )->addColumn(
            'theme_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['unsigned' => true, 'nullable' => false,],
            'Theme Id'
        )->addColumn(
            'section',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable' => false, 'default' => ''],
            'Section name'
        )->addForeignKey(
            $installer->getFkName('ves_vendor_theme_config_section', 'theme_id', 'ves_vendor_theme', 'theme_id'),
            'theme_id',
            $installer->getTable('ves_vendor_theme'),
            'theme_id',
            \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
        )->setComment(
            'Vendor Theme Config Section'
        );
        $installer->getConnection()->createTable($table);
        
        
        /**
         * Create table 'ves_vendor_theme_config'
         */
        $table = $installer->getConnection()->newTable(
            $installer->getTable('ves_vendor_theme_config')
        )->addColumn(
            'config_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
            'Theme Id'
        )->addColumn(
            'vendor_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['unsigned' => true, 'nullable' => false, 'default' => 0],
            'Vendor Id'
        )->addColumn(
            'theme_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['unsigned' => true, 'nullable' => false],
            'Theme Id'
        )->addColumn(
            'path',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable' => false, 'default' => ''],
            'Path'
        )->addColumn(
            'value',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            '2M',
            ['nullable' => true, 'default' => ''],
            'Preview Image'
        )->addForeignKey(
            $installer->getFkName('ves_vendor_theme_config', 'theme_id', 'ves_vendor_theme', 'theme_id'),
            'theme_id',
            $installer->getTable('ves_vendor_theme'),
            'theme_id',
            \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
        )->setComment(
            'Vendor Theme Config'
        );
        $installer->getConnection()->createTable($table);
        
        
        $installer->endSetup();

    }
}
