<?php

namespace Wiki\VendorsFaq\Model\ResourceModel;

class Faq extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    public function _construct()
    {
        $this->_init("wiki_faq", "id");
    }
}
