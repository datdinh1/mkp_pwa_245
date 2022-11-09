<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Wiki\VendorsCustomerAccount\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;
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

        if ( version_compare($context->getVersion(), '1.0.1') < 0 ){
            $setup->getConnection()->changeColumn(
                $setup->getTable('wiki_block_customer_account'),
                'blocked_by',
                'blocked_by',
                [
                    'type' => Table::TYPE_SMALLINT,
                    'size' => 4,
                    'default' => null,
                    'comment' => '1 - Customers | 2 - Vendors'
                ]
            );
        }
       
        $setup->endSetup();
    }
}