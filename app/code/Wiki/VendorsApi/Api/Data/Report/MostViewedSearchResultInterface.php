<?php

namespace Wiki\VendorsApi\Api\Data\Report;


interface MostViewedSearchResultInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * Get items.
     *
     * @return \Wiki\VendorsApi\Api\Data\Report\MostViewedInterface[] Array of collection items.
     */
    public function getItems();
    
    /**
     * Set items.
     *
     * @param \Wiki\VendorsApi\Api\Data\Report\MostViewedInterface[] $items
     * @return $this
     */
    public function setItems(array $items = null);
}
