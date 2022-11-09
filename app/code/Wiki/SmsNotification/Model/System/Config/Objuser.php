<?php

namespace Wiki\SmsNotification\Model\System\Config;

use Magento\Framework\Option\ArrayInterface;

class Objuser implements ArrayInterface
{
    const ALL  = 0;
    const CUSTOMER = 1;
    const SELLER = 2;

    /**
     * @return array
     */
    public function toOptionArray()
    {
        $options = [
            self::ALL => __('Customer and Seller'),
            self::CUSTOMER => __('Customer'),
            self::SELLER => __('Seller')
        ];

        return $options;
    }
}