<?php
/**
 *
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\VendorsProduct\Controller\Adminhtml\Catalog\Product\Set;

class Edit extends \Wiki\VendorsProduct\Controller\Adminhtml\Catalog\Product\Set
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        parent::__construct($context, $coreRegistry);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * Is access to section allowed
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return parent::_isAllowed() && $this->_authorization->isAllowed('Wiki_VendorsProduct::catalog_product_form');
    }
    
    /**
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        $this->_setTypeId();
        $attributeSet = $this->_objectManager->create('Magento\Eav\Model\Entity\Attribute\Set')
            ->load($this->getRequest()->getParam('id'));

        if (!$attributeSet->getId()) {
            return $this->resultRedirectFactory->create()->setPath('catalog/*/index');
        }

        $this->_coreRegistry->register('current_attribute_set', $attributeSet);

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Magento_Catalog::catalog_attributes_sets');
        $resultPage->getConfig()->getTitle()->prepend(__('Attribute Sets'));
        $resultPage->getConfig()->getTitle()->prepend(
            $attributeSet->getId() ? $attributeSet->getAttributeSetName() : __('New Set')
        );
        $resultPage->addBreadcrumb(__('Catalog'), __('Catalog'));
        $resultPage->addBreadcrumb(__('Manage Product Sets'), __('Manage Product Sets'));
        return $resultPage;
    }
}
