<?php

namespace Wiki\VendorsProduct\Controller\Vendors;

/**
 * Catalog category controller
 */
abstract class Category extends \Wiki\Vendors\Controller\Vendors\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    protected $_aclResource = 'Wiki_Vendors::catalog';
    
    /**
     * Initialize requested category and put it into registry.
     * Root category can be returned, if inappropriate store/category is specified
     *
     * @param bool $getRootInstead
     * @return \Magento\Catalog\Model\Category|false
     */
    protected function _initCategory($getRootInstead = false)
    {
        $categoryId = (int)$this->getRequest()->getParam('id', false);
        $storeId = (int)$this->getRequest()->getParam('store');
        $category = $this->_objectManager->create('Magento\Catalog\Model\Category');
        $category->setStoreId($storeId);

        if ($categoryId) {
            $category->load($categoryId);
            if ($storeId) {
                $rootId = $this->_objectManager->get(
                    'Magento\Store\Model\StoreManagerInterface'
                )->getStore(
                    $storeId
                )->getRootCategoryId();
                if (!in_array($rootId, $category->getPathIds())) {
                    // load root category instead wrong one
                    if ($getRootInstead) {
                        $category->load($rootId);
                    } else {
                        return false;
                    }
                }
            }
        }

        $activeTabId = (string)$this->getRequest()->getParam('active_tab_id');
        if ($activeTabId) {
            $this->_objectManager->get('Magento\Backend\Model\Auth\Session')->setActiveTabId($activeTabId);
        }
        $this->_objectManager->get('Magento\Framework\Registry')->register('category', $category);
        $this->_objectManager->get('Magento\Framework\Registry')->register('current_category', $category);
        $this->_objectManager->get('Magento\Cms\Model\Wysiwyg\Config')
            ->setStoreId($this->getRequest()->getParam('store'));
        return $category;
    }
}
