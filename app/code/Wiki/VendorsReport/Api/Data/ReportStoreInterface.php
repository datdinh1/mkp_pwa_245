<?php

namespace Wiki\VendorsReport\Api\Data;

interface ReportStoreInterface
{
    /**
     * Constants used as data array keys
     */
    const SALES = 'sales';
    const ORDERS = 'orders';
    const TOTAL_BUYERS = 'total_buyers';
    const NEW_BUYERS = 'new_buyers';

    /**
     * Get Sales
     *
     * @return Wiki\VendorsReport\Api\Data\ReportStoreDataInterface[]
     */
    public function getSales();

    /**
     * Set Sales
     *
     * @param Wiki\VendorsReport\Api\Data\ReportStoreDataInterface[] $sales
     *
     * @return $this
     */
    public function setSales($sales);

    /**
     * Get Order
     *
     * @return Wiki\VendorsReport\Api\Data\ReportStoreDataInterface[]
     */
    public function getOrders();

    /**
     * Set Order
     *
     * @param Wiki\VendorsReport\Api\Data\ReportStoreDataInterface[] $orders
     *
     * @return $this
     */
    public function setOrders($orders);

    /**
     * Get Total Buyers
     *
     * @return Wiki\VendorsReport\Api\Data\ReportStoreDataInterface[]
     */
    public function getTotalBuyers();

    /**
     * Set Total Buyers
     *
     * @param Wiki\VendorsReport\Api\Data\ReportStoreDataInterface[] $customer
     *
     * @return $this
     */
    public function setTotalBuyers($customer);

    /**
     * Get New Buyers
     *
     * @return Wiki\VendorsReport\Api\Data\ReportStoreDataInterface[]
     */
    public function getNewBuyers();

    /**
     * Set New Buyers
     *
     * @param Wiki\VendorsReport\Api\Data\ReportStoreDataInterface[] $customer
     *
     * @return $this
     */
    public function setNewBuyers($customer);

}
