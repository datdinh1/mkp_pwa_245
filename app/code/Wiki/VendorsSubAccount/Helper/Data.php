<?php

namespace Wiki\VendorsSubAccount\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    const XML_SUB_ACCOUNT_EMAIL_SENDER                          = 'vendors/subaccount/sender_email_identity';
    const XML_SUB_ACCOUNT_EMAIL                                 = 'vendors/subaccount/subaccount_email_user';

    const XML_PATH_VENDOR_SUBACCOUNT                            = 'subaccount/enable_subaccount';
    const XML_PATH_VENDOR_SUBACCOUNT_LIMITATION                 = 'subaccount/subaccount_limit';

    /**
     * @var \Wiki\VendorsSubAccount\Model\ResourceModel\User
     */
    protected $resource;
    
    /**
     * @var \Wiki\VendorsSubAccount\Model\RoleFactory
     */
    protected $roleFactory;
    
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Wiki\Vendors\Helper\Email $emailHelper,
        \Wiki\VendorsSubAccount\Model\ResourceModel\User $resource,
        \Wiki\VendorsSubAccount\Model\RoleFactory $roleFactory
    ) {
        $this->resource = $resource;
        $this->_emailHelper = $emailHelper;
        $this->roleFactory = $roleFactory;
        parent::__construct($context);
    }
    
    /**
     * Check vendor permission
     * 
     * @param \Wiki\Vendors\Model\Vendor $vendor
     * @param string $resource
     * @return boolean
     */
    public function checkPermission(
        \Wiki\Vendors\Model\Vendor $vendor,
        $resource = ''
    ) {
        $userData = $this->resource->getUserData($vendor->getCustomer()->getId());
        if($userData['is_super_user']) return true;
        $role = $this->roleFactory->create()->load($userData['role_id']);

        return $role->checkPermission($resource);
    }

    public function sendMailToSubAccount(
        $email,
        \Wiki\Vendors\Model\Vendor $vendor
    ) {
        try {
            $this->_emailHelper->sendTransactionEmail(
                self::XML_SUB_ACCOUNT_EMAIL,
                \Magento\Framework\App\Area::AREA_FRONTEND,
                self::XML_SUB_ACCOUNT_EMAIL_SENDER,
                $email,
                ['vendor' => $vendor]
            );
        } catch (\Exception $e) {
        }
    }
}