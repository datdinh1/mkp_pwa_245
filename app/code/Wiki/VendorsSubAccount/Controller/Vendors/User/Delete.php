<?php
/**
 * Copyright (c) 2017 Wiki Co ltd. All rights reserved.
 */

namespace Wiki\VendorsSubAccount\Controller\Vendors\User;

use Magento\Customer\Api\CustomerRepositoryInterface;

class Delete extends \Wiki\Vendors\Controller\Vendors\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    protected $_aclResource = 'Wiki_VendorsQuotation::subaccount_user';
    
    /**
     * @var CustomerRepositoryInterface
     */
    protected $customerRepository;

    /**
     * @param \Wiki\Vendors\App\Action\Context $context
     * @param \Wiki\VendorsSubAccount\Model\RoleFactory $roleFactory
     */
    public function __construct(
        \Wiki\Vendors\App\Action\Context $context,
        CustomerRepositoryInterface $customerRepository
    )
    {
        $this->customerRepository = $customerRepository;
        parent::__construct($context);
    }

    /**
     * Index action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        try{
            $userId = $this->getRequest()->getParam('user_id');
            $resource = $this->_objectManager->create('Wiki\VendorsSubAccount\Model\ResourceModel\User');
            if($resource->isSupserUser($userId)){
                throw new \Magento\Framework\Exception\LocalizedException(__("You can not delete the super user."));
            }
            $this->customerRepository->deleteById($userId);
            $this->messageManager->addSuccess(__('You deleted the user.'));
        }catch(\Magento\Framework\Exception\LocalizedException $e){
            $this->messageManager->addError($e->getMessage());
        }catch(\Exception $e){
            $this->_objectManager->get('Psr\Log\LoggerInterface')->critical($e);
            $this->messageManager->addError(__('We can\'t delete the user.'));
        }
        
        return $this->resultRedirectFactory->create()
            ->setPath('subaccount/user');
    }
}
