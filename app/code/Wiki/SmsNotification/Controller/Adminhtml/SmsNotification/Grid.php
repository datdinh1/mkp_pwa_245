<?php

namespace Wiki\SmsNotification\Controller\Adminhtml\SmsNotification;

use Wiki\SmsNotification\Controller\Adminhtml\SmsNotification;

class Grid extends SmsNotification
{
   /**
     * @return void
     */
   public function execute()
   {
      return $this->_resultPageFactory->create();
   }
}