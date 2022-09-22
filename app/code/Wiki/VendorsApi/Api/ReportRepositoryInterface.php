<?php

namespace Wiki\VendorsApi\Api;

/**
 * Vendor CRUD interface.
 * @api
 */
interface ReportRepositoryInterface
{
    /**
     * @param int $customerId
     * @param int $limit
     * @return \Wiki\VendorsApi\Api\Data\Report\BestsellingSearchResultInterface
     */
    public function getBestSelling($customerId, $limit = 5);
    
    /**
     * @param int $customerId
     * @param int $limit
     * @return \Wiki\VendorsApi\Api\Data\Report\MostViewedSearchResultInterface
     */
    public function getMostViewed($customerId, $limit = 5);
    
}
