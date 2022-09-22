<?php

namespace Wiki\VendorsCoupon\Controller\Vendors\Index;

use Wiki\VendorsCoupon\Api\CouponManagementInterface;
use Magento\SalesRule\Model\Rule;
use Wiki\VendorsSalesRule\Model\SalesRuleManagement;

use Magento\Framework\Controller\ResultFactory;
use Wiki\Vendors\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;

class Delete extends \Wiki\Vendors\Controller\Vendors\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    protected $_aclResource = 'Wiki_VendorsCoupon::coupon_delete';
    
    /**
     * @var Filter
     */
    protected $_filter;

    /**
     * @var Rule
     */
    protected $_saleRule;

    /**
     * @var ResultFactory
     */
    protected $_resultFactory;

    /**
     * @param Context $context
     * @param Filter $filter
     */
    
    public function __construct(
        Context $context,
        Filter $filter,
        Rule $saleRule,
        ResultFactory $resultFactory
    ) {
        $this->_filter = $filter;
        $this->_saleRule = $saleRule;
        $this->_resultFactory = $resultFactory;
        parent::__construct($context);
    }   

    public function execute()
    {
        // getCouponSalesRule
        $id = $this->getRequest()->getParam('id');
        $coupon = $this->_saleRule->load($id);
       if(!$coupon->getId() || $coupon->getCouponBySeller() != $this->_session->getVendor()->getId()){
            $this->messageManager->addError(__("The coupon is not available !"));
            return $this->_redirect('coupon');
        }
        try {
            if ($coupon->getData()) {
                $coupon->delete();
                $this->messageManager->addSuccess(__('The coupon %1 is deleted successfully!', $coupon->getName()));
            }
        } catch (\Exception $e) {
            $this->messageManager->addError($e->getMessage());
        }
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('coupon');
    }
}
