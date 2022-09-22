<?php

/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Wiki\Vendors\Api;

use Magento\Framework\Exception\InputException;

/**
 * Interface for managing customers accounts.
 * @api
 * @since 100.0.2
 */
interface SellerManagementInterface
{
    /**
     * @return mixed
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getStoreConfig();

    /**
     * Check if given email is associated with a customer account in given website.
     * @param string $username
     * @param string $password If not set, will use the current websiteId
     * @return bool
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function loginSeller($username, $password);

    /**
     * Create customer account. Perform necessary business operations like sending email.
     * @param \Wiki\Vendors\Api\Data\AccountEmailInterface $customer
     * @return \Magento\Customer\Api\Data\CustomerInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Exception
     */
    public function createSeller($customer);

    /**
     * @return \Wiki\Vendors\Api\SellerManagementInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getAuctionProduct();

    /**
     * @param string $vendorId 
     * @param string $cover_image
     * @param string $logo
     * @param string $store_name
     * @param string $store_detail
     * @param \Wiki\Vendors\Api\Data\BannerInterface[] $banners  
     * @param int[] $deleteBanners
     * @return \Wiki\Vendors\Api\SellerManagementInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function updateDataMyStore($vendorId, $cover_image, $logo, $store_name, $store_detail,$banners = NULL,$deleteBanners = NULL);

    /**
     * @param string $vendorId
     * @return bool
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function noviceSeller($vendorId);

    /**
     * @param mixed $data
     * @return \Wiki\Vendors\Api\SellerManagementInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function searchProductID($data);

    /**
     * @param mixed $data
     * @param string $categoryID
     * @return \Wiki\Vendors\Api\SellerManagementInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function addProductToCategory($data, $categoryID);

    /**
     * @param mixed $data
     * @return \Wiki\Vendors\Api\SellerManagementInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function searchProductManagement($data);

    /**
     * Create customer account. Perform necessary business operations like sending email.
     * @param string $mobile
     * @param int $otp
     * @return bool
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function checkOtpOfAccountMobile($mobile, $otp);

    /**
     * @param int $customer_id
     * @param int $product_id
     * @param string $vendor_id
     * @return \Wiki\Vendors\Api\Data\SellerInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getInfoVendor($customer_id = null, $product_id = null, $vendor_id = null);

    /**
     * @param string $vendorId
     * @param int|null $pageSize
     * @param int|null $currentPage
     * @return \Magento\Catalog\Api\Data\ProductInterface[]
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getItemsByVendorId($vendorId, $pageSize = null, $currentPage = null);

    /**
     * @param string $vendorId
     * @param string|null $status
     * @param int|null $pageSize
     * @param int|null $currentPage
     * @return \Wiki\Vendors\Api\Data\OrdersSellerInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getBuyerOrderOfVendorId($vendorId, $status = null, $pageSize = null, $currentPage = null);

    /**
     * @param string $vendorId
     * @param string|null $status
     * @param int|null $pageSize
     * @param int|null $currentPage
     * @return \Wiki\Vendors\Api\Data\OrdersSellerInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getSellerOrderOfVendorId($vendorId, $status = null, $pageSize = null, $currentPage = null);

    /**
     * @param string $namestore
     * @return \Wiki\Vendors\Api\Data\SellerInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getDataAccount($namestore);

    /**
     * @param string $id
     * @param string $type
     * @return \Wiki\Vendors\Api\Data\CountOrderByStatusInterface[]
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function countOrdersByStatus($id, $type);
}
