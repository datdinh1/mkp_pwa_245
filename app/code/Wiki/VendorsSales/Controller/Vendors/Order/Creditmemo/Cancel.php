<?php

namespace Wiki\VendorsSales\Controller\Vendors\Order\Creditmemo;

class Cancel extends \Wiki\Vendors\App\AbstractAction
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    protected $_aclResource = 'Wiki_VendorsSales::sales_creditmemo';
    
    /**
     * @var \Magento\Backend\Model\View\Result\ForwardFactory
     */
    protected $resultForwardFactory;

    /**
     * @param \Wiki\Vendors\App\Action\Context $context,
     * @param \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory
     */
    public function __construct(
        \Wiki\Vendors\App\Action\Context $context,
        \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory
    ) {
        $this->resultForwardFactory = $resultForwardFactory;
        parent::__construct($context);
    }

    /**
     * Cancel creditmemo action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect|\Magento\Backend\Model\View\Result\Forward
     */
    public function execute()
    {
        $creditmemoId = $this->getRequest()->getParam('creditmemo_id');
        if ($creditmemoId) {
            try {
                $creditmemoManagement = $this->_objectManager->create(
                    'Magento\Sales\Api\CreditmemoManagementInterface'
                );
                $creditmemoManagement->cancel($creditmemoId);
                $this->messageManager->addSuccessMessage(__('The credit memo has been canceled.'));
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__('Credit memo has not been canceled.'));
            }
            $resultRedirect = $this->resultRedirectFactory->create();
            $resultRedirect->setPath('sales/*/view', ['creditmemo_id' => $creditmemoId]);
            return $resultRedirect;
        } else {
            $resultForward = $this->resultForwardFactory->create();
            $resultForward->forward('noroute');
            return $resultForward;
        }
    }
}
