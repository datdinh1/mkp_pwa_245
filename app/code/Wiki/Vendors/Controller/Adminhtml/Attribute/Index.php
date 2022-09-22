<?php
/**
 *
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\Vendors\Controller\Adminhtml\Attribute;

class Index extends \Wiki\Vendors\Controller\Adminhtml\Attribute
{
    /**
     * Is access to section allowed
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return parent::_isAllowed() && $this->_authorization->isAllowed('Wiki_Vendors::vendors_attributes');
    }

    /**
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Wiki_Vendors::vendors_attributes');
        $resultPage->getConfig()->getTitle()->prepend(__('Seller Attributes'));
        $resultPage->addContent(
            $resultPage->getLayout()->createBlock('Wiki\Vendors\Block\Adminhtml\Attribute')
        );
        return $resultPage;
    }
}
