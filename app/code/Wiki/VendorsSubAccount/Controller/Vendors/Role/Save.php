<?php
/**
 * Copyright (c) 2017 Wiki Co ltd. All rights reserved.
 */

namespace Wiki\VendorsSubAccount\Controller\Vendors\Role;


class Save extends \Wiki\Vendors\Controller\Vendors\Action
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
     * @var \Magento\Framework\App\CacheInterface
     */
    protected $cache;
    
    /**
     * @param \Wiki\Vendors\App\Action\Context $context
     * @param \Wiki\VendorsSubAccount\Model\RoleFactory $roleFactory
     * @param \Magento\Framework\App\CacheInterface $cache
     */
    public function __construct(
        \Wiki\Vendors\App\Action\Context $context,
        \Wiki\VendorsSubAccount\Model\RoleFactory $roleFactory,
        \Magento\Framework\App\CacheInterface $cache
    )
    {
        $this->roleFactory = $roleFactory;
        $this->cache = $cache;
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
        $roleId = $request->getParam('role_id');
        /* Validate current user*/
        $password = $request->getParam('current_password');
        $user = $this->_vendorsession->getCustomer();
        if(!$user->validatePassword($password)){
            $this->messageManager->addError(__("The current password is not valid"));
            return $this->resultRedirectFactory->create()
                ->setPath('subaccount/role/edit',['role_id' => $roleId]);
        }
        
        try{
            $role = $this->roleFactory->create();
            $role->load($roleId);
            $role->setVendorId($this->_session->getVendor()->getId())
                ->setRoleName($request->getParam('rolename'))
                ->save();
            
            /* Clean vendor menu cache*/
            if($userIds = $role->getAllUserIds()){
                $tags = [];
                foreach($userIds as $userId){
                    $tags[] = 'vendor_menu_'.$userId;
                }
                $this->cache->clean($tags);
            }
            

            /* Update resources*/
            $rootResource = $this->_objectManager->create('Wiki\VendorsAcl\Model\AclResource\RootResource');
            $resources = $request->getParam('all')?[$rootResource->getId()]:$request->getParam('resource');
            $role->updateResources($resources);

            $this->messageManager->addSuccess(__("The role is saved."));
            return $this->resultRedirectFactory->create()->setPath('subaccount/role');
        }catch(\Magento\Framework\Exception\LocalizedException $e){
            $this->messageManager->addError($e->getMessage());
        }catch(\Exception $e){
            $this->_objectManager->get('Psr\Log\LoggerInterface')->critical($e);
            $this->messageManager->addError(__('We can\'t save the role.'));
        }
        return $this->resultRedirectFactory->create()
            ->setPath('subaccount/role/edit',['role_id' => $roleId]);
    }
}
