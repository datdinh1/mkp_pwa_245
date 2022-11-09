<?php

namespace Wiki\VendorsCredit\Model;

use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;
use Magento\Framework\Exception\LocalizedException;
use Wiki\VendorsCredit\Api\Data\CreditInterface;

class Credit extends AbstractModel implements CreditInterface
{
    /**
     * Cache tag
     */
    const CACHE_TAG = 'wiki_credit_card';



    /**
     * Sliders constructor.
     * @param Context $context
     * @param Registry $registry

     * @param AbstractResource|null $resource
     * @param AbstractDb|null $resourceCollection
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Initialise resource model
     * @codingStandardsIgnoreStart
     */
    protected function _construct()
    {
        // @codingStandardsIgnoreEnd
        $this->_init('Wiki\VendorsCredit\Model\ResourceModel\Credit');
    }

      /**
     * Get cache identities
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }


    /**
     * Get Card Number
     *
     * @return string
     */
    public function getCardNumber()
    {
        return $this->getData(CreditInterface::CARD_NUMBER);
    }

    /**
     * Set Card Number
     *
     * @param string $cardNumber
     * @return $this
     */
    public function setCardNumber($cardNumber)
    {
        return $this->setData(CreditInterface::CARD_NUMBER, $cardNumber);
    }

    /**
     * Get Name On Card
     *
     * @return int
     */
    public function getNameOnCard()
    {
        return $this->getData(CreditInterface::NAME_ON_CARD);
    }

    /**
     * Set Name On Card
     *
     * @param int $nameOnCard
     * @return $this
     */
    public function setNameOnCard($nameOnCard)
    {
        return $this->setData(CreditInterface::NAME_ON_CARD, $nameOnCard);
    }


    /**
     * Get Expiration Date
     *
     * @return string
     */
    public function getExpirationDate()
    {
        return $this->getData(CreditInterface::EXPIRATION_DATE);
    }
     

    /**
     * Set Expiration Date
     *
     * @param string $expirationDate
     * @return $this
     */
    public function setExpirationDate($expirationDate)
    {
        return $this->setData(CreditInterface::EXPIRATION_DATE, $expirationDate);
    }

     /**
     * Get Cvv
     *
     * @return string
     */
    public function getCvv()
    {
        return $this->getData(CreditInterface::CVV);
    }
     

    /**
     * Set Cvv
     *
     * @param string $cvv
     * @return $this
     */
    public function setCvv($cvv)
    {
        return $this->setData(CreditInterface::CVV, $cvv);
    }

     /**
     * Get Customer Id
     *
     * @return int
     */
    public function getCustomerId()
    {
        return $this->getData(CreditInterface::CUSTOMER_ID);
    }
     

    /**
     * Set Customer Id
     *
     * @param int $customerId
     * @return $this
     */
    public function setCustomerId($customerId)
    {
        return $this->setData(CreditInterface::CUSTOMER_ID, $customerId);
    }

     /**
     * Get Check Default
     *
     * @return string
     */
    public function getCheckDefault()
    {
        return $this->getData(CreditInterface::CHECK_DEFAULT);
    }
     

    /**
     * Set Check Default
     *
     * @param $checkDefault
     * @return $this
     */
    public function setCheckDefault($default)
    {
        return $this->setData(CreditInterface::CHECK_DEFAULT, $default);
    }

    
}
