<?php
/**
 * @author Mohit Patel
 * @copyright Copyright (c) 2021
 * @package Mag_CustomForm
 */

namespace Wiki\Vendors\Model\Resolver;

use Wiki\Vendors\Api\SellerManagementInterface;
use Wiki\Vendors\Model\Api\AccountEmailFactory;
use Wiki\Credit\Model\CreditFactory;
use Wiki\Vendors\Model\VendorFactory;
use Wiki\Vendors\Helper\Data as VendorHelper;
use Wiki\Vendors\Model\Vendor;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Registry;

class AccountSellerFormOutput
{
    protected $accountEmailFactory;

    protected $sellerManagement;

    protected $_resource;

    /**
     *
     * @var \Wiki\Credit\Model\CreditFactory
     */

    protected $_creditFactory;

    /**
     *
     * @var \Wiki\Vendors\Model\VendorFactory
     */

    protected $_vendorFactory;

    /**
     *
     * @var \Wiki\Vendors\Helper\Data as VendorHelper
     */

    protected $_vendorHelper;

    /**
     *
     * @var \Magento\Framework\Registry;
     */
    protected $_coreRegistry;

   public function __construct(
    SellerManagementInterface $sellerManagement,
    AccountEmailFactory $accountEmailFactory,
    ResourceConnection $resource,
    CreditFactory $creditFactory,
    VendorFactory $vendorFactory,
    VendorHelper $vendorHelper,
    Registry $coreRegistry
    ) {
        $this->sellerManagement = $sellerManagement;
        $this->accountEmailFactory = $accountEmailFactory;
        $this->_resource  = $resource;
        $this->_creditFactory = $creditFactory;
        $this->_vendorFactory = $vendorFactory;
        $this->_vendorHelper  = $vendorHelper;
        $this->_coreRegistry  = $coreRegistry;
    }
    /**
     * @inheritdoc
     */
    public function afterExecute($subject, $customer)
    { 
        $connection = $this->_resource->getConnection();
        $tableName = $this->_resource->getTableName('ves_vendor_entity');
        $query = "SELECT entity_id FROM " . $tableName;
        $resultQuery = $connection->fetchAll($query);
        if (count($resultQuery) > 0) {
            $max = max($resultQuery);
        } else {
            $max["entity_id"] = 0;
        }
        $newEntity = $max["entity_id"] + 1;
        // Create Credit
        $creditsModel = $this->_creditFactory->create();
        $creditsModel->setCustomerId($customer->getId());
        $creditsModel->setCredit(0.0000);
        $creditsModel->save();
        // Create Vendor 
        $vendor = $this->_vendorFactory->create();
        // $this->orderMagento->get($order_entity);
        $vendor->setVendorId("SELLER" . $newEntity);
        $vendor->setGroupId($this->_vendorHelper->getDefaultVendorGroup());
        $vendor->setCustomer($customer);
        $vendor->setWebsiteId($customer->getWebsiteId());
        $vendor->setStatus(Vendor::STATUS_APPROVED);
        $vendor->save();
        $this->_coreRegistry->register('current_vendor_id', $vendor->getId());
        $vendor->setData("flag_notify_email", 0)->save();
        return $customer;
    }
}