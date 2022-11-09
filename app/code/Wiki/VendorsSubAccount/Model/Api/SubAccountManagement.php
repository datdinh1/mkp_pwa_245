<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Wiki\VendorsSubAccount\Model\Api;

use Magento\Customer\Api\Data\CustomerInterfaceFactory;
use Wiki\VendorsSubAccount\Api\SubAccountManagementInterface;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Customer\Model\CustomerRegistry;
use Magento\Framework\Encryption\EncryptorInterface as Encryptor;

/**
 * Handle various customer account actions
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @SuppressWarnings(PHPMD.TooManyFields)
 * @SuppressWarnings(PHPMD.ExcessiveClassComplexity)
 * @SuppressWarnings(PHPMD.CookieAndSessionMisuse)
 */
class SubAccountManagement implements SubAccountManagementInterface
{
    /**
     * @var \Wiki\VendorsSubAccount\Model\ResourceModel\Role\CollectionFactory
     */
    protected $_userRolesFactory;

    /**
     * @var \Wiki\VendorsSubAccount\Model\ResourceModel\User\Grid\CollectionFactory
     */
    protected $_userFactory;

    public function __construct(
        \Wiki\VendorsSubAccount\Model\ResourceModel\Role\CollectionFactory $userRolesFactory,
        \Magento\Customer\Model\Customer $customer,
        \Magento\Customer\Api\Data\CustomerInterfaceFactory $customerDataFactory,
        \Magento\Framework\Api\DataObjectHelper $dataObjectHelper,
        \Wiki\VendorsSubAccount\Model\ResourceModel\User $subaccountUser,
        \Magento\Customer\Model\CustomerRegistry $customerRegistry,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository,
        \Magento\Customer\Model\AccountManagement $customerAccountManagement,
        \Wiki\VendorsSubAccount\Model\ResourceModel\User\Grid\CollectionFactory $userFactory,
        \Wiki\Vendors\Model\Vendor $vendorsModel,
        \Magento\Framework\App\CacheInterface $cache,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Customer\Model\Customer\Mapper $customerMapper,
        Encryptor $encryptor,
        \Wiki\Vendors\Helper\Email $emailHelper
    ) {
        $this->_userRolesFactory                = $userRolesFactory;
        $this->_userFactory                     = $userFactory;
        $this->_customerAccountManagement       = $customerAccountManagement;
        $this->_customer                        = $customer;
        $this->_customerDataFactory             = $customerDataFactory;
        $this->_dataObjectHelper                = $dataObjectHelper;
        $this->_subaccountUser                  = $subaccountUser;
        $this->_customerRegistry                = $customerRegistry;
        $this->_customerRepository              = $customerRepository;
        $this->_emailHelper                     = $emailHelper;
        $this->_cache                           = $cache;
        $this->_vendorsModel                    = $vendorsModel;
        $this->_storeManager                    = $storeManager;
        $this->_customerMapper                  = $customerMapper;
        $this->_encryptor                       = $encryptor;
    }
    /**
     * @inheritdoc
     */
    public function getAllSubAccount($vendorId)
    {
        $collection = $this->_userFactory->create()->addFieldToFilter('vendor_id', $vendorId);
        $arraySubAccount = [];
        foreach($collection as $item){
            $arraySubAccount[] = $item->getData();
        }
        return $arraySubAccount;
    }

    /**
     * @inheritdoc
     */
    public function getRoleData($vendorId)
    {
        $collection = $this->_userRolesFactory->create()->addFieldToFilter('vendor_id', $vendorId);
        $arraySubAccount = [];
        foreach($collection as $item){
            $arraySubAccount[] = $item->getData();
        }
        return $arraySubAccount;
    }

    /**
     * @inheritdoc
     */
    // {
    //     "customerID": "1",
    //     "customerSub": {
    //          "is_active_user": "1",
    //          "firstname": "cuong",
    //          "lastname": "chau",
    //          "email": "cuong221@gmail.com",
    //          "password": "Cuong123",
    //          "password_confirmation": "Cuong123",
    //          "user_id": "",
    //          "current_password": "Cuong123",
    //          "limit": "20",
    //          "page": "1",
    //          "assigned_user_role": "",
    //          "assigned_user_role_name": "",
    //          "role_id": "1"
    //    },
    //     "password": "Cuong123",
    //     "roleId": "string"
    //   }
    public function createSubAccount($customerID, $customerSub, $password, $roleId)
    {
        try{
            $user = $this->_customer->load($customerID);
            $customerVendor         = $this->_vendorsModel->loadByCustomer($user);
            $customerId = $customerSub["user_id"];
            $customerData = $customerSub;
            if ($customerId) {
                $currentCustomer = $this->_customerRepository->getById($customerId);
                $customerData = array_merge(
                    $this->_customerMapper->toFlatArray($currentCustomer),
                    $customerSub
                );
                $customerData['id'] = $customerId;
            }
            /** @var CustomerInterface $customer */
            $customer = $this->_customerDataFactory->create();
            $this->_dataObjectHelper->populateWithArray(
                $customer,
                $customerData,
                \Magento\Customer\Api\Data\CustomerInterface::class
            );
            $isActive = $customerSub["is_active_user"];
            if ($customerId) {
                if($password){
                    /* Change Password*/
                    $customerSecure = $this->_customerRegistry->retrieveSecureData($customer->getId());
                    $customerSecure->setRpToken(null);
                    $customerSecure->setRpTokenCreatedAt(null);
                    $customerSecure->setPasswordHash($this->_encryptor->getHash($password, true));
                }
                $this->_customerRepository->save($customer);
                if($this->_subaccountUser->isSupserUser($customerId)){
                    $roleId = 0;
                    $isActive = 1;
                }
                $this->_subaccountUser->updateUserData($customerId, $roleId, $isActive);
            } else {
                $customer = $this->_customerAccountManagement->createAccount($customer, $password);
                $customerId = $customer->getId();
                $this->_subaccountUser->addVendorUser($customerId, $customerVendor->getEntityId(), $roleId, $isActive);
            }
            ;
            // $subAccountEmail = $request->getParam('email');
            $subAccountEmail = $customerSub["email"];
            $vendorLoginLink = $this->_storeManager->getStore()->getBaseUrl() ."vendors/vendors/";

            $this->_emailHelper->sendTransactionEmail(
                'vendors/subaccount/subaccount_email_user',
                \Magento\Framework\App\Area::AREA_FRONTEND,
                'vendors/subaccount/sender_email_identity',
                $subAccountEmail,
                ['vendor' => $customerVendor, 'vendorLoginLink' => $vendorLoginLink]
            );

            /* Clean vendor menu cache*/
            $this->_cache->clean(['vendor_menu_'.$customer->getId()]);
            return "The user is saved.";
        } catch (\Exception $exception) {
            $this->messageManager->addException($exception, __('Something went wrong while saving the user.'));
            return "Something went wrong while saving the user.";
        }
        
    }
}
