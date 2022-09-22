<?php

namespace Wiki\VendorsCredit\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Wiki\VendorsCredit\Model\ResourceModel\Withdrawal\CollectionFactory as WithdrawalCollectionFactory;
use GuzzleHttp\json_decode;
use GuzzleHttp\json_encode;

/**
 * Upgrade the Catalog module DB scheme
 */
class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * @var WithdrawalCollectionFactory
     */
    protected $withdrawalCollectionFactory;

    /**
     * @param WithdrawalCollectionFactory $withdrawalCollectionFactory
     */
    public function __construct(
        WithdrawalCollectionFactory $withdrawalCollectionFactory
    ) {
        $this->withdrawalCollectionFactory = $withdrawalCollectionFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function upgrade(
        SchemaSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $setup->startSetup();

        if (version_compare($context->getVersion(), '2.0.1', '<')) {
            $setup->getConnection()->addColumn(
                $setup->getTable('ves_vendor_withdrawal'),
                'reason_cancel',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => \Magento\Framework\DB\Ddl\Table::MAX_TEXT_SIZE,
                    'nullable' => false,
                    'after' => 'status',
                    'comment' => 'Reason'
                ]
            );

            $setup->getConnection()->addColumn(
                $setup->getTable('ves_vendor_withdrawal'),
                'code_of_transfer',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' =>  \Magento\Framework\DB\Ddl\Table::MAX_TEXT_SIZE,
                    'nullable' => false,
                    'after' => 'status',
                    'comment' => 'Code of Transfer'
                ]
            );
        }

        if (version_compare($context->getVersion(), '2.0.2', '<')) {
            $setup->getConnection()->addColumn(
                $setup->getTable('sales_invoice_item'),
                'commission',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                    'length' => '12,4',
                    'nullable' => true,
                    'comment' => 'Commission'
                ]
            );
            $setup->getConnection()->addColumn(
                $setup->getTable('sales_invoice_item'),
                'commission_description',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => null,
                    'nullable' => true,
                    'comment' => 'Commission description'
                ]
            );
        }

        if (version_compare($context->getVersion(), '2.0.3', '<')) {
            $withdrawalCollection = $this->withdrawalCollectionFactory->create();
            foreach ($withdrawalCollection as $withdrawal) {
                $additionalData = json_decode($withdrawal->getAdditionalInfo(), true);
                if (!is_array($additionalData)) {
                    $additionalData = unserialize($withdrawal->getAdditionalInfo());
                    $additionalData = json_encode($additionalData);
                    $withdrawal->setAdditionalInfo($additionalData)->save();;
                }
            }
        }

        if (version_compare($context->getVersion(), '2.1.0', '<')) {
            $conn = $setup->getConnection();
            $tableCredit = $setup->getTable('wiki_credit_card');
            $tableBank = $setup->getTable('wiki_bank_card');
            if ($conn->isTableExists($tableCredit) != true) {
                $table1 = $conn->newTable($tableCredit)
                    ->addColumn(
                        'id',
                        \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                        null,
                        ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true]
                    )
                    ->addColumn(
                        'card_number',
                        \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        255,
                        ['nullable' => false, 'default' => '']
                    )
                    ->addColumn(
                        'name_on_card',
                        \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        '2M',
                        ['nullbale' => false, 'default' => '']
                    )
                    ->addColumn(
                        'expiration_date',
                        \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        '255',
                        ['nullbale' => false, 'default' => '31/12']
                    )
                    ->addColumn(
                        'cvv',
                        \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                        '3',
                        ['nullbale' => false]
                    )
                    ->addColumn(
                        'customer_id',
                        \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                        null,
                        ['nullbale' => false]
                    )
                    ->addColumn(
                        'check_default',
                        \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                        null,
                        ['nullbale' => false]
                    )

                    ->setOption('charset', 'utf8');
                $conn->createTable($table1);
            }
            if ($conn->isTableExists($tableBank) != true) {
                $table2 = $conn->newTable($tableBank)
                    ->addColumn(
                        'id',
                        \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                        null,
                        ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true]
                    )
                    ->addColumn(
                        'full_name',
                        \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        255,
                        ['nullable' => false, 'default' => '']
                    )
                    ->addColumn(
                        'account_number',
                        \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        '2M',
                        ['nullbale' => false, 'default' => '']
                    )
                    ->addColumn(
                        'bank_name',
                        \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        '255',
                        ['nullbale' => false, 'default' => '']
                    )
                    ->addColumn(
                        'customer_id',
                        \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                        null,
                        ['nullbale' => false]
                    )
                    ->addColumn(
                        'check_default',
                        \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                        null,
                        ['nullbale' => false]
                    )

                    ->setOption('charset', 'utf8');
                $conn->createTable($table2);
            }
        }


        $setup->endSetup();
    }
}
