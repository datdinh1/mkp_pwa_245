<?php

namespace Wiki\VendorsApi\Model\Data\Report;

class MostViewedSearchResult extends \Magento\Framework\Api\AbstractExtensibleObject 
implements \Wiki\VendorsApi\Api\Data\Report\MostViewedSearchResultInterface
{
    const TOTAL_COUNT   = 'total_count';
    const ITEMS         = 'items';
    
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
     * @see \Magento\Framework\Api\SearchResultsInterface::getTotalCount()
     */
    public function getTotalCount(){
        return $this->_get(self::TOTAL_COUNT);
    }
    
    /**
     * @see \Magento\Framework\Api\SearchResultsInterface::setTotalCount()
     */
    public function setTotalCount($totalCount){
        return $this->setData(self::TOTAL_COUNT, $totalCount);
    }
    
    /**
     * Set items list.
     *
     * @param \Magento\Framework\Api\ExtensibleDataInterface[] $items
     * @return $this
     */
    public function setItems(array $items = null)
    {
        return $this->setData(self::ITEMS, $items);
    }
    
    /**
     * @return \Wiki\VendorsApi\Api\Data\Report\MostViewedInterface[]
     */
    public function getItems(){
        return $this->_get(self::ITEMS);
    }
}
