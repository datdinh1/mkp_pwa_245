<?php
/**
 * Copyright (c) 2017 Wiki Co ltd. All rights reserved.
 */

namespace Wiki\VendorsSubAccount\Controller\Vendors\User;

use Magento\Customer\Api\AccountManagementInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\Data\CustomerInterfaceFactory;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Exception\LocalizedException;
use Magento\Customer\Model\CustomerRegistry;
use Magento\Framework\Encryption\EncryptorInterface as Encryptor;

class Save extends \Wiki\Vendors\Controller\Vendors\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    protected $_aclResource = 'Wiki_VendorsQuotation::subaccount_user';

    /**
     * @var \Wiki\VendorsSubAccount\Model\RoleFactory
     */
    protected $roleFactory;

    /**
     * @var CustomerInterfaceFactory
     */
    protected $customerDataFactory;

    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * @var AccountManagementInterface
     */
    protected $customerAccountManagement;

    /**
     * @var CustomerRepositoryInterface
     */
    protected $_customerRepository;

    /**
     * @var CustomerRegistry
     */
    private $customerRegistry;

    /**
     * @var Encryptor
     */
    private $encryptor;

    /**
     * @var \Magento\Customer\Model\Customer\Mapper
     */
    protected $customerMapper;

    /**
     * @param \Wiki\Vendors\App\Action\Context $context
     * @param DataObjectHelper $dataObjectHelper
     * @param AccountManagementInterface $customerAccountManagement
     * @param CustomerRepositoryInterface $customerRepository
     * @param CustomerRegistry $customerRegistry
     * @param \Magento\Customer\Model\Customer\Mapper $customerMapper
     * @param Encryptor $encryptor
     * @param CustomerInterfaceFactory $customerDataFactory
     */
    public function __construct(
        \Wiki\Vendors\App\Action\Context $context,
        DataObjectHelper $dataObjectHelper,
        AccountManagementInterface $customerAccountManagement,
        CustomerRepositoryInterface $customerRepository,
        CustomerRegistry $customerRegistry,
        \Magento\Customer\Model\Customer\Mapper $customerMapper,
        Encryptor $encryptor,
        CustomerInterfaceFactory $customerDataFactory,
        \Wiki\Vendors\Helper\Email $emailHelper
    )
    {
        $this->customerAccountManagement = $customerAccountManagement;
        $this->_customerRepository = $customerRepository;
        $this->customerDataFactory = $customerDataFactory;
        $this->customerRegistry = $customerRegistry;
        $this->encryptor = $encryptor;
        $this->customerMapper = $customerMapper;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->_emailHelper = $emailHelper;
        parent::__construct($context);
    }

    /**
     * Index action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $request = $this->getRequest();

        $customerId = $request->getParam('user_id');

        try{
            $currentPassword = $request->getParam('current_password');
            $user = $this->_vendorsession->getCustomer();

            if(!$user->validatePassword($currentPassword)){
                throw new LocalizedException(__("The current password is not valid."));
            }
            
            $roleId = $request->getParam('role_id');

            if(!$roleId){
                throw new LocalizedException(__("You must select role for this user."));
            }

            $password = $request->getParam('password');
            $confirmation = $request->getParam('password_confirmation');
            if(
                !$customerId ||
                ($customerId && ($password || $confirmation))
            ) {
                if($password != $confirmation){
                    throw new LocalizedException(__("The user passwords do not match."));
                }
            }

            $customerData = $request->getParams();

            if ($customerId) {
                $currentCustomer = $this->_customerRepository->getById($customerId);
                $customerData = array_merge(
                    $this->customerMapper->toFlatArray($currentCustomer),
                    $customerData
                );
                $customerData['id'] = $customerId;
            }

            /** @var CustomerInterface $customer */
            $customer = $this->customerDataFactory->create();
            $this->dataObjectHelper->populateWithArray(
                $customer,
                $customerData,
                \Magento\Customer\Api\Data\CustomerInterface::class
            );

            $resource = $this->_objectManager->create('Wiki\VendorsSubAccount\Model\ResourceModel\User');


            $isActive = $request->getParam('is_active_user');
            if ($customerId) {
                if($password){
                    /* Change Password*/
                    $customerSecure = $this->customerRegistry->retrieveSecureData($customer->getId());
                    $customerSecure->setRpToken(null);
                    $customerSecure->setRpTokenCreatedAt(null);
                    $customerSecure->setPasswordHash($this->encryptor->getHash($password, true));
                }
                $this->_customerRepository->save($customer);
                if($resource->isSupserUser($customerId)){
                    $roleId = 0;
                    $isActive = 1;
                }
                $resource->updateUserData($customerId, $roleId, $isActive);
            } else {
                $customer = $this->customerAccountManagement->createAccount($customer, $password);
                $customerId = $customer->getId();
                $resource->addVendorUser($customerId, $this->_session->getVendor()->getId(), $roleId, $isActive);
            }

            $subAccountEmail = $request->getParam('email');
            $vendorLoginLink = $this->getUrl('vendors');

            $this->_emailHelper->sendTransactionEmail(
                'vendors/subaccount/subaccount_email_user',
                \Magento\Framework\App\Area::AREA_FRONTEND,
                'vendors/subaccount/sender_email_identity',
                $subAccountEmail,
                ['vendor' => $this->_vendorsession->getVendor(), 'vendorLoginLink' => $vendorLoginLink]
            );

            /* Clean vendor menu cache*/
            $this->_objectManager->get('Magento\Framework\App\CacheInterface')
                ->clean(['vendor_menu_'.$customer->getId()]);

            $this->messageManager->addSuccess(__('The user is saved.'));

        }catch (\Magento\Framework\Validator\Exception $exception) {
            $this->messageManager->addError($exception->getMessage());
            $this->_session->setUserData($request->getParams());
            return $this->resultRedirectFactory->create()
                ->setPath('subaccount/user/edit', ['user_id' => $request->getParam('user_id')]);
        } catch (LocalizedException $exception) {
            $this->messageManager->addError($exception->getMessage());
            $this->_session->setUserData($request->getParams());
            return $this->resultRedirectFactory->create()
                ->setPath('subaccount/user/edit', ['user_id' => $request->getParam('user_id')]);
        } catch (\Exception $exception) {
            $this->messageManager->addException($exception, __('Something went wrong while saving the user.'));
            $returnToEdit = true;
            return $this->resultRedirectFactory->create()
                ->setPath('subaccount/user');
        }

        return $this->resultRedirectFactory->create()
            ->setPath('subaccount/user');
    }
}
