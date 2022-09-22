<?php

namespace Wiki\VendorsFaq\Setup;

use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;

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
        $tableName = $installer->getTable('wiki_faq');


        // $table_wiki_faq = $installer->getConnection()->newTable(
        //     $installer->getTable('wiki_faq')
        // )

        if (!$installer->tableExists('wiki_faq')) {
            $table = $installer->getConnection()
                ->newTable($tableName)->addColumn(
                    'id',
                    Table::TYPE_INTEGER,
                    null,
                    ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true]
                )
                ->addColumn(
                    'title',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => false, 'default' => ''],
                    'Title'
                )
                ->addColumn(
                    'type',
                    Table::TYPE_TEXT,
                    255,
                    ['nullbale' => false, 'default' => ''],
                    'Type  FAQ'
                )
                ->addColumn(
                    'vendor_id',
                    Table::TYPE_TEXT,
                    255,
                    ['nullbale' => false, 'default' => ''],
                    'Name Store'
                )
                ->setOption('charset', 'utf8');
            $installer->getConnection()->createTable($table);
        }
        $installer->endSetup();
        
    }
}
