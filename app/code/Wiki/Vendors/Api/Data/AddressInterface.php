<?php
/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Wiki\Vendors\Api\Data;

/**
 * Seller address interface.
 * @api
 * @since 100.0.2
 */
interface AddressInterface extends \Magento\Framework\Api\CustomAttributesDataInterface
{
    /**#@+
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const ID                    = 'id';
    const SELLER_ID             = 'seller_id';
    const REGION                = 'region';
    const REGION_ID             = 'region_id';
    const COUNTRY_ID            = 'country_id';
    const STREET                = 'street';
    const COMPANY               = 'company';
    const TELEPHONE             = 'telephone';
    const FAX                   = 'fax';
    const POSTCODE              = 'postcode';
    const CITY                  = 'city';
    const FIRSTNAME             = 'firstname';
    const LASTNAME              = 'lastname';
    const MIDDLENAME            = 'middlename';
    const PREFIX                = 'prefix';
    const SUFFIX                = 'suffix';
    const VAT_ID                = 'vat_id';
    const DEFAULT_MAIN          = 'default_main';
    const DEFAULT_SHIPPING      = 'default_shipping';
    const DEFAULT_BILLING       = 'default_billing';
    const DEFAULT_RETURN        = 'default_return';
    /**#@-*/

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId();

    /**
     * Set ID
     *
     * @param int $id
     * @return $this
     */
    public function setId($id);

    /**
     * Get Seller ID
     *
     * @return int|null
     */
    public function getSellerId();

    /**
     * Set Seller ID
     *
     * @param int $sellerId
     * @return $this
     */
    public function setSellerId($sellerId);

    /**
     * Get region
     *
     * @return \Magento\Customer\Api\Data\RegionInterface|null
     */
    public function getRegion();

    /**
     * Set region
     *
     * @param \Magento\Customer\Api\Data\RegionInterface $region
     * @return $this
     */
    public function setRegion(\Magento\Customer\Api\Data\RegionInterface $region = null);

    /**
     * Get region ID
     *
     * @return int|null
     */
    public function getRegionId();

    /**
     * Set region ID
     *
     * @param int $regionId
     * @return $this
     */
    public function setRegionId($regionId);

    /**
     * Two-letter country code in ISO_3166-2 format
     *
     * @return string|null
     */
    public function getCountryId();

    /**
     * Set country id
     *
     * @param string $countryId
     * @return $this
     */
    public function setCountryId($countryId);

    /**
     * Get street
     *
     * @return string[]|null
     */
    public function getStreet();

    /**
     * Set street
     *
     * @param string[] $street
     * @return $this
     */
    public function setStreet(array $street);

    /**
     * Get company
     *
     * @return string|null
     */
    public function getCompany();

    /**
     * Set company
     *
     * @param string $company
     * @return $this
     */
    public function setCompany($company);

    /**
     * Get telephone number
     *
     * @return string|null
     */
    public function getTelephone();

    /**
     * Set telephone number
     *
     * @param string $telephone
     * @return $this
     */
    public function setTelephone($telephone);

    /**
     * Get fax number
     *
     * @return string|null
     */
    public function getFax();

    /**
     * Set fax number
     *
     * @param string $fax
     * @return $this
     */
    public function setFax($fax);

    /**
     * Get postcode
     *
     * @return string|null
     */
    public function getPostcode();

    /**
     * Set postcode
     *
     * @param string $postcode
     * @return $this
     */
    public function setPostcode($postcode);

    /**
     * Get city name
     *
     * @return string|null
     */
    public function getCity();

    /**
     * Set city name
     *
     * @param string $city
     * @return $this
     */
    public function setCity($city);

    /**
     * Get first name
     *
     * @return string|null
     */
    public function getFirstname();

    /**
     * Set first name
     *
     * @param string $firstName
     * @return $this
     */
    public function setFirstname($firstName);

    /**
     * Get last name
     *
     * @return string|null
     */
    public function getLastname();

    /**
     * Set last name
     *
     * @param string $lastName
     * @return $this
     */
    public function setLastname($lastName);

    /**
     * Get middle name
     *
     * @return string|null
     */
    public function getMiddlename();

    /**
     * Set middle name
     *
     * @param string $middleName
     * @return $this
     */
    public function setMiddlename($middleName);

    /**
     * Get prefix
     *
     * @return string|null
     */
    public function getPrefix();

    /**
     * Set prefix
     *
     * @param string $prefix
     * @return $this
     */
    public function setPrefix($prefix);

    /**
     * Get suffix
     *
     * @return string|null
     */
    public function getSuffix();

    /**
     * Set suffix
     *
     * @param string $suffix
     * @return $this
     */
    public function setSuffix($suffix);

    /**
     * Get Vat id
     *
     * @return string|null
     */
    public function getVatId();

    /**
     * Set Vat id
     *
     * @param string $vatId
     * @return $this
     */
    public function setVatId($vatId);

    /**
     * Get if this address is default main address
     *
     * @return bool|null
     */
    public function isDefaultMain();

    /**
     * Set if this address is default main address
     *
     * @param bool $isDefaultMain
     * @return $this
     */
    public function setIsDefaultMain($isDefaultMain);

    /**
     * Get if this address is default shipping address.
     *
     * @return bool|null
     */
    public function isDefaultShipping();

    /**
     * Set if this address is default shipping address.
     *
     * @param bool $isDefaultShipping
     * @return $this
     */
    public function setIsDefaultShipping($isDefaultShipping);

    /**
     * Get if this address is default billing address.
     *
     * @return bool|null
     */
    public function isDefaultBilling();

    /**
     * Set if this address is default billing address.
     *
     * @param bool $isDefaultBilling
     * @return $this
     */
    public function setIsDefaultBilling($isDefaultBilling);

    /**
     * Get if this address is default return address
     *
     * @return bool|null
     */
    public function isDefaultReturn();

    /**
     * Set if this address is default return address
     *
     * @param bool $isDefaultReturn
     * @return $this
     */
    public function setIsDefaultReturn($isDefaultReturn);
}
