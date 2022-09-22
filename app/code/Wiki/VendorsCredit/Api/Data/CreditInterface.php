<?php


namespace Wiki\VendorsCredit\Api\Data;
/**
 * @api
 */
interface CreditInterface
{
    /**.
     * Constants used as data array keys
     */
    const ID                 = 'id';
    const CARD_NUMBER        = 'card_number';
    const NAME_ON_CARD       = 'name_on_card';
    const EXPIRATION_DATE    = 'expiration_date';
    const CVV                = 'cvv';
    const CUSTOMER_ID        = 'customer_id';
    const CHECK_DEFAULT      = 'check_default';

    /**
     * Get id
     *
     * @return int|null
     */
    public function getId();

    /**
     * Set Id
     *
     * @param int $id
     *
     * @return $this
     */
    public function setId($id);

    /**
     * Get Card Number
     *
     * @return string
     */
    public function getCardNumber();

    /**
     * Set Card Number
     *
     * @param string $cardNumber
     *
     * @return $this
     */
    public function setCardNumber($cardNumber);

    /**
     * Get Name On Card
     *
     * @return string
     */
    public function getNameOnCard();

    /**
     * Set Name On Card
     *
     * @param string $nameCard
     *
     * @return $this
     */
    public function setNameOnCard($nameCard);

    /**
     * Get Expiration Date
     *
     * @return string
     */
    public function getExpirationDate();

    /**
     * Set Expiration Date
     *
     * @param string $date
     *
     * @return $this
     */
    public function setExpirationDate($date);

    /**
     * Get Cvv
     *
     * @return string
     */
    public function getCvv();

    /**
     * Set Cvv
     *
     * @param string $cvv
     *
     * @return $this
     */
    public function setCvv($cvv);

    /**
     * Get card number
     *
     * @return int
     */
    public function getCustomerId();

    /**
     * Set Customer Id
     *
     * @param int $customerId
     *
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
     *
     * @return $this
     */
    public function setCheckDefault($default);
}
