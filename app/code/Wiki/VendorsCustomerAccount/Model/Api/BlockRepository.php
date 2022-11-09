<?php
namespace Wiki\VendorsCustomerAccount\Model\Api;

use Magento\Customer\Model\Customer;
use Wiki\Vendors\Model\VendorFactory;
use Wiki\VendorsProduct\Model\Api\Data\SellerDataFactory;
use Wiki\VendorsFollow\Model\Api\Data\CustomerDataFactory;
use Wiki\VendorsFollow\Helper\Data;
use Wiki\VendorsCustomerAccount\Api\BlockRepositoryInterface;
use Wiki\VendorsCustomerAccount\Model\Block;
use Wiki\VendorsCustomerAccount\Model\BlockFactory;

/**
 * class FollowRepository
 */
class BlockRepository implements BlockRepositoryInterface
{
    /**
     * @var VendorFactory
     */
    protected $vendorFactory;

    /**
     * @var SellerDataFactory
     */
    protected $sellerDataFactory;

    /**
     * @var CustomerDataFactory
     */
    protected $customerDataFactory;

    /**
     * @var Data
     */
    protected $helperData;

    /**
     * @var BlockFactory
     */
    protected $blockFactory;
    

    public function __construct(
        VendorFactory               $vendorFactory,
        SellerDataFactory           $sellerDataFactory,
        CustomerDataFactory         $customerDataFactory,
        Data                        $helperData,
        BlockFactory                $blockFactory
    ){
        $this->vendorFactory        = $vendorFactory;
        $this->sellerDataFactory    = $sellerDataFactory;
        $this->customerDataFactory  = $customerDataFactory;
        $this->helperData           = $helperData;
        $this->blockFactory         = $blockFactory;
    }

    public function checkStatus($vendorId, $customerId)
    {
        try {
            $model = $this->getBlocked($vendorId, $customerId);
            if ( $model->getData() ){
                return true;
            }
        }
        catch ( \Exception $e ){
            return false;
        }
        return false;
    }

    public function blockCustomers($vendorId, $customerId)
    {
        $model = $this->getBlocked($vendorId, $customerId);
        $model->addFieldToFilter('blocked_by', Block::BLOCKED_BY_VENDORS);
        if ( $model->getData() )
            return true;
        try {
            $model = $this->blockFactory->create();
            $model->setCustomerId($customerId)->setVendorId($vendorId)->setBlockedBy(Block::BLOCKED_BY_VENDORS)->save();
            return true;
        }
        catch ( \Exception $e ){
            return false;
        }
    }

    public function unBlockCustomers($vendorId, $customerId)
    {
        $model = $this->getBlocked($vendorId, $customerId);
        $model->addFieldToFilter('blocked_by', Block::BLOCKED_BY_VENDORS);
        try {
            if ( $model->getData() ){
                foreach ( $model as $item ){
                    $item->delete();
                }
                return true;
            }
        }
        catch ( \Exception $e ){
            return false;
        }

        return false;
    }

    public function blockVendors($vendorId, $customerId)
    {
        $model = $this->getBlocked($vendorId, $customerId);
        $model->addFieldToFilter('blocked_by', Block::BLOCKED_BY_CUSTOMERS);
        if ( $model->getData() )
            return true;
        try {
            $model = $this->blockFactory->create();
            $model->setCustomerId($customerId)->setVendorId($vendorId)->setBlockedBy(Block::BLOCKED_BY_CUSTOMERS)->save();
            return true;
        }
        catch ( \Exception $e ){
            return false;
        }
    }

    public function unBlockVendors($vendorId, $customerId)
    {
        $model = $this->getBlocked($vendorId, $customerId);
        $model->addFieldToFilter('blocked_by', Block::BLOCKED_BY_CUSTOMERS);
        try {
            if ( $model->getData() ){
                foreach ( $model as $item ){
                    $item->delete();
                }
                return true;
            }
        }
        catch ( \Exception $e ){
            return false;
        }
        
        return false;
    }

    public function getBlockedCustomers($vendorId, $pageSize = null, $currentPage = null)
    {
        $attribute = $this->helperData->getAttributeCode(Customer::ENTITY, 'profile_picture');
        $collection = $this->blockFactory->create()->getCollection();
        $collection->addFieldToFilter('vendor_id', $vendorId);
        $collection->addFieldToFilter('blocked_by', Block::BLOCKED_BY_VENDORS);
        $collection->setPageSize($pageSize)->setCurPage($currentPage);
        $collection->setOrder('customer_id', 'DESC');
        $collection->getSelect()
            ->join(
                array('customer' => 'customer_entity'),
                'main_table.customer_id = customer.entity_id')
            ->joinLeft(
                array('customer_varchar' => 'customer_entity_varchar'),
                "main_table.customer_id = customer_varchar.entity_id AND customer_varchar.attribute_id = {$attribute}",
                ['avatar' => 'customer_varchar.value']
            );

        $dataResult = [];
        if ( count($collection) > 0 ){
            foreach ( $collection as $customer ){
                $info = $this->customerDataFactory->create();
                $info->setData($customer->getData());
                $dataResult[] = $info;
            }
        }
    
        return $dataResult;
    }

    public function getBlockedVendors($customerId, $pageSize = null, $currentPage = null)
    {
        $collection = $this->blockFactory->create()->getCollection();
        $collection->addFieldToFilter('customer_id', $customerId);
        $collection->addFieldToFilter('blocked_by', Block::BLOCKED_BY_CUSTOMERS);
        $collection->setPageSize($pageSize)->setCurPage($currentPage);
        $collection->setOrder('id', 'DESC');
        $collection->getSelect()->join(
            array('vendor' => 'ves_vendor_entity'),
            'main_table.vendor_id = vendor.entity_id');

        $dataResult = [];
        if ( count($collection) > 0 ){
            foreach ( $collection as $vendor ){
                $storeName = $this->helperData->getStoreName($vendor->getEntityId());
                $groupName = $this->helperData->getGroupName($vendor->getGroupId());
                $logo = $this->helperData->getLogo($vendor->getEntityId());
                $info = $this->sellerDataFactory->create();
                $info->setData($vendor->getData());
                $info->setLogo($logo);
                $info->setStoreName($storeName);
                $info->setGroupName($groupName);
                $dataResult[] = $info;
            }
        }
    
        return $dataResult;
    }

    public function getBlocked($vendorId, $customerId)
    {
        $model = $this->blockFactory->create()->getCollection();
        $model->addFieldToFilter('customer_id', $customerId);
        $model->addFieldToFilter('vendor_id', $vendorId);
        return $model;
    }
}