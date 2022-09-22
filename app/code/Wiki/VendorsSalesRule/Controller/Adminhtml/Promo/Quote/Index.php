<?php

/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Wiki\VendorsSalesRule\Controller\Adminhtml\Promo\Quote;


use Magento\Framework\App\Action\HttpGetActionInterface as HttpGetActionInterface;

class Index extends \Magento\SalesRule\Controller\Adminhtml\Promo\Quote implements HttpGetActionInterface
{

    /** update db salesrule */




    /** end update db salesrule */

    /**
     * Index action
     *
     * @return void
     */
    public function execute()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $objrules = $objectManager->create('Magento\SalesRule\Model\RuleFactory')->create();
        $rules = $objrules->getCollection();
        if ($rules) {
            foreach ($rules as $rule) {
                if($rule->getCategoryId() == 0){
                    $rule->setCategoryId(2);
                    $rule->save();
                }
            }
            // $rule = $objectManager->create('Magento\SalesRule\Model\Rule')->load(34);
            // $isActive = $rule->getIsActive();
        }
        $a = true;

        //         echo $isActive; exit;
        /** update db salesrule */
        // $this->updateCategoryCoupon();
        // exit();
        /** end update db salesrule */
        $this->_initAction()->_addBreadcrumb(__('Catalog'), __('Catalog'));
        $this->_view->getPage()->getConfig()->getTitle()->prepend(__('Cart Price Rules'));
        $this->_view->renderLayout();
    }
}
