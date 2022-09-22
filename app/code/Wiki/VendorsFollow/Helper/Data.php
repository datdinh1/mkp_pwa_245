<?php
namespace Wiki\VendorsFollow\Helper;

use Magento\Eav\Model\ResourceModel\Entity\Attribute;
use Magento\Framework\App\Helper\AbstractHelper;
use Wiki\VendorsConfig\Helper\Data as WikiVendorsConfigData;
use Wiki\Vendors\Model\GroupFactory;
use Wiki\Vendors\Model\Vendor;
use Wiki\VendorsFollow\Model\UpdateFollowersFactory;
use Wiki\VendorsFollow\Model\FollowFactory;

class Data extends AbstractHelper
{
    /**
     * @var Attribute
     */
    protected $attribute;

    /**
     * @var GroupFactory
     */
    protected $groupVendor;

    /**
     * @var WikiVendorsConfigData
     */
    protected $configHelper;

    /**
     * @var UpdateFollowersFactory
     */
    protected $updateFollowersFactory;

    /**
     * @var FollowFactory
     */
    protected $followFactory;

    public function __construct(
        Attribute                   $attribute,
        GroupFactory                $groupVendor,
        WikiVendorsConfigData       $configHelper,
        UpdateFollowersFactory      $updateFollowers,
        FollowFactory               $followFactory
    ){
        $this->attribute            = $attribute;
        $this->groupVendor          = $groupVendor;
        $this->configHelper         = $configHelper;
        $this->updateFollowers      = $updateFollowers;
        $this->followFactory        = $followFactory;
    }

    public function getLogo($vendorId)
    {   $basePath = 'ves_vendors/logo/';
        $img = $this->configHelper->getVendorConfig('general/store_information/logo_image_seller', $vendorId);
        return empty($img) ? '' : $basePath . $img;
    }

    public function getStoreName($vendorId){
        $storeName = $this->configHelper->getVendorConfig('general/store_information/name', $vendorId);
        return empty($storeName) ? '' : $storeName;
    }

    public function getAttributeCode($model, $code)
    {
        return $this->attribute->getIdByCode($model, $code);
    }

    public function getGroupName($vendorGroup)
    {
        $groupName = $this->groupVendor->create()->load($vendorGroup)->getVendorGroupCode();
        return empty($groupName) ? '' : $groupName;
    }

    public function updateFollowers($vendorId)
    {
        $attribute = $this->getAttributeCode(Vendor::ENTITY, 'followers');
        if ( !$attribute )
            return;

        $countFollowers = $this->followFactory->create()->getCollection();
        $countFollowers->addFieldToFilter('vendor_id', $vendorId);
        $count = $countFollowers->count();
        
        $collection = $this->updateFollowers->create()->getCollection();
        $collection->addFieldToFilter('entity_id', $vendorId);
        $collection->addFieldToFilter('attribute_id', $attribute);
        if ( count($collection) > 0 ){
            foreach ( $collection as $customAttribute ){
                $customAttribute->setValue($count)->save();
            }
        }
        else {
            try {
                $data = $this->updateFollowers->create();
                $data->setEntityId($vendorId)->setAttributeId($attribute);
                $data->setValue($count)->save();
            }
            catch ( \Exception $e ){}
        }
    }
}
