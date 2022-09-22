<?php

namespace Wiki\VendorsApi\Model\Data\Credit;

/**
 * Class vendor
 * @SuppressWarnings(PHPMD.ExcessivePublicCount)
 */
class WithdrawalSearchResult implements \Wiki\VendorsApi\Api\Data\Credit\WithdrawalSearchResultInterface
{
    /**
     * @var array
     */
    protected $items = [];

    /**
     * @var \Magento\Framework\Api\SearchCriteriaInterface
     */
    protected $searchCriteria;


    /**
     * Get search criteria.
     *
     * @return \Magento\Framework\Api\SearchCriteriaInterface|null
     */
    public function getSearchCriteria()
    {
        return $this->searchCriteria;
    }

    /**
     * Set search criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return $this
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function setSearchCriteria(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria = null)
    {
        $this->searchCriteria = $searchCriteria;
        return $this;
    }

    /**
     * Get total count.
     *
     * @return int
     */
    public function getTotalCount()
    {
        return sizeof($this->items);
    }

    /**
     * Set total count.
     *
     * @param int $totalCount
     * @return $this
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function setTotalCount($totalCount)
    {
        return $this;
    }

    /**
     * @param array|null $items
     * @return $this|\Wiki\VendorsApi\Api\Data\Sale\InvoiceSearchResultInterface
     * @throws \Exception
     */
    public function setItems(array $items = null)
    {
        $this->items = $items;
        return $this;
    }

    /**
     * @return \Wiki\VendorsApi\Api\Data\Sale\InvoiceInterface []
     */
    public function getItems(){
        return $this->items;
    }
}