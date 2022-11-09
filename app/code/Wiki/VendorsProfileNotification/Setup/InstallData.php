<?php

namespace Wiki\VendorsProfileNotification\Setup;

use Wiki\Vendors\Model\Vendor;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

/**
 * @codeCoverageIgnore
 */
class InstallData implements InstallDataInterface
{
    /**
     * EAV setup factory
     *
     * @var \Wiki\Vendors\Setup\VendorSetupFactory
     */
    private $vendorSetupFactory;
 
    

    /**
     * Init
     * 
     * @param \Wiki\Vendors\Setup\VendorSetupFactory $vendorSetupFactory
     */
    public function __construct(\Wiki\Vendors\Setup\VendorSetupFactory $vendorSetupFactory)
    {
        $this->vendorSetupFactory = $vendorSetupFactory;
    }
    
    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        /** @var \Wiki\Vendors\Setup\VendorSetup $customerSetup */
        $vendorSetup = $this->vendorSetupFactory->create(['setup' => $setup]);
        $setup->startSetup();
        $attributes = [
            'telephone',
            'country_id',
            'city',
            'street',
        ];
        foreach($attributes as $attribute){
            $vendorSetup->updateAttribute(Vendor::ENTITY, $attribute, 'is_required',0);
        }
        $setup->endSetup();
    }
}
