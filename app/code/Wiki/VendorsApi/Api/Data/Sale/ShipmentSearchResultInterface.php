<?php

namespace Wiki\VendorsApi\Api\Data\Sale;


interface ShipmentSearchResultInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * Get attributes list.
     *
     * @return \Wiki\VendorsApi\Api\Data\Sale\ShipmentInterface[]
     */
    public function getItems();

    /**
     * Set attributes list.
     *
     * @param \Wiki\VendorsApi\Api\Data\Sale\ShipmentInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}