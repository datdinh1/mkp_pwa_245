<?php
namespace Wiki\VendorsCredit\Model;

use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;
use Magento\Framework\Exception\LocalizedException;
use Wiki\VendorsCredit\Api\Data\DebitInterface;

class Debit extends AbstractModel implements DebitInterface
{
    const CACHE_TAG = 'wiki_bank_card';

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

    protected function _construct()
    {
        $this->_init('Wiki\VendorsCredit\Model\ResourceModel\Debit');
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
     * Get Full Name
     *
     * @return string
     */
    public function getFullName()
    {
        return $this->getData(self::FULL_NAME);
    }

    /**
     * Set Full Name
     *
     * @param string $fullName
     * @return $this
     */
    public function setFullName($fullName)
    {
        return $this->setData(self::FULL_NAME, $fullName);
    }

    /**
     * Get Account Number
     *
     * @return string
     */
    public function getAccountNumber()
    {
        return $this->getData(self::ACCOUNT_NUMBER);
    }

    /**
     * Set Account Number
     *
     * @param string $accountNumber
     * @return $this
     */
    public function setAccountNumber($accountNumber)
    {
        return $this->setData(self::ACCOUNT_NUMBER, $accountNumber);
    }

    /**
     * Get Bank Name
     *
     * @return string
     */
    public function getBankName()
    {
        return $this->getData(self::BANK_NAME);
    }

    /**
     * Set Bank Name
     *
     * @param string $bankName
     * @return $this
     */
    public function setBankName($bankName)
    {
        return $this->setData(self::BANK_NAME, $bankName);
    }

    /**
     * Get Customer Id
     *
     * @return int
     */
    public function getCustomerId()
    {
        return $this->getData(self::CUSTOMER_ID);
    }

    /**
     * Set Customer Id
     *
     * @param int $customerId
     * @return $this
     */
    public function setCustomerId($customerId)
    {
        return $this->setData(self::CUSTOMER_ID, $customerId);
    }

    /**
     * Get Check Default
     *
     * @return int
     */
    public function getCheckDefault()
    {
        return $this->getData(self::CHECK_DEFAULT);
    }
     
    /**
     * Set Check Default
     *
     * @param int $default
     * @return $this
     */
    public function setCheckDefault($default)
    {
        return $this->setData(self::CHECK_DEFAULT, $default);
    }
}
