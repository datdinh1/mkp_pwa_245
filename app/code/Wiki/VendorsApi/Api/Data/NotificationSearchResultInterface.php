<?php

namespace Wiki\VendorsApi\Api\Data;


interface NotificationSearchResultInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * Get items.
     *
     * @return \Wiki\VendorsApi\Api\Data\NotificationInterface[] Array of collection items.
     */
    public function getItems();
    
    /**
     * Set items.
     *
     * @param \Wiki\VendorsApi\Api\Data\NotificationInterface[] $items
     * @return $this
     */
    public function setItems(array $items = null);
}
