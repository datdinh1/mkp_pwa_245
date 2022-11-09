<?php
/**
 *
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\Vendors\Controller\Adminhtml\Form\Profile;

use Wiki\Vendors\Controller\Adminhtml\Action;

class Deletefieldset extends Action
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
     * Get fieldset block.
     */
    public function getFieldsetBlock()
    {
        return $this->_view->getLayout()->createBlock('Wiki\Vendors\Block\Adminhtml\Profile\Form')
            ->setTemplate('Wiki_Vendors::profile/container_ajax.phtml');
    }
    /**
     * @return void
     */
    public function execute()
    {
        if ($this->getRequest()->getPostValue()) {
            try {
                /** @var \Magento\CatalogRule\Model\Rule $model */
                $model = $this->_objectManager->create('Wiki\Vendors\Model\Vendor\Fieldset');
        
        
                $id = $this->getRequest()->getParam('fieldset');
                if (!$id) {
                    throw new \Exception(__('Wrong fieldset specified.'));
                }
        
                $model->setId($id);
                
                $model->delete();
        
                $block = $this->getFieldsetBlock();
                $result = ['success'=>true,'form_html'=>$block->toHtml()];
            } catch (\Exception $e) {
                $result = ['success'=>false,'err_msg'=>__('Something went wrong while saving the group data. Please review the error log.')];
                $this->_objectManager->get('Psr\Log\LoggerInterface')->critical($e);
                return;
            }
        } else {
            $result = ['success'=>false,'err_msg'=>__('The post data is not valid.')];
        }
        
        $this->getResponse()->setBody(json_encode($result));
    }
}
