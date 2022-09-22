<?php
namespace Wiki\VendorsFollow\Setup;

use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

use Wiki\Vendors\Model\Vendor;
use Wiki\Vendors\Setup\VendorSetupFactory;

/**
 * @codeCoverageIgnore
 */
class UpgradeData implements UpgradeDataInterface
{
    /**
     * @var VendorSetupFactory
     */
    private $vendorSetupFactory;
 

    /**
     * @param VendorSetupFactory $vendorSetupFactory
     */
    public function __construct(
        VendorSetupFactory          $vendorSetupFactory
    ){
        $this->vendorSetupFactory   = $vendorSetupFactory;
    }
    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        /** @var CustomerSetup $customerSetup */
        $vendorSetup = $this->vendorSetupFactory->create(['setup' => $setup]);
        $setup->startSetup();
        
        if ( $context->getVersion() && version_compare($context->getVersion(), '1.0.0') < 0 ){
            $eavSetup = $this->vendorSetupFactory->create(['setup' => $setup]);
            $eavSetup->addAttribute(
                Vendor::ENTITY,
                'followers',
                [
                    'type'                      => 'int',
                    'label'                     => 'Followers',
                    'input'                     => 'text',
                    'visible'                   => true,
                    'required'                  => false,
                    'default'                   => 0,
                    'user_defined'              => false,
                    'searchable'                => false,
                    'filterable'                => false,
                    'comparable'                => false,
                    'unique'                    => false,
                    'used_in_profile_form'      => 1,
                    'used_in_registration_form' => 1,
                    'visible_in_customer_form'  => 0,
                ]
            );
        }
        $setup->endSetup();
    }
}