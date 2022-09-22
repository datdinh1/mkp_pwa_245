<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\StoreApi\Setup;

use Magento\Customer\Model\Customer;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;

class UpgradeData implements UpgradeDataInterface
{
    /**
     * @var CustomerSetupFactory
     */
    protected $customerSetupFactory;

    /**
     * @var AttributeSetFactory
     */
    protected $attributeSetFactory;

    /**
     * @param CustomerSetupFactory $customerSetupFactory
     * @param AttributeSetFactory $attributeSetFactory
     */
    public function __construct(
        CustomerSetupFactory $customerSetupFactory,
        AttributeSetFactory $attributeSetFactory
    ) {
        $this->customerSetupFactory = $customerSetupFactory;
        $this->attributeSetFactory = $attributeSetFactory;
    }
    /**
     * {@inheritdoc}
     */
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        if (version_compare($context->getVersion(), '1.0.1', '<')) {
            
            $customerSetup = $this->customerSetupFactory->create(['setup' => $setup]);

            // Add district to customer address
            $customerSetup->addAttribute('customer_address', 'district', [
                'label' => 'District',
                'input' => 'text',
                'type' => 'varchar',
                'source' => '',
                'required' => false,
                'position' => 330,
                'visible' => true,
                'system' => false,
                'is_used_in_grid' => false,
                'is_visible_in_grid' => false,
                'is_filterable_in_grid' => false,
                'is_searchable_in_grid' => false,
                'backend' => ''
            ]);

            $attribute = $customerSetup->getEavConfig()->getAttribute('customer_address', 'district')
                ->addData(['used_in_forms' => [
                    'customer_address_edit',
                    'customer_register_address',
                    'adminhtml_customer_address'
                ]]);
            $attribute->save();

            // Add subdistrict to customer address
            $customerSetup->addAttribute('customer_address', 'sub_district', [
                'label' => 'Sub District',
                'input' => 'text',
                'type' => 'varchar',
                'source' => '',
                'required' => false,
                'position' => 350,
                'visible' => true,
                'system' => false,
                'is_used_in_grid' => false,
                'is_visible_in_grid' => false,
                'is_filterable_in_grid' => false,
                'is_searchable_in_grid' => false,
                'backend' => ''
            ]);

            $attribute = $customerSetup->getEavConfig()->getAttribute('customer_address', 'sub_district')
                ->addData(['used_in_forms' => [
                    'customer_address_edit',
                    'customer_register_address',
                    'adminhtml_customer_address'
                ]]);
            $attribute->save();

            // Add district and subdistrict to quote address
            $setup->getConnection()->addColumn(
                $setup->getTable('quote_address'),
                'district',
                [
                    'type' => 'text',
                    'length' => 255,
                    'comment' => 'District',
                ]
            );

            $setup->getConnection()->addColumn(
                $setup->getTable('quote_address'),
                'sub_district',
                [
                    'type' => 'text',
                    'length' => 255,
                    'comment' => 'Sub District',
                ]
            );

            // Add district and subdistrict to order address
            $setup->getConnection()->addColumn(
                $setup->getTable('sales_order_address'),
                'district',
                [
                    'type' => 'text',
                    'length' => 255,
                    'comment' => 'District',
                ]
            );

            $setup->getConnection()->addColumn(
                $setup->getTable('sales_order_address'),
                'sub_district',
                [
                    'type' => 'text',
                    'length' => 255,
                    'comment' => 'Sub District',
                ]
            );

        }

        if (version_compare($context->getVersion(), '1.0.2', '<')) {

            $customerSetup = $this->customerSetupFactory->create(['setup' => $setup]);

            $customerEntity = $customerSetup->getEavConfig()->getEntityType('customer');
            $attributeSetId = $customerEntity->getDefaultAttributeSetId();

            $attributeSet = $this->attributeSetFactory->create();
            $attributeGroupId = $attributeSet->getDefaultGroupId($attributeSetId);

            $customerSetup->addAttribute(Customer::ENTITY, 'profile_picture', [
                'type' => 'varchar',
                'label' => 'Profile Picture',
                'input' => 'text',
                'backend' => \Wiki\StoreApi\Model\Attribute\Backend\Avatar::class,
                'required' => false,
                'default' => '',
                'user_defined' => true,
                'sort_order' => 10,
                'position' => 10,
                'system' => 0,
                'is_used_in_grid' => false,
                'is_visible_in_grid' => false,
                'is_filterable_in_grid' => false,
                'is_searchable_in_grid' => false,
                'is_html_allowed_on_front' => false,
            ]);

            $attribute = $customerSetup->getEavConfig()->getAttribute(Customer::ENTITY, 'profile_picture')
            ->addData([
                'attribute_set_id' => $attributeSetId,
                'attribute_group_id' => $attributeGroupId,
                'used_in_forms' => [],
            ]);

            $attribute->save();
        }
        $setup->endSetup();
    }
}
