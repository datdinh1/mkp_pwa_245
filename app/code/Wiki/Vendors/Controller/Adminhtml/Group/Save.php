<?php
namespace Wiki\Vendors\Controller\Adminhtml\Group;

use Wiki\Vendors\Controller\Adminhtml\Action;

class Save extends Action
{
    /**
     * Is access to section allowed
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return parent::_isAllowed() && $this->_authorization->isAllowed('Wiki_Vendors::vendors_groups');
    }
    
    
    /**
     * @return void
     */
    public function execute()
    {
        if ($this->getRequest()->getPostValue()) {
            try {
                /** @var \Magento\CatalogRule\Model\Rule $model */
                $model = $this->_objectManager->create('Wiki\Vendors\Model\Group');
                $cache = $this->_objectManager->create('Magento\Framework\App\CacheInterface');
                
                $data = $this->getRequest()->getParams();
                

                $id = $this->getRequest()->getParam('vendor_group_id');
                if ($id) {
                    $model->load($id);
                    if ($id != $model->getId()) {
                        throw new \Exception(__('Wrong group specified.'));
                    }
                }

                $model->addData($data);
        
                $this->_objectManager->get('Magento\Backend\Model\Session')->setGroupData($model->getData());
                $model->save();
                $cache->clean(['vendor_menu']);
                $this->messageManager->addSuccess(__('You saved the seller group.'));
                $this->_objectManager->get('Magento\Backend\Model\Session')->setGroupData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('vendors/*/edit', ['id' => $model->getId()]);
                    return;
                }
                $this->_redirect('vendors/group/');
                
                return;
            } catch (\Exception $e) {
                $this->messageManager->addError(
                    __('Something went wrong while saving the group data. Please review the error log.')
                );
                $this->_objectManager->get('Psr\Log\LoggerInterface')->critical($e);
                $this->_objectManager->get('Magento\Backend\Model\Session')->setGroupData($data);
                $this->_redirect('vendors/*/edit', ['id' => $this->getRequest()->getParam('vendor_group_id')]);
                return;
            }
        }
        $this->_redirect('vendors/*/');
    }
}
