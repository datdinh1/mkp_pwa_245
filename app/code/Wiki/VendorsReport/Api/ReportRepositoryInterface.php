<?php

/**
 * 
 * Wiki-Solution
 *
 */

namespace Wiki\VendorsReport\Api;


/**
 * Class Report Interface
 * @package Wiki\VendorsReport\Api
 */
interface ReportRepositoryInterface
{
    /**
     * @param string $namestore
     * @param string $from
     * @param string $to
     * @return \Wiki\VendorsReport\Api\ReportRepositoryInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getOrder($namestore, $from, $to);

    /**
     * @param string $namestore
     * @param string $from
     * @param string $to
     * @return \Wiki\VendorsReport\Api\ReportRepositoryInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getNewCustomer($namestore, $from, $to);

    /**
     * @param string $namestore
     * @return \Wiki\VendorsReport\Api\ReportRepositoryInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getProductRatingsByQty($namestore);

    /**
     * @param string $namestore
     * @return \Wiki\VendorsReport\Api\ReportRepositoryInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getProductRatingsByOrder($namestore);

    /**
     * @param int $productId
     * @param int $customerId
     * @param int $storeId
     * @return \Wiki\VendorsReport\Api\ReportRepositoryInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function setProductViews($productId, $customerId, $storeId);

    /**
     * @param int $productId
     * @return \Wiki\VendorsReport\Api\ReportRepositoryInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getProductCountViews($productId);

    /**
     * @param string $from
     * @param string $to
     * @param string $period
     * @param string $namestore
     * @return \Wiki\VendorsReport\Api\ReportRepositoryInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getDataOrderReport($from, $to, $period, $namestore);

    /**
     * @param string $from
     * @param string $to
     * @param string  $vendorID
     * @param string|null $status
     * @return string
     * @throws \Exception
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function exportSalesSeller($vendorID, $from = null, $to = null, $status = null);

    /**
     * @param string  $vendorId
     * @param string  $date example: '2021-08'
     * @param int  $limit 0 < limit < 25
     * @return Wiki\VendorsReport\Api\Data\ReportStoreInterface
     * @throws \Exception
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function reportStore($vendorId, $date, $limit = null);

    /**
     * @param string  $vendorId
     * @param string $from "2021-12-01"
     * @param string $to "2021-12-20"
   
     * @return string
     * @throws \Exception
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function exportSellerOverView($vendorId, $from = null, $to = null);

       /**
     * @param string  $vendorId
     * @param string  $date example: '2021-08'
     * @param int  $limit 0 < limit < 25
     * @return Wiki\VendorsReport\Api\Data\ReportStoreInterface
     * @throws \Exception
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function reportStoreProduct($vendorId, $date, $limit = null);
    
}
