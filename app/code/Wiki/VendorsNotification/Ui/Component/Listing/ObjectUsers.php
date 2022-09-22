<?php
namespace Wiki\VendorsNotification\Ui\Component\Listing;

use Wiki\VendorsNotification\Model\Notification;

class ObjectUsers implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * Options getter
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => Notification::NOTIFYCATION_ALL,      'label' => __('Sellers and Customers')],
            ['value' => Notification::NOTIFYCATION_CUSTOMER, 'label' => __('Customers')],
            ['value' => Notification::NOTIFYCATION_VENDOR,   'label' => __('Sellers')],
        ];
    }

    /**
     * Get options in "key-value" format
     * @return array
     */
    public function toArray()
    {
       return [
            Notification::NOTIFYCATION_ALL       => __('Sellers and Customers'),
            Notification::NOTIFYCATION_CUSTOMER  => __('Customers'),
            Notification::NOTIFYCATION_VENDOR    => __('Sellers'),
        ];
    }
}