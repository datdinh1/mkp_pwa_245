<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Wiki\Vendors\Model\Api;

/**
 * Softprodigy Dailydeal date model
 */
class Seller extends \Magento\Framework\Model\AbstractModel implements \Wiki\Vendors\Api\Data\SellerInterface
{
    /**
     * Get Id
     *
     * @return int
     */
    public function getEntityId()
    {
        return $this->getData(self::ENTITY_ID);
    }

    /**
     * Set Id
     *
     * @param int $entityId
     * @return $this
     */
    public function setEntityId($entityId)
    {
        return $this->setData(self::ENTITY_ID, $entityId);
    }

    /**
     * Get seller website id
     *
     * @return int
     */
    public function getWebsiteId()
    {
        return $this->getData(self::WEBSITE_ID);
    }

    /**
     * Set seller website id
     *
     * @param int $webId
     * @return $this
     */
    public function setWebsiteId($webId)
    {
        return $this->setData(self::WEBSITE_ID, $webId);
    }

    /**
     * Get increment id
     *
     * @return string
     */
    public function getIncrementId()
    {
        return $this->getData(self::INCREMENT_ID);
    }

    /**
     * Set increment id
     *
     * @param string $increid
     * @return $this
     */
    public function setIncrementId($increid)
    {
        return $this->setData(self::INCREMENT_ID, $increid);
    }

    /**
     * Get vendor id
     *
     * @return string
     */
    public function getVendorId()
    {
        return $this->getData(self::VENDOR_ID);
    }

    /**
     * Set vendor id
     *
     * @param string $id
     * @return $this
     */
    public function setVendorId($vendorId)
    {
        return $this->setData(self::VENDOR_ID, $vendorId);
    }

    /**
     * Get created at
     *
     * @return int
     */
    public function getCreatedAt()
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * Set created at
     *
     * @param string $date
     * @return $this
     */
    public function setCreatedAt($date)
    {
        return $this->setData(self::CREATED_AT, $date);
    }

    /**
     * Get updated at
     *
     * @return string
     */
    public function getUpdatedAt()
    {
        return $this->getData(self::UPDATED_AT);
    }

    /**
     * Set updated at
     *
     * @param string $date
     * @return $this
     */
    public function setUpdatedAt($date)
    {
        return $this->setData(self::UPDATED_AT, $date);
    }

    /**
     * Get group id
     *
     * @return int
     */
    public function getGroupId()
    {
        return $this->getData(self::GROUP_ID);
    }

    /**
     * Set group id
     *
     * @param int $groupId
     * @return $this
     */
    public function setGroupId($groupId)
    {
        return $this->setData(self::GROUP_ID, $groupId);
    }

    /**
     * Get status
     *
     * @return int
     */
    public function getStatus()
    {
        return $this->getData(self::GROUP_ID);
    }

    /**
     * Set status
     *
     * @param int $status
     * @return $this
     */
    public function setStatus($status)
    {
        return $this->setData(self::STATUS, $status);
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->getData(self::CITY);
    }

    /**
     * Set city
     *
     * @param string $city
     * @return $this
     */
    public function setCity($city)
    {
        return $this->setData(self::CITY, $city);
    }

    /**
     * Get company
     *
     * @return string
     */
    public function getCompany()
    {
        return $this->getData(self::COMPANY);
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
     * Get country id
     *
     * @return int
     */
    public function getCountryId()
    {
        return $this->getData(self::COUNTRY_ID);
    }

    /**
     * Set country id
     *
     * @param int $countryId
     * @return $this
     */
    public function setCountryId($countryId)
    {
        return $this->setData(self::COUNTRY_ID, $countryId);
    }

    /**
     * Get fax
     *
     * @return int
     */
    public function getFax()
    {
        return $this->getData(self::FAX);
    }

    /**
     * Set fax
     *
     * @param string $fax
     * @return $this
     */
    public function setFax($fax)
    {
        return $this->setData(self::FAX, $fax);
    }

    /**
     * Get post code
     *
     * @return string
     */
    public function getPostcode()
    {
        return $this->getData(self::POSTCODE);
    }

    /**
     * Set post code
     *
     * @param string $code
     * @return $this
     */
    public function setPostcode($code)
    {
        return $this->setData(self::POSTCODE, $code);
    }

    /**
     * Get region
     *
     * @return int
     */
    public function getRegion()
    {
        return $this->getData(self::REGION);
    }

    /**
     * Set region
     *
     * @param string $region
     * @return $this
     */
    public function setRegion($region)
    {
        return $this->setData(self::REGION, $region);
    }

    /**
     * Get region id
     *
     * @return int
     */
    public function getRegionId()
    {
        return $this->getData(self::REGION_ID);
    }

    /**
     * Set region id
     *
     * @param int $regionId
     * @return $this
     */
    public function setRegionId($regionId)
    {
        return $this->setData(self::REGION_ID, $regionId);
    }

    /**
     * Get street
     *
     * @return string
     */
    public function getStreet()
    {
        return $this->getData(self::STREET);
    }

    /**
     * Set street
     *
     * @param string $street
     * @return $this
     */
    public function setStreet($street)
    {
        return $this->setData(self::STREET, $street);
    }

    /**
     * Get telephone
     *
     * @return string
     */
    public function getTelephone()
    {
        return $this->getData(self::TELEPHONE);
    }

    /**
     * Set telephone
     *
     * @param string $phone
     * @return $this
     */
    public function setTelephone($phone)
    {
        return $this->setData(self::TELEPHONE, $phone);
    }

    /**
     * Get main address
     *
     * @return string
     */
    public function getMainAddress()
    {
        return $this->getData(self::MAIN_ADDRESS);
    }

    /**
     * Set main address
     *
     * @param string $ship
     * @return $this
     */
    public function setMainAddress($ship)
    {
        return $this->setData(self::MAIN_ADDRESS, $ship);
    }

    /**
     * Get shipping address
     *
     * @return string
     */
    public function getShippingAddress()
    {
        return $this->getData(self::SHIPPING_ADDRESS);
    }

    /**
     * Set shipping address
     *
     * @param string $ship
     * @return $this
     */
    public function setShippingAddress($ship)
    {
        return $this->setData(self::SHIPPING_ADDRESS, $ship);
    }

    /**
     * Get return address
     *
     * @return string
     */
    public function getReturnAddress()
    {
        return $this->getData(self::RETURN_ADDRESS);
    }

    /**
     * Set return address
     *
     * @param string $ship
     * @return $this
     */
    public function setReturnAddress($ship)
    {
        return $this->setData(self::RETURN_ADDRESS, $ship);
    }

    /**
     * Get ves test
     *
     * @return string
     */
    public function getVesTestAtrribute4()
    {
        return $this->getData(self::VES_TEST_ATTRIBUTE4);
    }

    /**
     * Set ves test
     *
     * @param string $attri
     * @return $this
     */
    public function setVesTestAtrribute4($attri)
    {
        return $this->setData(self::VES_TEST_ATTRIBUTE4, $attri);
    }
    /**
     * Get flag notification email
     *
     * @return int
     */
    public function getFlagNotifyEmail()
    {
        return $this->getData(self::FLAG_NOTIFY_EMAIL);
    }

    /**
     * Set flag notification email
     *
     * @param int $flag
     * @return $this
     */
    public function setFlagNotifyEmail($flag)
    {
        return $this->setData(self::FLAG_NOTIFY_EMAIL, $flag);
    }

    /**
     * Get customer
     *
     * @return \Wiki\Vendors\Api\Data\CustomerInterface
     */
    public function getCustomer()
    {
        return $this->getData(self::CUSTOMER);
    }

    /**
     * Set customer
     *
     * @param \Wiki\Vendors\Api\Data\CustomerInterface $customer
     * @return $this
     */
    public function setCustomer($customer)
    {
        return $this->setData(self::CUSTOMER, $customer);
    }

    /**
     * Get first name
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->getData(self::FIRSTNAME);
    }

    /**
     * Set first name
     *
     * @param string $firstname
     * @return $this
     */
    public function setFirstname($firstname)
    {
        return $this->setData(self::FIRSTNAME, $firstname);
    }

    /**
     * Get middle name
     *
     * @return string
     */
    public function getMiddlename()
    {
        return $this->getData(self::MIDDELNAME);
    }

    /**
     * Set middle name
     *
     * @param string $mid
     * @return $this
     */
    public function setMiddlename($mid)
    {
        return $this->setData(self::MIDDELNAME, $mid);
    }

    /**
     * Get last name
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->getData(self::LASTNAME);
    }

    /**
     * Set last name
     *
     * @param string $lastname
     * @return $this
     */
    public function setLastname($lastname)
    {
        return $this->setData(self::LASTNAME, $lastname);
    }

    /**
     * Get last name
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->getData(self::EMAIL);
    }

    /**
     * Set last name
     *
     * @param string $email
     * @return $this
     */
    public function setEmail($email)
    {
        return $this->setData(self::EMAIL, $email);
    }

    /**
     * Get novice
     *
     * @return bool
     */
    public function getNovice()
    {
        return $this->getData(self::NOVICE);
    }

    /**
     * Set novice
     *
     * @param bool $novice
     * @return $this
     */
    public function setNovice($novice)
    {
        return $this->setData(self::NOVICE, $novice);
    }

    /**
     * Get last name
     *
     * @return \Wiki\Vendors\Api\Data\GeneralInterface
     */
    public function getGeneral()
    {
        return $this->getData(self::GENERAL);
    }

    /**
     * Set last name
     *
     * @param \Wiki\Vendors\Api\Data\GeneralInterface $general
     * @return $this
     */
    public function setGeneral($general)
    {
        return $this->setData(self::GENERAL, $general);
    }

    /**
     * Get seller page
     *
     * @return \Wiki\Vendors\Api\Data\SellerPageInterface
     */
    public function getSellerPage()
    {
        return $this->getData(self::SELLER_PAGE);
    }

    /**
     * Set seller page
     *
     * @param \Wiki\Vendors\Api\Data\SellerPageInterface $sellerpage
     * @return $this
     */
    public function setSellerPage($sellerpage)
    {
        return $this->setData(self::SELLER_PAGE, $sellerpage);
    }

    /**
     * Get Rating
     *
     * @return string
     */
    public function getRating()
    {
        return $this->getData(self::RATING);
    }

    /**
     * Set Rating
     *
     * @param string $rating
     * @return $this
     */
    public function setRating($rating)
    {
        return $this->setData(self::RATING, $rating);
    }

    /**
     * Get Wish list
     *
     * @return string
     */
    public function getWishlist()
    {
        return $this->getData(self::WISHLIST);
    }

    /**
     * Set Wish list
     *
     * @param string $wish
     * @return $this
     */
    public function setWishlist($wish)
    {
        return $this->setData(self::WISHLIST, $wish);
    }

    /**
     * Get Followers
     * @inheritdoc
     */
    public function getFollowers()
    {
        return $this->getData(self::FOLLOWERS);
    }

    /**
     * Set Followers
     * @inheritdoc
     */
    public function setFollowers($followers)
    {
        return $this->setData(self::FOLLOWERS, $followers);
    }
}
