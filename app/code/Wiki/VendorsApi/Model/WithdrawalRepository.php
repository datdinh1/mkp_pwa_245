<?php

namespace Wiki\VendorsApi\Model;

use Wiki\VendorsApi\Helper\Data as ApiHelper;
use Wiki\VendorsCredit\Model\ResourceModel\Withdrawal\Grid\CollectionFactory as VendorWithdrawalGridCollectionFactory;
use Magento\Framework\Api\DataObjectHelper as DataObjectHelper;
use Wiki\VendorsApi\Api\WithdrawalRepositoryInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Wiki\VendorsApi\Api\Data\Credit\WithdrawalInterfaceFactory as WithdrawalDataInterfaceFactory;
use Wiki\VendorsCredit\Model\Withdrawal as WithdrawalModel;
use Wiki\VendorsCredit\Model\CreditProcessor\Withdraw as WithdrawProcessor;

/**
 * Vendor repository.
 */
class WithdrawalRepository implements WithdrawalRepositoryInterface
{
    /**
     * @var ApiHelper
     */
    protected $helper;

    /**
     * @var VendorWithdrawalGridCollectionFactory
     */
    protected $vendorWithdrawalGridCollectionFactory;

    /**
     * @var \Wiki\VendorsApi\Api\Data\Credit\WithdrawalSearchResultInterfaceFactory
     */
    protected $searchResultFactory;

    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $_objectManager;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @var WithdrawalDataInterfaceFactory
     */
    protected $withdrawalDataInterfaceFactory;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
     * @var \Wiki\Credit\Model\CreditFactory
     */
    protected $_withdrawalFactory;

    /**
     * @var \Wiki\Credit\Model\Processor
     */
    protected $_creditProcessor;

    /**
     * @var \Wiki\Credit\Model\CreditFactory
     */
    protected $_creditAccountFactory;

    /**
     * @var \Wiki\VendorsCredit\Helper\Data
     */
    protected $_vendorCreditHelper;

    /**
     * WithdrawalRepository constructor.
     * @param DataObjectHelper $dataObjectHelper
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     * @param ApiHelper $helper
     * @param VendorWithdrawalGridCollectionFactory $vendorWithdrawalGridCollectionFactory
     * @param \Wiki\VendorsApi\Api\Data\Credit\WithdrawalSearchResultInterfaceFactory $searchResultFactory
     * @param CollectionProcessorInterface|null $collectionProcessor
     * @param \Wiki\Vendors\App\Action\Context $context
     * @param WithdrawalDataInterfaceFactory $withdrawalDataInterfaceFactory
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Wiki\Credit\Model\Processor $creditProcessor
     * @param \Wiki\Credit\Model\CreditFactory $creditAccountFactory
     * @param \Wiki\VendorsCredit\Model\WithdrawalFactory $withdrawalFactory
     * @param \Wiki\VendorsCredit\Helper\Data $vendorCreditHelper
     */
    public function __construct(
        DataObjectHelper $dataObjectHelper,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        ApiHelper $helper,
        VendorWithdrawalGridCollectionFactory $vendorWithdrawalGridCollectionFactory,
        \Wiki\VendorsApi\Api\Data\Credit\WithdrawalSearchResultInterfaceFactory $searchResultFactory,
        CollectionProcessorInterface $collectionProcessor = null,
        \Wiki\Vendors\App\Action\Context $context,
        WithdrawalDataInterfaceFactory $withdrawalDataInterfaceFactory,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Wiki\Credit\Model\Processor $creditProcessor,
        \Wiki\Credit\Model\CreditFactory $creditAccountFactory,
        \Wiki\VendorsCredit\Model\WithdrawalFactory $withdrawalFactory,
        \Wiki\VendorsCredit\Helper\Data $vendorCreditHelper
    ) {
        $this->dataObjectHelper = $dataObjectHelper;
        $this->_objectManager = $objectManager;
        $this->helper = $helper;
        $this->vendorWithdrawalGridCollectionFactory = $vendorWithdrawalGridCollectionFactory;
        $this->searchResultFactory = $searchResultFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->withdrawalDataInterfaceFactory = $withdrawalDataInterfaceFactory;
        $this->_scopeConfig = $scopeConfig;
        $this->_creditProcessor = $creditProcessor;
        $this->_creditAccountFactory = $creditAccountFactory;
        $this->_withdrawalFactory = $withdrawalFactory;
        $this->_vendorCreditHelper = $vendorCreditHelper;
    }

    /**
     * @param int $customerId
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Wiki\VendorsApi\Api\Data\Credit\WithdrawalSearchResultInterface
     */
    public function getList(
        $customerId,
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    ){
        $vendor = $this->helper->getVendorByCustomerId($customerId);
        $vendorId = $vendor->getId();
        $collection = $this->vendorWithdrawalGridCollectionFactory->create()->addFieldToFilter('vendor_id', $vendorId);

        $this->collectionProcessor->process($searchCriteria, $collection);
        $searchResults = $this->searchResultFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setTotalCount($collection->getSize());

        $withdrawals = [];
        /** @var \Wiki\VendorsCredit\Model\ResourceModel\Withdrawal\Grid\Collection $withdrawalModel */
        foreach ($collection as $withdrawalModel) {
            $withdrawalData = $this->withdrawalDataInterfaceFactory->create();
            $this->dataObjectHelper->populateWithArray(
                $withdrawalData,
                $withdrawalModel->getData(),
                'Wiki\VendorsApi\Api\Data\Credit\WithdrawalInterface'
            );
            $withdrawals[] = $withdrawalData;
        }

        $searchResults->setItems($withdrawals);
        return $searchResults;
    }

    /**
     * @param  int $customerId
     * @param  \Wiki\VendorsApi\Api\Data\Credit\WithdrawalInterface[] $withdrawal
     * @return \Wiki\VendorsApi\Api\Data\Credit\WithdrawalInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function createWithdrawal(
        $customerId,
        $withdrawal
    ) {
        $vendor = $this->helper->getVendorByCustomerId($customerId);
        $vendorId = $vendor->getId();

        foreach ($withdrawal as $w){
            $methodCode = $w['method'];
            $amount = $w['amount'];
        }

        $methodModelName = $this->_scopeConfig->getValue('withdrawal_methods/'.$methodCode.'/model');

        $method = $this->_objectManager->create($methodModelName);
        $fee = $method->calculateFee($amount);
        $netAmount = $amount - $fee;

        $withdrawal = $this->_withdrawalFactory->create();
        $withdrawal->setData([
            'vendor_id' => $vendorId,
            'method' => $methodCode,
            'method_title' => $method->getTitle(),
            'amount' => $amount,
            'fee' => $fee,
            'net_amount' => $netAmount,
            'additional_info' => serialize($method->getVendorAccountInfo($vendorId)),
            'status' => WithdrawalModel::STATUS_PENDING,
        ]);

        $withdrawal->save();

        /*Send new withdrawal notification email to vendor*/
        $this->_vendorCreditHelper->sendNewWithdrawalNotificationToVendor($withdrawal, $vendor);

        /*Send new withdrawal notification email to admin*/
        $this->_vendorCreditHelper->sendNewWithdrawalNotificationToAdmin($withdrawal, $vendor);

        /*Reset session*/
//        $this->_session->setWithdrawalParams(null);

        /*Create transaction to subtract the credit.*/
        $creditAccount = $this->_creditAccountFactory->create();
        $creditAccount->loadByCustomerId($customerId);
        $data = [
            'vendor' => $vendor,
            'type' => WithdrawProcessor::TYPE,
            'amount' => $amount,
            'withdrawal_request' => $withdrawal,
        ];
        $this->_creditProcessor->process($creditAccount, $data);

        $withdrawalObject = $this->withdrawalDataInterfaceFactory->create();
        $this->dataObjectHelper->populateWithArray(
            $withdrawalObject,
            $withdrawal->getData(),
            'Wiki\VendorsApi\Api\Data\Sale\InvoiceInterface'
        );
        return $withdrawalObject;
    }
}

