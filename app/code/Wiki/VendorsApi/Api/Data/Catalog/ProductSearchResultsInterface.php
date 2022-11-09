<?php

namespace Wiki\VendorsApi\Api\Data\Catalog;

/**
 * @api
 * @since 100.0.2
 */
interface ProductSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * Get attributes list.
     *
     * @return \Wiki\VendorsApi\Api\Data\Catalog\ProductInterface[]
     */
    public function getItems();

    /**
     * Set attributes list.
     *
     * @param \Wiki\VendorsApi\Api\Data\Catalog\ProductInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
