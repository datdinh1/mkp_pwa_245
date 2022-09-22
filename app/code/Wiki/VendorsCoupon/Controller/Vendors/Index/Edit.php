<?php

namespace Wiki\VendorsCoupon\Controller\Vendors\Index;

class Edit extends \Wiki\Vendors\Controller\Vendors\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    protected $_aclResource = 'Wiki_VendorsCoupon::coupon';
    
    /**
     * @return void
     */
    public function execute()
    {
        $coupon = $this->_objectManager->create('Magento\SalesRule\Model\Rule');
        $coupon->load($this->getRequest()->getParam('id'));
        
        if(!$coupon->getId() || $coupon->getCouponBySeller() != $this->_session->getVendor()->getId()){
            $this->messageManager->addError(__("The coupon is not available !"));
            return $this->_redirect('coupon');
        }
        
        $this->_coreRegistry->register('current_coupon', $coupon);
        $this->_coreRegistry->register('coupon', $coupon);
        $this->_initAction();
        $title = $this->_view->getPage()->getConfig()->getTitle();
        $title->prepend(__("Edit Coupons"));
       
        $this->_view->renderLayout();

    }
}
