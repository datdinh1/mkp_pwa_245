<?php
/**
 * Copyright (c) 2017 Wiki Co ltd. All rights reserved.
 */

namespace Wiki\VendorsSubAccount\Controller\Vendors\Role;

class Delete extends \Wiki\Vendors\Controller\Vendors\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    protected $_aclResource = 'Wiki_VendorsQuotation::subaccount_role';
    
    /**
     * @var \Wiki\VendorsSubAccount\Model\RoleFactory
     */
    protected $roleFactory;

    /**
     * @param \Wiki\Vendors\App\Action\Context $context
     * @param \Wiki\VendorsSubAccount\Model\RoleFactory $roleFactory
     */
    public function __construct(
        \Wiki\Vendors\App\Action\Context $context,
        \Wiki\VendorsSubAccount\Model\RoleFactory $roleFactory
    )
    {
        $this->roleFactory = $roleFactory;
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
            $role = $this->roleFactory->create();
            $role->setId($this->getRequest()->getParam('role_id'))->delete();

            $this->messageManager->addSuccess(__("The role is deleted."));
            return $this->resultRedirectFactory->create()->setPath('subaccount/role');
        }catch(\Magento\Framework\Exception\LocalizedException $e){
            $this->messageManager->addError($e->getMessage());
        }catch(\Exception $e){
            $this->_objectManager->get('Psr\Log\LoggerInterface')->critical($e);
            $this->messageManager->addError(__('We can\'t delete the role.'));
        }
        
        return $this->resultRedirectFactory->create()
            ->setPath('subaccount/role');
    }
}
