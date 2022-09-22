<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\StoreApi\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        if (version_compare($context->getVersion(), '1.0.3', '<')) {
            include_once 'Upgrade_1_0_3.php';
            Upgrade_1_0_3::upgrade($setup, $context);
        }

        if (version_compare($context->getVersion(), '1.0.4', '<')) {
            include_once 'Upgrade_1_0_4.php';
            Upgrade_1_0_4::upgrade($setup, $context);
        }

        if (version_compare($context->getVersion(), '1.0.5', '<')) {
            $setup->getConnection()->addColumn(
                $setup->getTable('wiki_card_token'),
                'active',
                [
                    'type'     => Table::TYPE_SMALLINT,
                    'unsigned' => true,
                    'nullable' => false,
                    'default'  => '0',
                    'after'    => 'type',
                    'comment'  => 'Active',
                ]
            );
        }

        $setup->endSetup();
    }
}
