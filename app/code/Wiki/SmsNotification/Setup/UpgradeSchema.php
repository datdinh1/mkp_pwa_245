<?php

namespace Wiki\SmsNotification\Setup;

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
        

        if (version_compare($context->getVersion(), '1.0.2') < 0) {
            $installer = $setup;
            $installer->getConnection()->addColumn(
            $installer->getTable('wiki_smsnotification'),
                'image',
                    [
                    'type' => Table::TYPE_TEXT,
                    'length' => null,
                    'unsigned' => true,
                    'nullable' => false,
                    'default' => '',
                    'comment' => 'Image Notification',
                    ]
            );
            $installer->getConnection()->addColumn(
                $installer->getTable('wiki_smsnotification'),
                    'obj_user',
                        [
                        'type' => Table::TYPE_INTEGER,
                        'length' => null,
                        'unsigned' => true,
                        'nullable' => false,
                        'default' => 0,
                        'comment' => 'object user',
                        ]
                );
           
        }
        
    }
}
