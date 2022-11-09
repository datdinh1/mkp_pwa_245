<?php


namespace Wiki\VendorsCredit\Api\Data;
/**
 * @api
 */
interface DebitInterface
{
    /**.
     * Constants used as data array keys
     */
    const ID                    = 'id';
    const FULL_NAME             = 'full_name';
    const ACCOUNT_NUMBER        = 'account_number';
    const BANK_NAME             = 'bank_name';
    const CUSTOMER_ID           = 'customer_id';
    const CHECK_DEFAULT         = 'check_default';

    /**
     * Get id
     *
     * @return int
     */
    public function getId();

    /**
     * Set Id
     *
     * @param int $id
     * @return $this
     */
    public function setId($id);

    /**
     * Get Full Name
     *
     * @return string
     */
    public function getFullName();

    /**
     * Set Full Name
     *
     * @param string $fullName
     * @return $this
     */
    public function setFullName($fullName);

    /**
     * Get Account Number
     *
     * @return string
     */
    public function getAccountNumber();

    /**
     * Set Account Number
     *
     * @param string $accountNumber
     * @return $this
     */
    public function setAccountNumber($accountNumber);

    /**
     * Get Bank Name
     *
     * @return string
     */
    public function getBankName();

    /**
     * Set Bank Name
     *
     * @param string $bankName
     * @return $this
     */
    public function setBankName($bankName);

    /**
     * Get Customer Id
     *
     * @return int
     */
    public function getCustomerId();

    /**
     * Set Customer Id
     *
     * @param int $customerId
     * @return $this
     */
    public function setCustomerId($customerId);

    /**
     * Get Check Default
     *
     * @return int
     */
    public function getCheckDefault();

    /**
     * Set Check Default
     *
     * @param int $default
     * @return $this
     */
    public function setCheckDefault($default);
}