<?php

namespace Wiki\VendorsApi\Api\Data\Credit;


interface TransactionSearchResultInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * Get items.
     *
     * @return \Wiki\VendorsApi\Api\Data\Credit\TransactionInterface[] Array of collection items.
     */
    public function getItems();
    
    /**
     * Set items.
     *
     * @param \Wiki\VendorsApi\Api\Data\Credit\TransactionInterface[] $items
     * @return $this
     */
    public function setItems(array $items = null);
}
