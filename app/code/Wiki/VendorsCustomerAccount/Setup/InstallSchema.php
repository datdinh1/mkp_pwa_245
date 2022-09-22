<?php
namespace Wiki\VendorsCustomerAccount\Setup;

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

        if (!$installer->tableExists('wiki_block_customer_account')) {
            $table = $installer->getConnection()->newTable(
                $installer->getTable('wiki_block_customer_account')
            )
            ->addColumn(
                'id',
                Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true]
            )
            ->addColumn(
                'customer_id',
                Table::TYPE_INTEGER,
                10,
                ['nullbale' => false, 'unsigned' => true],
                'Customers Id'
            )
            ->addColumn(
                'vendor_id',
                Table::TYPE_INTEGER,
                10,
                ['nullbale' => false, 'unsigned' => true],
                'Vendors Id'
            )
            ->addColumn(
                'blocked_by',
                Table::TYPE_INTEGER,
                10,
                ['nullbale' => false, 'unsigned' => false],
                'Blocked By'
            )
            ->addForeignKey(
                $installer->getFkName(
                    'customer_entity',
                    'entity_id',
                    'wiki_block_customer_account',
                    'customer_id'
                ),
                'customer_id',
                $installer->getTable('customer_entity'),
                'entity_id',
                Table::ACTION_CASCADE
            )
            ->addForeignKey(
                $installer->getFkName(
                    'ves_vendor_entity',
                    'entity_id',
                    'wiki_block_customer_account',
                    'vendor_id'
                ),
                'vendor_id',
                $installer->getTable('ves_vendor_entity'),
                'entity_id',
                Table::ACTION_CASCADE
            )
            ->setComment('Wiki Block')
            ->setOption('charset', 'utf8');
            $installer->getConnection()->createTable($table);
        }
        $installer->endSetup();
    }
}
