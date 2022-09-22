<?php
namespace Wiki\Vendors\Controller\Adminhtml\Customer;

use Wiki\Vendors\Controller\Adminhtml\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Framework\Stdlib\DateTime\Filter\Date;
use Magento\Customer\Model\CustomerExtractor;
use Magento\Backend\Model\UrlFactory;
use Magento\Customer\Api\AccountManagementInterface;

class SavePost extends Action
{

    /** @var AccountManagementInterface */
    protected $accountManagement;

    /**
     * @var \Wiki\Vendors\Model\VendorFactory
     */
    protected $vendorFactory;

    /** @var CustomerExtractor */
    protected $customerExtractor;


    /** @var \Magento\Backend\Model\UrlFactory */
    protected $urlModel;

    /**
     * @var \Wiki\Vendors\Helper\Data
     */
    protected $_vendorHelper;

    /**
     * @var \Wiki\Credit\Model\Credit
     */
    protected $creditAccount;

    /**
     * Is access to section allowed
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return parent::_isAllowed() && $this->_authorization->isAllowed('Wiki_Vendors::vendors_sellers');
    }


    /**
     * Constructor
     *
     * @param Context $context
     * @param Registry $coreRegistry
     * @param Date $dateFilter
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        Date $dateFilter,
        \Wiki\Vendors\Model\VendorFactory $vendorFactory,
        AccountManagementInterface $accountManagement,
        \Wiki\Vendors\Helper\Data $vendorHelper,
        \Magento\Customer\Model\CustomerFactory $customerFactory,
        \Wiki\Credit\Model\CreditFactory $creditAccountFactory
    ) {
        $this->vendorFactory = $vendorFactory;
        $this->accountManagement = $accountManagement;
        $this->_vendorHelper = $vendorHelper;
        $this->customerModel = $customerFactory;
        $this->creditAccount = $creditAccountFactory->create();
        parent::__construct($context, $coreRegistry, $dateFilter);
    }


    /**
     * @return void
     */
    public function execute()
    {
        $originalRequestData = $this->getRequest()->getPostValue();
        if ($originalRequestData) {
            try {
                // create and save customer
                $customerId = $this->getRequest()->getPostValue('customer_id');
                $customer = $this->customerModel->create()->load($customerId);
                $this->creditAccount->loadByCustomerId($customer->getId());
                // After save
                $this->_eventManager->dispatch(
                    'adminhtml_customer_save_after',
                    ['customer' => $customer, 'request' => $this->getRequest()]
                );
                // optional fields might be set in request for future processing by observers in other modules
                $vendorData = $this->getRequest()->getParam('vendor_data');
                $request = $this->getRequest();

                $vendor = $this->vendorFactory->create();

                $vendor->addData($vendorData);

                $vendor->setCustomer($customer);
                $vendor->setWebsiteId($customer->getWebsiteId());

                $this->_eventManager->dispatch(
                    'adminhtml_vendor_prepare_save',
                    ['vendor' => $vendor, 'request' => $request]
                );

                // Save vendor
                $vendor->save();

                if ($this->_vendorHelper->isRequiredVendorApproval()) {
                    $vendor->sendNewAccountEmail("registered");
                } else {
                    $vendor->sendNewAccountEmail("active");
                }


                $this->_eventManager->dispatch(
                    'adminhtml_vendor_save_after',
                    ['vendor' => $vendor, 'request' => $request]
                );
                // Done Saving customer, finish save action
                $this->_coreRegistry->register('current_vendor_id', $vendor->getId());
                $this->messageManager->addSuccess(__('You saved the vendor.'));


                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('vendors/index/edit', ['id' => $vendor->getId()]);
                    return;
                }
                $this->_getSession()->unsCustomerFormData();
                $this->_redirect('vendors/index/');

                return;
            } catch (\Magento\Eav\Model\Entity\Attribute\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                $this->_getSession()->setCustomerFormData($originalRequestData);
                $this->_objectManager->get('Psr\Log\LoggerInterface')->critical($e);
                $this->_redirect('vendors/customer/newforcustomer/');
                return;
            } catch (\Exception $e) {
                $this->_getSession()->setCustomerFormData($originalRequestData);

                $this->messageManager->addError(
                    __('Something went wrong while saving the seller data. Please review the error log.')
                );
                $this->_objectManager->get('Psr\Log\LoggerInterface')->critical($e);
                $this->_redirect('vendors/customer/newforcustomer/');
                return;
            }
        }
        $this->_redirect('vendors/index/');
    }
}
