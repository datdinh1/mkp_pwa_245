<?php
/**
 * Copyright © Wiki. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\Vendors\Setup;

use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Setup\EavSetupFactory;
use Wiki\Vendors\Model\Vendor;
use Wiki\Vendors\Setup\VendorSetupFactory;
use Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;

/**
 * Upgrade Data script
 * @codeCoverageIgnore
 */
class UpgradeData implements UpgradeDataInterface
{
    /**
     * Vendor setup factory
     *
     * @var VendorSetupFactory
     */
    private $vendorSetupFactory;

    /**
     * EAV setup factory
     *
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    private $attributeSetFactory;

    /**
     * UpgradeData constructor.
     * @param \Wiki\Vendors\Setup\VendorSetupFactory $vendorSetupFactory
     * @param EavSetupFactory $eavSetupFactory
     * @param AttributeSetFactory $attributeSetFactory
     */
    public function __construct(
        VendorSetupFactory $vendorSetupFactory,
        EavSetupFactory $eavSetupFactory,
        AttributeSetFactory $attributeSetFactory
    ) {
        $this->vendorSetupFactory = $vendorSetupFactory;
        $this->eavSetupFactory = $eavSetupFactory;
        $this->attributeSetFactory = $attributeSetFactory;
    }

    /**
     * @inheritdoc
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        $vendorSetup = $this->vendorSetupFactory->create(['setup' => $setup]);

        if (version_compare($context->getVersion(), '2.1.2') < 0) {
            $vendorSetup->addAttribute(
                Vendor::ENTITY,
                'flag_notify_email',
                [
                    'label' => 'Flag Notify Email',
                    'type' => 'int',
                    'input' => 'text',
                    'required' => false,
                    'sort_order' => 70,
                    'position' => 40,
                    'default' => 0
                ]
            );
        }
        $setup->endSetup();
    }
}
