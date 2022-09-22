<?php

/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Wiki\VendorsSales\Api;

use Magento\Framework\Exception\InputException;

/**
 * Interface for managing customers accounts.
 * @api
 * @since 100.0.2
 */
interface SalesManagementInterface
{
   /**
   * @return boolean
   * @throws \Magento\Framework\Exception\LocalizedException
   */
  public function updateIncrement();

  /**
   * @param int $order_id
   * @param  string $status
   * @return boolean
   * @throws \Magento\Framework\Exception\LocalizedException
   */
  public function updateStatusOrder($order_id, $status);

  /**
   * @return \Wiki\VendorsSales\Api\SalesManagementInterface
   * @throws \Magento\Framework\Exception\LocalizedException
   */
  public function getConfig();

  /**
   * @param mixed $products list items
   * @param string $vendor_id
   * @param string $coupon
   * @param int $customer_id
   * @return boolean
   */
  public function checkCoupon($products, $vendor_id, $coupon, $customer_id);


  /**
   * @param \Wiki\VendorsSales\Api\Data\ApplyCouponBySellerInterface[] $productsByShop
   * @param int $customerId
   * @param string $mkpCoupon
   * @return \Wiki\VendorsSales\Api\Data\Total\GrandTotalsInterface[];
   */
  public function applyCoupon($productsByShop, $customerId, $mkpCoupon);

  /**
   * @param string $namestore
   * @param string $token
   * @return \Magento\Sales\Api\Data\OrderInterface 
   * @throws \Magento\Framework\Exception\LocalizedException
   */
  public function getOrderByVendor($namestore, $token);

  /**
   * @param string $namestore
   * @return \Magento\Sales\Api\Data\InvoiceSearchResultInterface Invoice search result interface.
   * @throws \Magento\Framework\Exception\LocalizedException
   */
  public function getListInvoiceByVendor($namestore);


  /**
   * @param string $namestore
   * @return \Wiki\VendorsSales\Api\SalesManagementInterface
   * @throws \Magento\Framework\Exception\LocalizedException
   */
  public function getListShipmentByVendor($namestore);



  /**
   * @param int $vendorId
   * @param int $orderId
   * @return \Magento\Sales\Api\Data\OrderInterface 
   * @throws \Magento\Framework\Exception\LocalizedException
   */
  public function getOrder($vendorId, $orderId);

  /**
   * @param int $order_id_of_seller
   * @param bool|false $capture
   * @param \Magento\Sales\Api\Data\InvoiceItemCreationInterface[] $items
   * @param bool|false $notify
   * @param bool|false $appendComment
   * @param Data\InvoiceCommentCreationInterface|null $comment
   * @param Data\InvoiceCreationArgumentsInterface|null $arguments
   * @return string
   * @since 100.1.2
   */


  public function createInvoice(
    $order_id_of_seller,
    $capture = false,
    array $items = [],
    $notify = false,
    $appendComment = false,
    \Magento\Sales\Api\Data\InvoiceCommentCreationInterface $comment = null,
    \Magento\Sales\Api\Data\InvoiceCreationArgumentsInterface $arguments = null
  );


  /**
   * Creates new Shipment for given Order.
   * @param int $order_id
   * @param \Magento\Sales\Api\Data\ShipmentItemCreationInterface[] $items
   * @param bool $notify
   * @param bool $appendComment
   * @param \Magento\Sales\Api\Data\ShipmentCommentCreationInterface|null $comment
   * @param \Magento\Sales\Api\Data\ShipmentTrackCreationInterface[] $tracks
   * @param \Magento\Sales\Api\Data\ShipmentPackageCreationInterface[] $packages
   * @param \Magento\Sales\Api\Data\ShipmentCreationArgumentsInterface|null $arguments
   * @return string 
   * @since 100.1.2
   */
  public function createShipment(
    $order_id,
    array $items = [],
    $notify = false,
    $appendComment = false,
    \Magento\Sales\Api\Data\ShipmentCommentCreationInterface $comment = null,
    array $tracks = [],
    array $packages = []
  );


  /** 
   * @param string $idOrder The order ID.
   * @return \Wiki\VendorsSales\Api\Data\AccountPageSaleInterface  
   */
  public function getOrderAccountPage($idOrder);

  /**
   * @param mixed $orders
   * @param mixed $payment
   * @param mixed $address
   * @param mixed $customer
   * @return \Magento\Sales\Api\Data\OrderInterface[]  Order Interface 
   */
  public function placeOrder($orders, $payment, $address, $customer);

  /**
   * @param \Wiki\VendorsSales\Api\Data\RequestReturnItemsInterface  $return_request
   * @return boolean
   */
  public function requestReturnOrder($return_request);

  /**
   * @param int $order_id
   * @param string $reason
   * @return bool
   */
  public function createNotificationRequest($order_id, $reason);

  /**
   * @param int $order_id
   * @param string $reason
   * @param boolean $accept
   * @return bool
   */
  public function createNotificationConfirm($order_id, $reason, $accept);

  /**
   * @param int $order_id
   * @param string $reason
   * @param boolean $accept
   * @return bool
   */
  public function createNotificationConfirmReturn($order_id, $reason, $accept);

  /**
   * @param int $order_id
   * @param bool $accept
   * @return bool
   */
  public function confirmTimeExpand($order_id, $accept);

  /**
   * @param string $incrementId
   * @return \Magento\Sales\Api\Data\OrderInterface 
   * @return bool
   */
  public function getOrderByIncrementId($incrementId);
  
}
