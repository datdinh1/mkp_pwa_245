<?php

namespace Wiki\VendorsApi\Api\Data\Credit;


interface WithdrawalSearchResultInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * Get attributes list.
     *
     * @return \Wiki\VendorsApi\Api\Data\Credit\WithdrawalInterface[]
     */
    public function getItems();

    /**
     * Set attributes list.
     *
     * @param \Wiki\VendorsApi\Api\Data\Credit\WithdrawalInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}