<?php

namespace Wiki\VendorsNotification\Controller\Vendors\Index;

class View extends \Wiki\Vendors\Controller\Vendors\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    protected $_aclResource = 'Wiki_Vendors::notifications';
    
    /**
     * @return void
     */
    public function execute()
    {
        $notification = $this->_objectManager->create('Wiki\VendorsNotification\Model\Notification');
        $notification->load($this->getRequest()->getParam('id'));
        
        if (!$notification->getId()) {
            $this->messageManager->addError(__("The notification is not exist !"));
            return $this->_redirect('dashboard');
        }
        /* Mark the notification as read */
        if (!$notification->getData('is_read')) {
            $notification->setData('is_read', 1)->save();
        }
        /* Redirect to the destimation URL*/
        $this->_redirectUrl($notification->getNotificationType()->getUrl());
    }
}
