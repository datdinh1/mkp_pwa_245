<?php
/**
 *
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\Core\Controller\Adminhtml\Licenses;

use Wiki\Core\Controller\Adminhtml\Action;
use Magento\Framework\Exception\LocalizedException;

class Save extends Action
{

    /**
     * @return void
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public function execute()
    {
        if ($this->getRequest()->getPostValue()) {
            /** @var \Wiki\Core\Model\Key $model */
            $model = $this->_objectManager->create('Wiki\Core\Model\Key');
            try {
                $id = $this->getRequest()->getParam('key_id');
                $model->load($id);
                if(!$id || !$model->getKeyId()) throw new LocalizedException(__("The license is required."));
                
                $domainsData = $this->getRequest()->getParam('domains',[]);
                $domains = [];
                foreach($domainsData as $domain){
                    if(isset($domain['delete']) && $domain['delete']) continue;
                    $domains[] = $domain['domain'];
                }
                if(!sizeof($domains)) throw new \Exception(__("Please enter a domain."));
                /*Save the new license info to remote server and return the new information*/
                $licenseInfo = $model->remoteSaveLicenseKey($model->getLicenseKey(), $domains);
                
                $model->setData('license_info', $licenseInfo);                
                $model->save();

                $this->messageManager->addSuccess(__('You saved the license.'));
                
                /*Everytime we save the license, just clear the check lincense data*/
                $this->_auth->getAuthStorage()->setData('Wiki_check_license_data',null);
                
                $this->_redirect('Wiki/*/');
                return;
            } catch (LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
                $this->_redirect('Wiki/*/edit',['id' => $this->getRequest()->getParam('key_id')]);
                return;
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                $this->_redirect('Wiki/*/edit',['id' => $this->getRequest()->getParam('key_id')]);
                return;
            }
        }
        
        $this->_redirect('Wiki/*/');
    }
}
