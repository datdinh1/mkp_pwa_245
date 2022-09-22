<?php 
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\OtpSms\Model;

use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\EmailNotConfirmedException;
use Magento\Framework\Exception\InvalidEmailOrPasswordException;
use Magento\Framework\Exception\State\UserLockedException;
use Magento\Customer\Model\AuthenticationInterface;
use Magento\Customer\Model\AccountManagement as CustomerAccountManagement;

class AccountManagement extends CustomerAccountManagement
{
    /**
     * @var \Magento\Framework\Event\ManagerInterface
     */
    private $eventManager;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    private $objectManager;

    /**
     * @var \Magento\Customer\Model\CustomerFactory
     */
    private $customerFactory;

    /**
     * @var \Magento\Customer\Api\CustomerRepositoryInterface
     */
    private $customerRepository;

    /**
     * @param \Magento\Customer\Model\CustomerFactory $customerFactory
     * @param \Magento\Framework\Event\ManagerInterface $eventManager
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\Math\Random $mathRandom
     * @param \Magento\Customer\Model\Metadata\Validator $validator
     * @param \Magento\Customer\Api\Data\ValidationResultsInterfaceFactory $validationResultsDataFactory
     * @param \Magento\Customer\Api\AddressRepositoryInterface $addressRepository
     * @param \Magento\Customer\Api\CustomerMetadataInterface $customerMetadataService
     * @param \Magento\Customer\Model\CustomerRegistry $customerRegistry
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Magento\Framework\Encryption\EncryptorInterface $encryptor
     * @param \Magento\Customer\Model\Config\Share $configShare
     * @param \Magento\Framework\Stdlib\StringUtils $stringHelper
     * @param \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder
     * @param \Magento\Framework\Reflection\DataObjectProcessor $dataProcessor
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Customer\Helper\View $customerViewHelper
     * @param \Magento\Framework\Stdlib\DateTime $dateTime
     * @param \Magento\Customer\Model\Customer $customerModel
     * @param \Magento\Framework\DataObjectFactory $objectFactory
     * @param \Magento\Framework\Api\ExtensibleDataObjectConverter $extensibleDataObjectConverter
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     */
    public function __construct(
        \Magento\Customer\Model\CustomerFactory $customerFactory,
        \Magento\Framework\Event\ManagerInterface $eventManager,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Math\Random $mathRandom,
        \Magento\Customer\Model\Metadata\Validator $validator,
        \Magento\Customer\Api\Data\ValidationResultsInterfaceFactory $validationResultsDataFactory,
        \Magento\Customer\Api\AddressRepositoryInterface $addressRepository,
        \Magento\Customer\Api\CustomerMetadataInterface $customerMetadataService,
        \Magento\Customer\Model\CustomerRegistry $customerRegistry,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\Encryption\EncryptorInterface $encryptor,
        \Magento\Customer\Model\Config\Share $configShare,
        \Magento\Framework\Stdlib\StringUtils $stringHelper,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Magento\Framework\Reflection\DataObjectProcessor $dataProcessor,
        \Magento\Framework\Registry $registry,
        \Magento\Customer\Helper\View $customerViewHelper,
        \Magento\Framework\Stdlib\DateTime $dateTime,
        \Magento\Customer\Model\Customer $customerModel,
        \Magento\Framework\DataObjectFactory $objectFactory,
        \Magento\Framework\Api\ExtensibleDataObjectConverter $extensibleDataObjectConverter,
        \Magento\Framework\ObjectManagerInterface $objectManager
    ) {
        parent::__construct(
            $customerFactory,
            $eventManager,
            $storeManager,
            $mathRandom,
            $validator,
            $validationResultsDataFactory,
            $addressRepository,
            $customerMetadataService,
            $customerRegistry,
            $logger,
            $encryptor,
            $configShare,
            $stringHelper,
            $customerRepository,
            $scopeConfig,
            $transportBuilder,
            $dataProcessor,
            $registry,
            $customerViewHelper,
            $dateTime,
            $customerModel,
            $objectFactory,
            $extensibleDataObjectConverter
        );

        $this->eventManager = $eventManager;
        $this->storeManager = $storeManager;
        $this->objectManager = $objectManager;
        $this->customerFactory = $customerFactory;
        $this->customerRepository = $customerRepository;
    }

    private function getAuthentication()
    {
        if (!($this->authentication instanceof AuthenticationInterface)) {
            return ObjectManager::getInstance()->get(AuthenticationInterface::class);
        } 
        else {
            return $this->authentication;
        }
    }

    public function authenticate($username, $password)
    {
        try {
            $customer = $this->loginViaPhoneOrEmail($username);
        } 
        catch (NoSuchEntityException $e) {
            throw new InvalidEmailOrPasswordException(__('Invalid login or password.'));
        }

        $customerId = $customer->getId();
        if ($this->getAuthentication()->isLocked($customerId)) {
            throw new UserLockedException(__('The account is locked.'));
        }
        try {
            $this->getAuthentication()->authenticate($customerId, $password);
        } 
        catch (InvalidEmailOrPasswordException $e) {
            throw new InvalidEmailOrPasswordException(__('Invalid login or password.'));
        }
        if ($customer->getConfirmation() && $this->isConfirmationRequired($customer)) {
            throw new EmailNotConfirmedException(__("This account isn't confirmed. Verify and try again."));
        }

        $customerModel = $this->customerFactory->create()->updateData($customer);
        $this->eventManager->dispatch(
            'customer_customer_authenticated',
            ['model' => $customerModel, 'password' => $password]
        );

        $this->eventManager->dispatch('customer_data_object_login', ['customer' => $customer]);
        return $customer;
    }

    private function loginViaPhoneOrEmail($username)
    {
        $customer = $this->findCustomerByLoginPhone($username);
        if (false === $customer) {
            $customer = $this->customerRepository->get($username);
        }
        return $customer;
    }

    private function findCustomerByLoginPhone($phoneNumber)
    {
        $resource = $this->objectManager->get(ResourceConnection::class);
        $tableName = $resource->getTableName('customer_entity');
        $connection = $resource->getConnection();

        $sql = $connection->select()->from(['c' => $tableName])->where('c.mobile = ?', $phoneNumber);
        $row = $connection->fetchRow($sql);
        if ($row !== false) {
            try {
                return $this->customerRepository->get($row['email']);
            } 
            catch (NoSuchEntityException $e) { }
        }
        return false;
    }
}
