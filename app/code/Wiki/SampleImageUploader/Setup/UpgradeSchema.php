<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Wiki\SampleImageUploader\Setup;

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

        if (version_compare($context->getVersion(), '1.0.5', '<')) {
            $table = $setup->getConnection()->addColumn(
				$setup->getTable('Wiki_sampleimageuploader_image'),
				'cate_id',
				[
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
					'size' => 10,
                    'nullable' => false,
					'unsigned' => true,
					//'default' => null,
					
                    'comment' => 'Category Id'
                ]
			);
            $table = $setup->getConnection()->newTable(
                $setup->getTable('wiki_interest_entity')
            )->addColumn(
                'entity_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'Id'
            )->addColumn(
                'customer_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                [ 'unsigned' => true, 'nullable' => false,],
                'Customer Id'
            )->addColumn(
                'image_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                null,
                [ 'unsigned' => true, 'nullable' => false,],
                'Image Id'
            )->addColumn(
                'created_at',
                \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
                'Created At'
            )->addColumn(
                'update_at',
                \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
                'Update At'
            )->setComment(
                'Save id image cate of user'
            );
            $setup->getConnection()->createTable($table);
        }
       
        if (version_compare($context->getVersion(), '1.0.6', '<')) {
            $setup->getConnection()->changeColumn(
                $setup->getTable('Wiki_sampleimageuploader_image'),
                'cate_id',
                'category_id',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
					'size' => 10
                ]
            );
        }

        if (version_compare($context->getVersion(), '1.0.7', '<')) {
            $setup->getConnection()->dropColumn($setup
            ->getTable('Wiki_sampleimageuploader_image'), 'cate_id');
        }
        $setup->endSetup();
    }
}