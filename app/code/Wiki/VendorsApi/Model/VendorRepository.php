<?php

namespace Wiki\VendorsApi\Model;

/**
 * Vendor repository.
 */
class VendorRepository implements \Wiki\VendorsApi\Api\VendorRepositoryInterface
{
    /**
     * @var \Wiki\VendorsApi\Helper\Data
     */
    protected $helper;

    /**
     * @var \Wiki\VendorsApi\Api\Data\VendorInterfaceFactory
     */
    protected $vendorDataFactory;
    
    /**
     * @var \Magento\Framework\Api\DataObjectHelper
     */
    protected $dataObjectHelper;
    
    /**
     * @var \Wiki\VendorsDashboard\Model\Graph
     */
    protected $graph;
    
    /**
     * @param \Wiki\VendorsApi\Helper\Data $helper
     * @param \Wiki\VendorsApi\Api\Data\VendorInterfaceFactory $vendorDataFactory
     * @param \Magento\Framework\Api\DataObjectHelper $dataObjectHelper
     * @param \Wiki\VendorsDashboard\Model\Graph $graph
     */
    public function __construct(
        \Wiki\VendorsApi\Helper\Data $helper,
        \Wiki\VendorsApi\Api\Data\VendorInterfaceFactory $vendorDataFactory,
        \Magento\Framework\Api\DataObjectHelper $dataObjectHelper,
        \Wiki\VendorsDashboard\Model\Graph $graph
    ) {
        $this->helper               = $helper;
        $this->vendorDataFactory    = $vendorDataFactory;
        $this->dataObjectHelper     = $dataObjectHelper;
        $this->graph                = $graph;
    }

    /**
     * {@inheritdoc}
     */
    public function getById($customerId)
    {
        $customer   = $this->helper->getCustomer($customerId);
        $vendor     = $this->helper->getVendorByCustomer($customer);
        
        $vendorDataObject = $this->vendorDataFactory->create();        
        $this->dataObjectHelper->populateWithArray(
            $vendorDataObject,
            $vendor->getData(),
            \Magento\Customer\Api\Data\CustomerInterface::class
        );
        
        $vendorDataObject->setCustomerId($customerId);
        $vendorDataObject->setEmail($customer->getEmail());
        $vendorDataObject->setGroupName($vendor->getGroup()->getVendorGroupCode());
        
        return $vendorDataObject;
    }
}
