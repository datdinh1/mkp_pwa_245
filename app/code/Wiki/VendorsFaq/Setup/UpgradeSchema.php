<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Wiki\VendorsFaq\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Catalog\Model\ResourceModel\Product\Attribute\Backend\Media;
use Magento\Catalog\Model\Product\Attribute\Backend\Media\ImageEntryConverter;

/**
 * Upgrade the Catalog module DB scheme
 */
class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * {@inheritdoc}
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        if (version_compare($context->getVersion(), '0.0.2', '<')) {
            
            $table = $setup->getConnection()->newTable(
                $setup->getTable('Wiki_faq_detail')
            )->addColumn(
                'id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'Id'
            )->addColumn(
                'faq_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                [ 'unsigned' => true, 'nullable' => false,],
                'Faq Id'
            )->addColumn(
                'question',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                null,
                [ 'unsigned' => true, 'nullable' => false,],
                'Question'
            )->addColumn(
                'answer',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                null,
                [ 'unsigned' => true, 'nullable' => false,],
                'Question'
            );
            $setup->getConnection()->createTable($table);
        }
       

        $setup->endSetup();
    }
}