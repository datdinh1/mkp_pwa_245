<?php

namespace Wiki\VendorsSales\Controller\Vendors\Order\Invoice;

use Magento\Framework\View\Result\PageFactory;
use Wiki\Vendors\App\Action\Context;
use Magento\Framework\Registry;

class View extends \Wiki\VendorsSales\Controller\Vendors\Invoice\AbstractInvoice\View
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    protected $_aclResource = 'Wiki_VendorsSales::sales_invoices';
    
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory,
        PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context, $resultForwardFactory);
    }

    /**
     * Invoice information page
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $invoice = $this->getInvoice();
        if (!$invoice) {
            /** @var \Magento\Framework\Controller\Result\Forward $resultForward */
            $resultForward = $this->resultForwardFactory->create();
            return $resultForward->forward('noroute');
        }

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $this->setActiveMenu('Wiki_VendorsSales::sales_invoices');
//         $resultPage->setActiveMenu('Wiki_VendorsSales::sales_orders');
        $resultPage->getConfig()->getTitle()->prepend(__('Invoices'));
        $resultPage->getConfig()->getTitle()->prepend(sprintf("#%s", $invoice->getIncrementId()));
        $resultPage->getLayout()->getBlock(
            'sales_invoice_view'
        )->updateBackButtonUrl(
            $this->getRequest()->getParam('come_from')
        );
        return $resultPage;
    }
}
