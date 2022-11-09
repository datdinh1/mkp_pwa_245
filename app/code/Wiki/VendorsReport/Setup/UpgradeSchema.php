<?php
namespace Wiki\VendorsReport\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
	public function upgrade( SchemaSetupInterface $setup, ModuleContextInterface $context ) {
		$installer = $setup;

		$installer->startSetup();

		if(version_compare($context->getVersion(), '2.0.1', '<')) {
			if (!$installer->tableExists('wiki_report_sales_seller')) {
				$table = $installer->getConnection()->newTable(
					$installer->getTable('wiki_report_sales_seller')
				)
					->addColumn(
						'id',
						\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
						null,
						[
							'identity' => true,
							'nullable' => false,
							'primary'  => true,
							'unsigned' => true,
						],
						'Entity ID'
					)
					->addColumn(
						'id_order',
						\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
						null,
						['nullable => false'],
						'Vendor Id'
					)
					->addColumn(
						'vendor_id',
						\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
						255,
						['nullable => false'],
						'Vendor Id'
					)
					->addColumn(
						'order_date',
						\Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
						null,
						[],
						'Order Date'
					)
					->addColumn(
						'date_success_payment',
						\Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
						'null',
						[],
						'Date of successful payment'
					)
					->addColumn(
						'total_price',
						\Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
						'12,2',
						[],
						'Total Price'
					)
					->addColumn(
						'discount_seller',
						\Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
						'12,2',
						[],
						'Discount Price Seller'
					)
					->addColumn(
						'discount_mkp',
						\Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
						'12,2',
						[],
						'Discount Price MKP'
					)
					->addColumn(
						'discount_mkp_seller',
						\Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
						'12,2',
						[],
						'Discount Price MKP'
					)
					->addColumn(
						'delivery_price',
						\Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
						'12,2',
						[],
						'Delivery Price'
					)
					->addColumn(
						'discount_delivery_seller',
						\Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
						'12,2',
						[],
						'Discount Delivery Price Seller'
					)
					->addColumn(
						'discount_delivery_mkp',
						\Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
						'12,2',
						[],
						'Delivery Delivery Price Mkp'
					)
					->addColumn(
						'total_amount',
						\Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
						'12,2',
						[],
						'Total Amount'
					)
					->addColumn(
						'commission_fees',
						\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
						null,
						[],
						'Commission Fees'
					)
					->addColumn(
						'payment_transaction_fee',
						\Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
						'12,2',
						[],
						'Payment Transaction Fee Amount'
					)
					->addColumn(
						'total_transfer_amount',
						\Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
						'12,2',
						[],
						'Total Transfer Amountt'
					)
					->addColumn(
						'created_at',
						\Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
						null,
						['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
						'Created At'
					)->addColumn(
						'updated_at',
						\Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
						null,
						['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE],
						'Updated At')
					->setComment('Report Sales Seller Table');
				$installer->getConnection()->createTable($table);
			}
		}

		$installer->endSetup();
	}
}