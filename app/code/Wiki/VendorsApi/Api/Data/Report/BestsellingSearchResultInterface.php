<?php

namespace Wiki\VendorsApi\Api\Data\Report;


interface BestsellingSearchResultInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * Get items.
     *
     * @return \Wiki\VendorsApi\Api\Data\Report\BestsellingInterface[] Array of collection items.
     */
    public function getItems();
    
    /**
     * Set items.
     *
     * @param \Wiki\VendorsApi\Api\Data\Report\BestsellingInterface[] $items
     * @return $this
     */
    public function setItems(array $items = null);
}
