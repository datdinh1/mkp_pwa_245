<?php

namespace Wiki\SmsNotification\Controller\Adminhtml\SmsNotification;

use Wiki\SmsNotification\Controller\Adminhtml\SmsNotification;

class NewAction extends SmsNotification
{
   /**
     * Create new news action
     *
     * @return void
     */
   public function execute()
   {
      $this->_forward('edit');
   }
}