<?php 
namespace Wiki\VendorsFollow\Api;

/**
 * @api
 */
interface FollowRepositoryInterface
{
    /**
     * @param int $customerId
     * @param int|null $pageSize
     * @param int|null $currentPage
     * @return \Wiki\VendorsProduct\Api\Data\SellerInterface[]
     */
    public function getFollowVendorByCustomerId($customerId, $pageSize = null, $currentPage = null);

    /**
     * @param int $vendorId
     * @param int|null $pageSize
     * @param int|null $currentPage
     * @return \Wiki\VendorsFollow\Api\Data\CustomerInterface[]
     */
    public function getFollowByVendorId($vendorId, $pageSize = null, $currentPage = null);

    /**
     * @param int $vendorId
     * @param int $customerId
     * @return bool
     */
    public function follow($vendorId, $customerId);

    /**
     * @param int $vendorId
     * @param int $customerId
     * @return bool
     */
    public function unFollow($vendorId, $customerId);
}