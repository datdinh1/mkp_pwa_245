<?php
/**
 * Data Model implementing the Address interface
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\Vendors\Model\Api;

use Magento\Customer\Api\Data\RegionInterface;
use Magento\Framework\Api\AttributeValueFactory;
use Magento\Framework\Api\AbstractExtensibleObject;
use Wiki\Vendors\Api\Data\AddressInterface;

/**
 * Class Address
 *
 *
 * @api
 * @since 100.0.2
 */
class Address extends AbstractExtensibleObject implements AddressInterface
{
    /**
     * @var \Magento\Customer\Api\AddressMetadataInterface
     */
    protected $metadataService;

    /**
     * @param \Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory
     * @param AttributeValueFactory $attributeValueFactory
     * @param \Magento\Customer\Api\AddressMetadataInterface $metadataService
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory,
        AttributeValueFactory $attributeValueFactory,
        \Magento\Customer\Api\AddressMetadataInterface $metadataService,
        $data = []
    ) {
        $this->metadataService = $metadataService;
        parent::__construct($extensionFactory, $attributeValueFactory, $data);
    }

    /**
     * @inheritdoc
     */
    protected function getCustomAttributesCodes()
    {
        if ($this->customAttributesCodes === null) {
            $this->customAttributesCodes = $this->getEavAttributesCodes($this->metadataService);
        }
        return $this->customAttributesCodes;
    }

    /**
     * Get id
     *
     * @return int|null
     */
    public function getId()
    {
        return $this->_get(self::ID);
    }

    /**
     * Get region
     *
     * @return \Magento\Customer\Api\Data\RegionInterface|null
     */
    public function getRegion()
    {
        return $this->_get(self::REGION);
    }

    /**
     * Get region ID
     *
     * @return int
     */
    public function getRegionId()
    {
        return $this->_get(self::REGION_ID);
    }

    /**
     * Get country id
     *
     * @return string|null
     */
    public function getCountryId()
    {
        return $this->_get(self::COUNTRY_ID);
    }

    /**
     * Get street
     *
     * @return string[]|null
     */
    public function getStreet()
    {
        return $this->_get(self::STREET);
    }

    /**
     * Get company
     *
     * @return string|null
     */
    public function getCompany()
    {
        return $this->_get(self::COMPANY);
    }

    /**
     * Get telephone number
     *
     * @return string|null
     */
    public function getTelephone()
    {
        return $this->_get(self::TELEPHONE);
    }

    /**
     * Get fax number
     *
     * @return string|null
     */
    public function getFax()
    {
        return $this->_get(self::FAX);
    }

    /**
     * Get postcode
     *
     * @return string|null
     */
    public function getPostcode()
    {
        return $this->_get(self::POSTCODE);
    }

    /**
     * Get city name
     *
     * @return string|null
     */
    public function getCity()
    {
        return $this->_get(self::CITY);
    }

    /**
     * Get first name
     *
     * @return string|null
     */
    public function getFirstname()
    {
        return $this->_get(self::FIRSTNAME);
    }

    /**
     * Get last name
     *
     * @return string|null
     */
    public function getLastname()
    {
        return $this->_get(self::LASTNAME);
    }

    /**
     * Get middle name
     *
     * @return string|null
     */
    public function getMiddlename()
    {
        return $this->_get(self::MIDDLENAME);
    }

    /**
     * Get prefix
     *
     * @return string|null
     */
    public function getPrefix()
    {
        return $this->_get(self::PREFIX);
    }

    /**
     * Get suffix
     *
     * @return string|null
     */
    public function getSuffix()
    {
        return $this->_get(self::SUFFIX);
    }

    /**
     * Get Vat id
     *
     * @return string|null
     */
    public function getVatId()
    {
        return $this->_get(self::VAT_ID);
    }

    /**
     * Get Seller id
     *
     * @return string|null
     */
    public function getSellerId()
    {
        return $this->_get(self::SELLER_ID);
    }

    /**
     * Get if this address is default main address
     *
     * @return bool|null
     */
    public function isDefaultMain()
    {
        return $this->_get(self::DEFAULT_MAIN);
    }

    /**
     * Get if this address is default shipping address.
     *
     * @return bool|null
     */
    public function isDefaultShipping()
    {
        return $this->_get(self::DEFAULT_SHIPPING);
    }

    /**
     * Get if this address is default billing address.
     *
     * @return bool|null
     */
    public function isDefaultBilling()
    {
        return $this->_get(self::DEFAULT_BILLING);
    }

    /**
     * Get if this address is default return address
     *
     * @return bool|null
     */
    public function isDefaultReturn()
    {
        return $this->_get(self::DEFAULT_RETURN);
    }

    /**
     * Set ID
     *
     * @param int $id
     * @return $this
     */
    public function setId($id)
    {
        return $this->setData(self::ID, $id);
    }

    /**
     * Set Seller ID
     *
     * @param int $sellerId
     * @return $this
     */
    public function setSellerId($sellerId)
    {
        return $this->setData(self::SELLER_ID, $sellerId);
    }

    /**
     * Set region
     *
     * @param \Magento\Customer\Api\Data\RegionInterface $region
     * @return $this
     */
    public function setRegion(\Magento\Customer\Api\Data\RegionInterface $region = null)
    {
        return $this->setData(self::REGION, $region);
    }

    /**
     * Set region ID
     *
     * @param int $regionId
     * @return $this
     */
    public function setRegionId($regionId)
    {
        return $this->setData(self::REGION_ID, $regionId);
    }

    /**
     * Set country id
     *
     * @param string $countryId
     * @return $this
     */
    public function setCountryId($countryId)
    {
        return $this->setData(self::COUNTRY_ID, $countryId);
    }

    /**
     * Set street
     *
     * @param string[] $street
     * @return $this
     */
    public function setStreet(array $street)
    {
        return $this->setData(self::STREET, $street);
    }

    /**
     * Set company
     *
     * @param string $company
     * @return $this
     */
    public function setCompany($company)
    {
        return $this->setData(self::COMPANY, $company);
    }

    /**
     * Set telephone number
     *
     * @param string $telephone
     * @return $this
     */
    public function setTelephone($telephone)
    {
        return $this->setData(self::TELEPHONE, trim($telephone));
    }

    /**
     * Set fax number
     *
     * @param string $fax
     * @return $this
     */
    public function setFax($fax)
    {
        return $this->setData(self::FAX, $fax);
    }

    /**
     * Set postcode
     *
     * @param string $postcode
     * @return $this
     */
    public function setPostcode($postcode)
    {
        return $this->setData(self::POSTCODE, $postcode);
    }

    /**
     * Set city name
     *
     * @param string $city
     * @return $this
     */
    public function setCity($city)
    {
        return $this->setData(self::CITY, $city);
    }

    /**
     * Set first name
     *
     * @param string $firstName
     * @return $this
     */
    public function setFirstname($firstName)
    {
        return $this->setData(self::FIRSTNAME, $firstName);
    }

    /**
     * Set last name
     *
     * @param string $lastName
     * @return $this
     */
    public function setLastname($lastName)
    {
        return $this->setData(self::LASTNAME, $lastName);
    }

    /**
     * Set middle name
     *
     * @param string $middleName
     * @return $this
     */
    public function setMiddlename($middleName)
    {
        return $this->setData(self::MIDDLENAME, $middleName);
    }

    /**
     * Set prefix
     *
     * @param string $prefix
     * @return $this
     */
    public function setPrefix($prefix)
    {
        return $this->setData(self::PREFIX, $prefix);
    }

    /**
     * Set suffix
     *
     * @param string $suffix
     * @return $this
     */
    public function setSuffix($suffix)
    {
        return $this->setData(self::SUFFIX, $suffix);
    }

    /**
     * Set Vat id
     *
     * @param string $vatId
     * @return $this
     */
    public function setVatId($vatId)
    {
        return $this->setData(self::VAT_ID, $vatId);
    }

    /**
     * Set if this address is default main address
     *
     * @param bool $isDefaultMain
     * @return $this
     */
    public function setIsDefaultMain($isDefaultMain)
    {
        return $this->setData(self::DEFAULT_MAIN, $isDefaultMain);
    }

    /**
     * Set if this address is default shipping address.
     *
     * @param bool $isDefaultShipping
     * @return $this
     */
    public function setIsDefaultShipping($isDefaultShipping)
    {
        return $this->setData(self::DEFAULT_SHIPPING, $isDefaultShipping);
    }

    /**
     * Set if this address is default billing address.
     *
     * @param bool $isDefaultBilling
     * @return $this
     */
    public function setIsDefaultBilling($isDefaultBilling)
    {
        return $this->setData(self::DEFAULT_BILLING, $isDefaultBilling);
    }

    /**
     * Set if this address is default return address
     *
     * @param bool $isDefaultReturn
     * @return $this
     */
    public function setIsDefaultReturn($isDefaultReturn)
    {
        return $this->setData(self::DEFAULT_RETURN, $isDefaultReturn);
    }

}
