<?php

namespace Wiki\VendorsCoupon\Controller\Vendors\Index;

use Wiki\VendorsSalesRule\Api\Data\RuleInterface;
use Wiki\VendorsCoupon\Api\CouponManagementInterface;
use Wiki\VendorsSalesRule\Model\SalesRuleManagement;
use Wiki\Vendors\App\Action\Context;
use Wiki\VendorsSalesRule\Model\Api\Rule;
use Magento\Framework\Controller\ResultFactory;
use Magento\Ui\Component\MassAction\Filter;
class Save extends \Wiki\Vendors\Controller\Vendors\Action
{
    
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    protected $_aclResource = 'Wiki_VendorsCoupon::coupon_save';
    /**
     * @var SalesRuleManagement
     */
    protected $_salesRuleManagement;

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
        SalesRuleManagement $salesRuleManagement,
        Rule $saleRule,
        ResultFactory $resultFactory
    ) {
        $this->_salesRuleManagement = $salesRuleManagement;
        $this->_saleRule = $saleRule;
        $this->_resultFactory = $resultFactory;
        parent::__construct($context);
    }   
    public function execute()
    {
        $data = $this->getRequest()->getParams();
        $rule = $this->_saleRule->setData($data);
        $rule->setListSku(null);
        $rule->setVendorId($this->_session->getVendor()->getId());
        if(!$this->getRequest()->getParam(self::CHECKDISCOUNTLIMIT)){
            $rule->setMaxDiscountAmount(0);
        }
        if(!empty($_FILES['image']['name'])){
            $rule->setImage($_FILES['image']); 
        }
        (!empty($data[RuleInterface::IS_DISPLAY_ALL])) ? $rule->setShowAllpage(1) : $rule->setShowAllpage(0); 
        // $salesRuleManagement = $this->_objectManager->get('Wiki\VendorsSalesRule\Model\SalesRuleManagement');
        try {
            if(!$this->getRequest()->getParam('id')){
                if($this->_salesRuleManagement->createCouponSalesRule($rule)){
                    $this->messageManager->addSuccess(__('%1 coupon(s) have been generated.', $data[RuleInterface::NAME]));
                }
            }else{
            // Edit coupon
                if($this->_salesRuleManagement->updateCouponSalesRule($data['id'], $rule)){
                    $this->messageManager->addSuccess(__('%1 coupon(s) have been edit success.', $data[RuleInterface::NAME]));
                }
            }
        } catch (\Throwable $th) {
            $this->messageManager->addError(__('Save %1 coupon(s) have been faild.', $data[RuleInterface::NAME]));
        }
        // Create coupon
       
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('coupon');
    }
}
