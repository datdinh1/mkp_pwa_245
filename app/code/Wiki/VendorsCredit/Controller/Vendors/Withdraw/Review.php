<?php

namespace Wiki\VendorsCredit\Controller\Vendors\Withdraw;

class Review extends \Wiki\Vendors\Controller\Vendors\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    protected $_aclResource = 'Wiki_VendorsCredit::credit_withdraw';
    
    /**
     * @var \Wiki\VendorsCredit\Helper\Data
     */
    protected $helper;
    
    /**
     * @var \Wiki\Credit\Model\CreditFactory
     */
    protected $_creditFactory;
    
    /**
     * @param \Wiki\Vendors\App\Action\Context $context
     * @param \Wiki\VendorsCredit\Helper\Data $helper
     * @param \Wiki\Credit\Model\CreditFactory $creditAccountFactory
     */
    public function __construct(
        \Wiki\Vendors\App\Action\Context $context,
        \Wiki\VendorsCredit\Helper\Data $helper,
        \Wiki\Credit\Model\CreditFactory $creditAccountFactory
    ) {
        parent::__construct($context);
        $this->helper = $helper;
        $this->_creditFactory = $creditAccountFactory;
    }

    
    /**
     * @return void
     */
    public function execute()
    {
        $params  = $this->_session->getWithdrawalParams();
        try {
            if (!isset($params['method']) || !isset($params['amount'])) {
                throw new \Exception(__('The params is not valid.'));
            }
            
            $methodCode = $params['method'];
            $availableMethods = $this->helper->getWithdrawalMethods();
            $method = $availableMethods[$methodCode];

            $this->_coreRegistry->register('current_method', $method);
            $this->_coreRegistry->register('withdrawal_method', $method);
            $this->_coreRegistry->register('amount', $params['amount']);
            $this->_coreRegistry->register('step', 'review');
            
            $this->_initAction();
            $title = $this->_view->getPage()->getConfig()->getTitle();
            $title->prepend(__("Credit"));
            $title->prepend(__("Withdraw Funds"));
            $title->prepend(__("Review"));
            $this->_view->renderLayout();
        } catch (\Exception $e) {
            $this->messageManager->addError($e->getMessage());
            return $this->_redirect('*/*');
        }
    }
}
