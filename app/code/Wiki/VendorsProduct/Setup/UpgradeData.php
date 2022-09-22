<?php

namespace Wiki\VendorsProduct\Setup;

use Magento\Catalog\Model\Product;

use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

/**
 * @codeCoverageIgnore
 */
class UpgradeData implements UpgradeDataInterface
{
    /**
     * EAV setup factory
     *
     * @var EavSetupFactory
     */
    private $categorySetupFactory;
 
    

    /**
     * Init
     *
     * @param CategorySetupFactory $categorySetupFactory
     */
    public function __construct(\Magento\Catalog\Setup\CategorySetupFactory $categorySetupFactory)
    {
        $this->categorySetupFactory = $categorySetupFactory;
    }
    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        /** @var CustomerSetup $customerSetup */
        $categorySetup = $this->categorySetupFactory->create(['setup' => $setup]);
        $setup->startSetup();
        if ($context->getVersion()
            && version_compare($context->getVersion(), '2.0.3') < 0
        ) {
            $categorySetup->updateAttribute(Product::ENTITY, 'approval', 'used_in_product_listing',1);
        }
        
        if ( $context->getVersion() && version_compare($context->getVersion(), '2.0.4') < 0 ){
            $eavSetup = $this->categorySetupFactory->create(['setup' => $setup]);
            $eavSetup->addAttribute(
                Product::ENTITY,
                'sold',
                [
                    'type'      => 'int',
                    'label'     => 'Sold',
                    'input'     => 'text',
                    'class'     => '',
                    'source'    => '',
                    'global'    => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                    'visible'   => true,
                    'required'  => false,
                    'user_defined' => false,
                    'default'    => 0,
                    'searchable' => false,
                    'filterable' => false,
                    'comparable' => false,
                    'visible_on_front' => false,
                    'is_visible_on_front' => 0,
                    'used_in_product_listing' => true,
                    'unique' => false,
                    'apply_to' => ''
                ]
            );
        }
        $setup->endSetup();
    }
}