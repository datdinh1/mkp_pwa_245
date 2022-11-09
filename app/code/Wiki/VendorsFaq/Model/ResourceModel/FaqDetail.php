<?php

namespace Wiki\VendorsFaq\Model\ResourceModel;

class FaqDetail extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    public function _construct()
    {
        $this->_init("Wiki_faq_detail", "id");
    }
}
