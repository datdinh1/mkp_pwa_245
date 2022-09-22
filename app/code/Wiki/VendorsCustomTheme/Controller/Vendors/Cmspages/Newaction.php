<?php
/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\VendorsCustomTheme\Controller\Vendors\Cmspages;

use Magento\Framework\App\Action\HttpGetActionInterface;

/**
 * Create CMS page action.
 */
class NewAction extends \Wiki\Vendors\Controller\Vendors\Action implements HttpGetActionInterface
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Wiki_Vendors::page_action_save';

     /**
     * @var \Magento\Backend\Model\View\Result\Forward
     */
    protected $resultForwardFactory;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    protected $_storeManager;

    public function __construct(
        \Wiki\Vendors\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory
        
    ) {  
         $this->resultPageFactory = $resultPageFactory;
         $this->_storeManager = $storeManager; 
         $this->resultForwardFactory = $resultForwardFactory;
        parent::__construct($context);
    }

    /**
     * Forward to edit
     *
     * @return \Magento\Backend\Model\View\Result\Forward
     */
    public function execute()
    {
       
        // $resultPage = $this->resultPageFactory->create();
        // // $store_id = $this->_storeManager->getStore()->getId();
        // // echo $store_id;
        // return $resultPage;
        // /** @var \Magento\Backend\Model\View\Result\Forward $resultForward */
        // $resultForward = $this->resultForwardFactory->create();
        // return $resultForward->forward('edit');

        // $resultForward = $this->resultForwardFactory->create();
        //  return $resultForward->forward('edit');
    }
}
