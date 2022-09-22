<?php 
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\OtpSms\Model;

use Magento\Framework\ObjectManagerInterface;
use Magento\Customer\Model\CustomerFactory;
use Wiki\OtpSms\Model\Data\ResponseFactory;
use Wiki\Credit\Model\CreditFactory;
use Wiki\Vendors\Model\Vendor;
use Magento\Framework\Registry;

class SmsManagement implements \Wiki\OtpSms\Api\SmsManagementInterface
{
    /**
     * @var ObjectManagerInterface
     */
    protected $objectManager;

    /**
     * @var CustomerFactory
     */
    protected $customerFactory;

    /**
     * @var ResponseFactory
     */
    protected $responseFactory;

    /**
     * @var \Wiki\OtpSms\Helper\Data
     */
    protected $helperData;

    /**
     * News model factory
     *
     * @var \Wiki\Credit\Model\CreditFactory
    */
    protected $_creditFactory;

    /**
     * @var \Wiki\Vendors\Model\VendorFactory
    */
    protected $_vendorFactory;

    /**
     * @var \Wiki\Vendors\Helper\Data
    */
    protected $_vendorHelper;

    /**
     * @param ObjectManagerInterface $objectManager
     * @param CustomerFactory $customerFactory
     * @param ResponseFactory $responseFactory
     * @param \Wiki\OtpSms\Helper\Data $helperData
     */
    public function __construct(
        ObjectManagerInterface $objectManager,
        CustomerFactory $customerFactory,
        ResponseFactory $responseFactory,
        CreditFactory $creditFactory,
        \Wiki\OtpSms\Helper\Data $helperData,
        \Magento\Framework\App\ResourceConnection $resource,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Wiki\Vendors\Model\VendorFactory $vendorFactory,
        \Wiki\Vendors\Helper\Data $vendorHelper,
        Registry $coreRegistry
    ) {
        $this->helperData         = $helperData;
        $this->objectManager      = $objectManager;
        $this->customerFactory    = $customerFactory;
        $this->responseFactory    = $responseFactory;
        $this->_resource          = $resource;
        $this->_storeManager      = $storeManager;
        $this->_creditFactory     = $creditFactory;
        $this->_vendorFactory     = $vendorFactory;
        $this->_vendorHelper      = $vendorHelper;
        $this->_coreRegistry      = $coreRegistry;
    }

    /**
	 * {@inheritdoc}
	 */
    public function sendOTPToPhone($otp, $phoneNumber)
    {
        $response = $this->responseFactory->create();
        $response->setStatus(false);
        $response->setMessage(__('The module disabled.'));
        
        $isEnable = $this->helperData->isEnableModule();
        if ($isEnable) {
            // Check account exits
            $accountExists = $this->checkExistingAccount($phoneNumber);
            if ($accountExists) {
                $response->setMessage(__('An account already exits with this phone number.'));
                goto CHECK_END;
            }
            // Send sms OTP
            $status = $this->helperData->sendSmsMessage($otp, $phoneNumber);
            if ($status) {
                $response->setStatus($status);
                $response->setMessage(__('Please Enter the OTP sent to your registered phone number.'));
            }
            else {
                $response->setMessage(__('Unable to send OTP. Please try again later.'));
            }
        }

        CHECK_END:
        return $response;
    }

    private function checkExistingAccount($phoneNumber)
    {
        $resource = $this->objectManager->get(\Magento\Framework\App\ResourceConnection::class);
        $tableName = $resource->getTableName('customer_entity');
        $connection = $resource->getConnection();

        $sql = $connection->select()->from(['c' => $tableName])->where('c.mobile = ?', $phoneNumber);
        $row = $connection->fetchRow($sql);
        return ($row !== false) ? true : false;
    }

    public function createAccountMobile($customer){
        $mobile = $customer->getMobile();
        $connection = $this->_resource->getConnection();

        //save customer with mobile
        $websiteId  = $this->_storeManager->getWebsite()->getWebsiteId();
        $cusOb   = $this->customerFactory->create();
        $cusOb->setWebsiteId($websiteId);
        $tmpEmail = $mobile."@gmail.com";
        $cusOb->setEmail($tmpEmail);
        $cusOb->setFirstname($customer->getFirstName());
        $cusOb->setLastname($customer->getLastName());

        $cusOb->setPassword($customer->getPassword());
        $cusOb->setStoreId(1);
        $cusOb->setCustomAttribute('mobile', $mobile);
        $cusOb->save();

        $tableCustomer = $this->_resource->getTableName('customer_entity');
        $id =  $cusOb->getId();
        $sql = "UPDATE `" . $tableCustomer . "` SET `mobile`= '$mobile' WHERE `entity_id`= $id ";
        $connection->query($sql);

        $creditsModel = $this->_creditFactory ->create();
        $creditsModel->setCustomerId($cusOb->getId());
        $creditsModel->setCredit(0.0000);
        $creditsModel->save();


        $tableName = $this->_resource->getTableName('ves_vendor_entity');
        $query = "SELECT entity_id FROM " . $tableName;
        $result = $connection->fetchAll($query);
        $max = 0;
        if($result){
            $max = max($result);
        }
        
        $newEntity = $max["entity_id"]+1;

        $vendor = $this->_vendorFactory->create();
        $vendor->setVendorId("SELLER" . $newEntity);
        $vendor->setCompany(" ");
        $vendor->setStreet(" ");
        $vendor->setCity(" ");
        $vendor->setCountryId(" ");
        $vendor->setRegion(" ");
        $vendor->setPostcode(" ");
        $vendor->setTelephone($cusOb->getMobile());
        $vendor->setGroupId($this->_vendorHelper->getDefaultVendorGroup());
        $vendor->setCustomer($cusOb);
        $vendor->setWebsiteId($cusOb->getWebsiteId());
        $vendor->setStatus(Vendor::STATUS_APPROVED);
        $vendor->save();

        $this->_coreRegistry->register('current_vendor_id', $vendor->getId());
        $vendor->setData("flag_notify_email", 0)->save();
        
        return true;
    }
}
