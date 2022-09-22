<?php
namespace Wiki\VendorsApi\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\Exception\AuthorizationException;

class Data extends AbstractHelper
{
    /**
     * @var \Magento\Customer\Model\CustomerRegistry
     */
    protected $customerRegistry;
    
    /**
     * @var \Wiki\Vendors\Model\VendorFactory
     */
    protected $vendorFactory;
    
    /**
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Customer\Model\CustomerRegistry $customerRegistry
     * @param \Wiki\Vendors\Model\VendorFactory $vendorFactory
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Customer\Model\CustomerRegistry $customerRegistry,
        \Wiki\Vendors\Model\VendorFactory $vendorFactory
    ) {
        $this->customerRegistry     = $customerRegistry;
        $this->vendorFactory        = $vendorFactory;
        parent::__construct($context);
    }
    
    /**
     * Get customer by id
     * 
     * @param int $customerId
     * @return \Magento\Customer\Model\Customer
     */
    public function getCustomer($customerId){
        return $this->customerRegistry->retrieve($customerId);
    }
    
    /**
     * Get vendor by customer id
     * 
     * @param int $customerId
     * @return \Wiki\Vendors\Model\Vendor
     */
    public function getVendorByCustomerId($customerId)
    {
        $customer = $this->getCustomer($customerId);
        return $this->getVendorByCustomer($customer);
    }
    
    /**
     * Get vendor by customer
     * 
     * @param \Magento\Customer\Model\Customer $customer
     * @return \Wiki\Vendors\Model\Vendor
     */
    public function getVendorByCustomer(\Magento\Customer\Model\Customer $customer){
        $vendor = $this->vendorFactory->create();
        $vendor->getResource()->loadByCustomer($vendor, $customer);
        if(!$vendor->getId()){
            throw new AuthorizationException(
                __('You have not created a seller account yet')
            );
        }
        
        if($vendor->getStatus() != \Wiki\Vendors\Model\Vendor::STATUS_APPROVED){
            throw new AuthorizationException(
                __('Your seller account is not approved. You can\'t not use API')
            );
        }
        return $vendor;
    }
}