<?php

namespace Wiki\VendorsFollow\Model\Api;

use Magento\Customer\Model\Customer;
use Wiki\Vendors\Model\VendorFactory;
use Wiki\VendorsProduct\Model\Api\Data\SellerDataFactory;
use Wiki\VendorsFollow\Api\FollowRepositoryInterface;
use Wiki\VendorsFollow\Model\FollowFactory;
use Wiki\VendorsFollow\Model\Api\Data\CustomerDataFactory;

use Wiki\VendorsFollow\Helper\Data;

/**
 * class FollowRepository
 */
class FollowRepository implements FollowRepositoryInterface
{

    /**
     * @var VendorFactory
     */
    protected $vendorFactory;

    /**
     * @var FollowFactory
     */
    protected $followFactory;

    /**
     * @var CustomerDataFactory
     */
    protected $customerDataFactory;

    /**
     * @var SellerDataFactory
     */
    protected $sellerDataFactory;

    /**
     * @var Data
     */
    protected $helperData;

    public function __construct(
        VendorFactory               $vendorFactory,
        FollowFactory               $followFactory,
        CustomerDataFactory         $customerDataFactory,
        SellerDataFactory           $sellerDataFactory,
        Data                        $helperData
    ) {
        $this->vendorFactory        = $vendorFactory;
        $this->followFactory        = $followFactory;
        $this->customerDataFactory  = $customerDataFactory;
        $this->sellerDataFactory    = $sellerDataFactory;
        $this->helperData           = $helperData;
    }

    /**
     * @inheritdoc
     */
    public function getFollowVendorByCustomerId($customerId, $pageSize = null, $currentPage = null)
    {
        $pageSize = $pageSize ? $pageSize : 10;
        $collection = $this->followFactory->create()->getCollection();
        $collection->addFieldToFilter('customer_id', $customerId);
        $collection->setPageSize($pageSize)->setCurPage($currentPage);
        $collection->setOrder('id', 'DESC');
        $collection->getSelect()->join(
            array('vendor' => 'ves_vendor_entity'),
            'main_table.vendor_id = vendor.entity_id'
        );

        $dataResult = [];
        if (count($collection) > 0) {
            foreach ($collection as $vendor) {
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

    public function getFollowByVendorId($vendorId, $pageSize = null, $currentPage = null)
    {
        $pageSize = $pageSize ? $pageSize : 10;
        $attribute = $this->helperData->getAttributeCode(Customer::ENTITY, 'profile_picture');
        $collection = $this->followFactory->create()->getCollection();
        $collection->addFieldToFilter('vendor_id', $vendorId);
        $collection->setPageSize($pageSize)->setCurPage($currentPage);
        $collection->setOrder('customer_id', 'DESC');
        $collection->getSelect()
            ->join(
                array('customer' => 'customer_entity'),
                'main_table.customer_id = customer.entity_id'
            )
            ->joinLeft(
                array('customer_varchar' => 'customer_entity_varchar'),
                "main_table.customer_id = customer_varchar.entity_id AND customer_varchar.attribute_id = {$attribute}",
                ['avatar' => 'customer_varchar.value']
            );

        $dataResult = [];
        if (count($collection) > 0) {
            foreach ($collection as $customer) {
                $info = $this->customerDataFactory->create();
                $info->setData($customer->getData());
                $dataResult[] = $info;
            }
        }
        $this->helperData->updateFollowers($vendorId);

        return $dataResult;
    }

    public function follow($vendorId, $customerId)
    {
        $vendor =  $this->vendorFactory->create()->load($vendorId);
        if ($vendor && $vendor->getCustomer()->getId() == $customerId) {
            return false;
        }

        $model = $this->getFollow($vendorId, $customerId);
        if ($model->getData()) {
            $this->helperData->updateFollowers($vendorId);
            return true;
        }

        try {
            $data = $this->followFactory->create();
            $data->setVendorId($vendorId)->setCustomerId($customerId)->save();
            $this->helperData->updateFollowers($vendorId);
            return true;
        } catch (\Exception $e) {
            return false;
        }

        return false;
    }

    public function unFollow($vendorId, $customerId)
    {
        try {
            $model = $this->getFollow($vendorId, $customerId);
            if ($model->getData()) {
                foreach ($model as $item) {
                    $item->delete();
                }
                $this->helperData->updateFollowers($vendorId);
                return true;
            }
        } catch (\Exception $e) {
            return false;
        }

        return false;
    }

    public function getFollow($vendorId, $customerId)
    {
        $model = $this->followFactory->create()->getCollection();
        $model->addFieldToFilter('customer_id', $customerId);
        $model->addFieldToFilter('vendor_id', $vendorId);
        return $model;
    }
}
