<?php

namespace Wiki\VendorsChat\Model;

use Magento\Framework\Model\AbstractModel;

class ChatImage extends AbstractModel
{
    const CACHE_TAG = 'wk_chat_message_image';
    /**
     * Define resource model
     */
    protected function _construct()
    {
        $this->_init('Wiki\VendorsChat\Model\ResourceModel\ChatImage');
    }
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getDefaultValues()
    {
        $values = [];

        return $values;
    }
}
