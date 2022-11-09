<?php 
namespace Wiki\VendorsCustomerAccount\Api;

/**
 * @api
 */
interface BlockRepositoryInterface
{
    /**
     * @param int $vendorId
     * @param int $customerId
     * @return bool
     */
    public function checkStatus($vendorId, $customerId);
    
    /**
     * @param int $vendorId
     * @param int|null $pageSize
     * @param int|null $currentPage
     * @return \Wiki\VendorsFollow\Api\Data\CustomerInterface[]
     */
    public function getBlockedCustomers($vendorId, $pageSize = null, $currentPage = null);

    /**
     * @param int $customerId
     * @param int|null $pageSize
     * @param int|null $currentPage
     * @return \Wiki\VendorsProduct\Api\Data\SellerInterface[]
     */
    public function getBlockedVendors($customerId, $pageSize = null, $currentPage = null);

    /**
     * @param int $vendorId
     * @param int $customerId
     * @return string
     */
    public function blockCustomers($vendorId, $customerId);

    /**
     * @param int $vendorId
     * @param int $customerId
     * @return string
     */
    public function unBlockCustomers($vendorId, $customerId);

    /**
     * @param int $vendorId
     * @param int $customerId
     * @return string
     */
    public function blockVendors($vendorId, $customerId);

    /**
     * @param int $vendorId
     * @param int $customerId
     * @return string
     */
    public function unBlockVendors($vendorId, $customerId);
}