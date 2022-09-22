<?php
/**
 *
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\Vendors\Controller\Adminhtml\Form\Profile;

use Wiki\Vendors\Controller\Adminhtml\Action;

class Fieldsetsorder extends Action
{
    /**
     * Is access to section allowed
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return parent::_isAllowed() && $this->_authorization->isAllowed('Wiki_Vendors::vendors_form_profile');
    }
    
    /**
     * @return void
     */
    public function execute()
    {
        if ($this->getRequest()->getPostValue()) {
            try {
                $fieldsets = $this->getRequest()->getParam('fieldsets', []);
                
                foreach ($fieldsets as $fieldsetId => $order) {
                    /** @var \Wiki\Vendors\Model\Vendor\Fieldset $model */
                    $model = $this->_objectManager->create('Wiki\Vendors\Model\Vendor\Fieldset');
                    $model->load($fieldsetId);
                    if (!$model->getId()) {
                        continue;
                    }
                    
                    $model->setSortOrder($order);
                    $model->save();
                }
                //$block = $this->_view->getLayout()->createBlock('Wiki\Vendors\Block\Adminhtml\Profile\Form')->setTemplate('Wiki_Vendors::profile/container_ajax.phtml');
                $result = ['success'=>true/* ,'form_html'=>$block->toHtml() */];
            } catch (\Exception $e) {
                $result = ['success'=>false,'err_msg'=>__('Something went wrong while saving the form data.<br />'.$e->getMessage())];
                $this->_objectManager->get('Psr\Log\LoggerInterface')->critical($e);
            }
        } else {
            $result = ['success'=>false,'err_msg'=>__('The post data is not valid.')];
        }
        
        $this->getResponse()->setBody(json_encode($result));
    }
}
