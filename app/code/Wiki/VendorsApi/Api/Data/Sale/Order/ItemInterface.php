<?php

namespace Wiki\VendorsApi\Api\Data\Sale\Order;

interface ItemInterface extends \Magento\Sales\Api\Data\OrderItemInterface
{
    /*
     * Thumbnail
     */
    const THUMBNAIL = 'thumbnail';
    
    /**
     * Get Thumbnail
     *
     * @return string|null
     */
    public function getThumbnail();
    
    /**
     * Get items options
     * @return \Wiki\VendorsApi\Api\Data\Sale\Order\ItemOptionInterface[]
     */
    public function getItemOptions();
}
