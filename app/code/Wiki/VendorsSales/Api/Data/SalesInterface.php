<?php


namespace Wiki\VendorsSales\Api\Data;
interface SalesInterface
{
    /**
     * Constants used as data array keys
     */
    const ORDERS            = 'orders';
    const SHIPPING_ADDRESS  = 'shipping_address';
    const PAYMENT_METHOD    = 'payment_method';
    const CUSTOMER          = 'customer';
    /**
     * Get Orders
     *
     * @return  mixed
     */
    public function getOrders();

    /**
     * Set Orders
     *
     * @param  mixed $order
     *
     * @return $this
     */
    public function setOrders($order);

    /**
     * Get Shipping Address
     *
     * @return \Magento\Customer\Api\Data\AddressInterface
     */
    public function getShippingAddress();

    /**
     * Set Shipping Address
     *
     * @param \Magento\Customer\Api\Data\AddressInterface $shipping
     *
     * @return $this
     */
    public function setShippingAddress($shipping);

    /**
     * Get Payment Method
     *
     * @return mixed
     */
    public function getPaymentMethod();

    /**
     * Set Payment Method
     *
     * @param mixed $payment
     *
     * @return $this
     */
    public function setPaymentMethod($payment);

     /**
     * Get Customer
     *
     * @return \Magento\Customer\Api\Data\CustomerInterface
     */
    public function getCustomer();

    /**
     * Set Payment Method
     *
     * @param \Magento\Customer\Api\Data\CustomerInterface $payment
     *
     * @return $this
     */
    public function setCustomer($payment);

    
}
