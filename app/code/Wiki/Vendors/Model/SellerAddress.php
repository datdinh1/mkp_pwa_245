<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Wiki\Vendors\Model;

use Magento\Framework\App\ResourceConnection;
use Magento\Customer\Model\AddressFactory;
use Magento\Customer\Model\AddressRegistry;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Customer\Model\CustomerFactory;
use Wiki\VendorsApi\Helper\Data as VendorApiHelper;
use Wiki\Vendors\Api\SellerAddressInterface;
use Wiki\Vendors\Model\Vendor;
use Wiki\Vendors\Model\VendorFactory;

/**
 * Handle address Seller
 */
class SellerAddress implements SellerAddressInterface
{
    /**
     * @var VendorFactory
    */
    protected $vendorFactory;

    /**
     * @var CustomerFactory
    */
    protected $customerFactory;

    /**
     * @var AddressFactory
     */
    protected $addressFactory;

    /**
     * @var AddressRegistry
     */
    protected $addressRegistry;
    
    /**
     * @var VendorApiHelper
     */
    protected $dataVendorApiHelper;

    /**
     * @inheritdoc
    */
    public function __construct(
        ResourceConnection                  $resource,
        VendorFactory                       $vendorFactory,
        CustomerFactory                     $customerFactory,
        AddressFactory                      $addressFactory,
        AddressRegistry                     $addressRegistry,
        DataObjectProcessor                 $dataProcessor,
        VendorApiHelper                     $dataVendorApiHelper
    ) {
        $this->resource                     = $resource;
        $this->customerFactory              = $customerFactory;
        $this->vendorFactory                = $vendorFactory;
        $this->addressFactory               = $addressFactory;
        $this->addressRegistry              = $addressRegistry;
        $this->dataProcessor                = $dataProcessor;
        $this->dataVendorApiHelper          = $dataVendorApiHelper;
    }

    public function getDefaultMainAddress($vendorId)
    {
        $vendor = $this->vendorFactory->create()->load($vendorId);
        return empty($vendor->getMainAddress()) ? null : $this->addressRegistry->retrieve($vendor->getMainAddress())->getDataModel();
    }

    public function getDefaultShippingAddress($vendorId)
    {
        $vendor = $this->vendorFactory->create()->load($vendorId);
        return empty($vendor->getShippingAddress()) ? null : $this->addressRegistry->retrieve($vendor->getShippingAddress())->getDataModel();
    }

    public function getDefaultReturnAddress($vendorId)
    {
        $vendor = $this->vendorFactory->create()->load($vendorId);
        return empty($vendor->getReturnAddress()) ? null : $this->addressRegistry->retrieve($vendor->getReturnAddress())->getDataModel();
    }

    public function saveDefaultAddress($vendorId, $mainAddress = null, $shippingAddress = null, $returnAddress = null)
    {
        try {
            if ( !empty($mainAddress) && $this->addressRegistry->retrieve($mainAddress)->getDataModel() ){
                $setValue[] = "main_address = " . $mainAddress;
            }
            if ( !empty($shippingAddress) && $this->addressRegistry->retrieve($shippingAddress)->getDataModel() ){
                $setValue[] = "shipping_address = " . $shippingAddress;
            }
            if ( !empty($returnAddress) && $this->addressRegistry->retrieve($returnAddress)->getDataModel() ){
                $setValue[] = "return_address = " . $returnAddress;
            }
            if ( isset($setValue) ){
                $vendor = $this->vendorFactory->create()->load($vendorId);
                $connection = $this->resource->getConnection();
                $tableName = $this->resource->getTableName('ves_vendor_entity');
                $sql = "UPDATE " . $tableName . " SET " . implode(", ", $setValue) . " WHERE entity_id = " . $vendor->getEntityId();
                $connection->query($sql);
                return true;
            }
        }
        catch (\Exception $e){
            return $e->getMessage();
        }
    }

    public function saveAddress($address, $addressId = null)
    {
        try{
            $arrayBlock = ['region', 'id'];
            $addressFactory = $this->addressFactory->create();
            if ( $addressId ){
                $addressFactory = $this->addressRegistry->retrieve($addressId);
            }
            $data = $this->dataProcessor->buildOutputDataArray($address, \Wiki\Vendors\Api\Data\AddressInterface::class);
            foreach ( $data as $attribute => $value ){
                if ( in_array($attribute, $arrayBlock) )
                    continue;
                $method = 'set' . str_replace(' ', '', ucwords(str_replace('_', ' ', $attribute)));
                $addressFactory->{$method}($value);
            }
            $vendor = $this->vendorFactory->create()->load($address->getSellerId());
            $addressFactory->setCustomerId($vendor->getCustomer()->getEntityId());
            $addressFactory->setSaveInAddressBook('1')->save();
            if ( $address->isDefaultMain() === true ){
                $setValue[] = "main_address = " . $addressFactory->getId();
            }
            if ( $address->isDefaultShipping() === true ){
                $setValue[] = "shipping_address = " . $addressFactory->getId();
            }
            if ( $address->isDefaultReturn() === true ){
                $setValue[] = "return_address = " . $addressFactory->getId();
            }
            if ( isset($setValue) ){
                $connection = $this->resource->getConnection();
                $tableName = $this->resource->getTableName('ves_vendor_entity');
                $sql = "UPDATE " . $tableName . " SET " . implode(", ", $setValue) . " WHERE entity_id = " . $vendor->getEntityId();
                $connection->query($sql);
            }
            return $this->addressRegistry->retrieve($addressFactory->getEntityId())->getDataModel();
        }
        catch (\Exception $e){
            return $e->getMessage();
        }
    }

    public function updateAddress($addressId, $address)
    {
        return $this->saveAddress($address, $addressId);
    }

    public function deleteAddress($addressId)
    {
        try{
            $addressFactory = $this->addressRegistry->retrieve($addressId);
            $vendor = $this->dataVendorApiHelper->getVendorByCustomerId($addressFactory->getParentId());
            $customer = $this->customerFactory->create()->load($addressFactory->getParentId());
            if ( $vendor->getMainAddress() == $addressId ){
                $setValue[] = "main_address = null";
            }
            if ( $vendor->getShippingAddress() == $addressId ){
                $setValue[] = "shipping_address = null";
            }
            if ( $vendor->getReturnAddress() == $addressId ){
                $setValue[] = "return_address = null";
            }
            if ( isset($setValue) ){
                $connection = $this->resource->getConnection();
                $tableName = $this->resource->getTableName('ves_vendor_entity');
                $sql = "UPDATE " . $tableName . " SET " . implode(", ", $setValue) . " WHERE entity_id = " . $vendor->getEntityId();
                $connection->query($sql);
            }
            $customer->getAddressesCollection()->removeItemByKey($addressId);
            $this->addressRegistry->remove($addressId);
            $addressFactory->delete();
            return true;
        }
        catch (\Exception $e){
            return $e->getMessage();
        }
    }
}
