<?php
namespace Wiki\OtpSms\Setup;

use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Eav\Model\Config;
use Magento\Customer\Model\Customer;
use Magento\Customer\Model\ResourceModel\Attribute;

class UpgradeData implements UpgradeDataInterface
{
	private $eavSetupFactory;

	public function __construct(
		EavSetupFactory $eavSetupFactory,
		Config $eavConfig,
		Attribute $attributeResource
	)
	{
		$this->eavSetupFactory = $eavSetupFactory;
		$this->eavConfig       = $eavConfig;
		$this->attributeResource = $attributeResource;
	}

	public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
	{
		$setup->startSetup();
		if ( version_compare($context->getVersion(), '1.0.1', '<') ){
			$value = [
				'field' => 'mobile',
				'type' => 'varchar',
				'lable' => 'Mobile'
			];
			$this->attribute($value['field'], $value['type'] , $value['lable'], $setup);
		}
		$setup->endSetup();
	}
	protected function attribute($field, $type , $lable, $setup)
	{
		$eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
		
		$eavSetup->addAttribute(
			Customer::ENTITY,
			$field,
			[
				'type'         => $type,
				'label'        => $lable,
				'input'        => 'text',
				'required'     => false,
				'visible'      => true,
				'user_defined' => true,
				'position'     => 999,
				'system'       => 0,
			]
		);

		$attributeSetId = $eavSetup->getDefaultAttributeSetId(Customer::ENTITY);
		$attributeGroupId = $eavSetup->getDefaultAttributeGroupId(Customer::ENTITY);

		$attribute = $this->eavConfig->getAttribute(Customer::ENTITY, $field);
		$attribute->setData('attribute_set_id', $attributeSetId);
		$attribute->setData('attribute_group_id', $attributeGroupId);

		$attribute->setData('used_in_forms', [
			'adminhtml_customer',
			'customer_account_create',
			'customer_account_edit',
			'customer_address_edit',
			'customer_register_address'
		]);
		$this->attributeResource->save($attribute);
	}
}