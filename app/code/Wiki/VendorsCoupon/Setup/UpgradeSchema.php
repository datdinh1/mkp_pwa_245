<?php

namespace Wiki\VendorsCoupon\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        if (version_compare($context->getVersion(), '1.0.3') < 0) {
            $installer = $setup;
            $setup->getConnection()->addColumn(
                $setup->getTable('ves_vendor_coupon'),
                'image',
                    [
                    'type' => Table::TYPE_TEXT,
                    'length' => null,
                    'unsigned' => true,
                    'nullable' => false,
                    'default' => '',
                    'comment' => 'Image Coupon',
                    ]
            );
            $setup->getConnection()->addColumn(
                $setup->getTable('ves_vendor_sales_order'),
                'coupon_code',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'nullable' => true,
                    'comment' => 'Coupon Code'
                ]
            );
            $setup->getConnection()->addColumn(
                $setup->getTable('ves_vendor_sales_order'),
                'discount_description',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'nullable' => true,
                    'comment' => 'Discount Description'
                ]
            );
            $setup->getConnection()->addColumn(
                $setup->getTable('quote'),
                'applied_vendor_coupon_ids',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'nullable' => true,
                    'comment' => 'Applied Vendor Coupon Ids'
                ]
            );
            $setup->getConnection()->addColumn(
                $setup->getTable('quote'),
                'vendor_discount_detail',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'nullable' => true,
                    'comment' => 'Vendor Discount Detail'
                ]
            );
        }
    }
}
