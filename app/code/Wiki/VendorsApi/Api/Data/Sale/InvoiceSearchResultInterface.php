<?php

namespace Wiki\VendorsApi\Api\Data\Sale;


interface InvoiceSearchResultInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * Get attributes list.
     *
     * @return \Wiki\VendorsApi\Api\Data\Sale\InvoiceInterface[]
     */
    public function getItems();

    /**
     * Set attributes list.
     *
     * @param \Wiki\VendorsApi\Api\Data\Sale\InvoiceInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
