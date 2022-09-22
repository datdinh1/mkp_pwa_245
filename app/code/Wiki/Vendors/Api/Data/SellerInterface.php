<?php

namespace Wiki\Vendors\Api\Data;

/**
 * Interface CommentInterface
 * @package Mageplaza\Blog\Api\Data
 */
interface SellerInterface
{
    /**
     * Constants used as data array keys
     */
    const ENTITY_ID            = 'entity_id';
    const WEBSITE_ID           = 'website_id';
    const INCREMENT_ID         = 'increment_id';
    const VENDOR_ID            = 'vendor_id';
    const CREATED_AT           = 'created_at';
    const UPDATED_AT           = 'updated_at';
    const GROUP_ID             = 'group_id';
    const STATUS               = 'status';

    const CITY                 = 'city';
    const COMPANY              = 'company';
    const COUNTRY_ID           = 'country_id';
    const FAX                  = 'fax';
    const POSTCODE             = 'postcode';
    const REGION               = 'region';
    const REGION_ID            = 'region_id';
    const STREET               = 'street';
    const TELEPHONE            = 'telephone';
    const MAIN_ADDRESS         = 'main_address';
    const SHIPPING_ADDRESS     = 'shipping_address';
    const RETURN_ADDRESS       = 'return_address';
    const VES_TEST_ATTRIBUTE4  = 'ves_test_attribute4';
    const FLAG_NOTIFY_EMAIL    = 'flag_notify_email';

    const CUSTOMER             = 'customer';
    const FIRSTNAME            = 'firstname';
    const MIDDELNAME           = 'middlename';
    const LASTNAME             = 'lastname';
    const EMAIL                = 'email';
    const GENERAL              = 'general';
    const SELLER_PAGE          = 'seller_page';
    const RATING               = 'rating';
    const WISHLIST             = 'wishlist';
    const FOLLOWERS            = 'followers';
    const NOVICE               = 'is_novice';




    /**
     * Get seller id
     *
     * @return int|null
     */
    public function getEntityId();

    /**
     * Set seller Id
     *
     * @param int $entityId
     *
     * @return $this
     */
    public function setEntityId($entityId);

    /**
     * Get seller website id
     *
     * @return int
     */
    public function getWebsiteId();

    /**
     * Set seller website id
     *
     * @param int $webId
     *
     * @return $this
     */
    public function setWebsiteId($webId);

    /**
     * Get increment id
     *
     * @return string|null
     */
    public function getIncrementId();

    /**
     * Set increment id
     *
     * @param string $incre
     *
     * @return $this
     */
    public function setIncrementId($incre);

    /**
     * Get vendor id
     *
     * @return string|null
     */
    public function getVendorId();

    /**
     * Set increment id
     *
     * @param string $vendor
     *
     * @return $this
     */
    public function setVendorId($vendor);

    /**
     * Get created at
     *
     * @return string|null
     */
    public function getCreatedAt();

    /**
     * Set created at
     *
     * @param string $date
     *
     * @return $this
     */
    public function setCreatedAt($date);


    /**
     * Get updated at
     *
     * @return string|null
     */
    public function getUpdatedAt();

    /**
     * Set updated at
     *
     * @param string $date
     *
     * @return $this
     */
    public function setUpdatedAt($date);

    /**
     * Get group id
     *
     * @return int|null
     */
    public function getGroupId();

    /**
     * Set group id
     *
     * @param int $group
     *
     * @return $this
     */
    public function setGroupId($group);

    /**
     * Get status 
     *
     * @return int|null
     */
    public function getStatus();

    /**
     * Set status 
     *
     * @param int $status
     *
     * @return $this
     */
    public function setStatus($status);

    /**
     * Get city 
     *
     * @return string|null
     */
    public function getCity();

    /**
     * Set city 
     *
     * @param string $city
     *
     * @return $this
     */
    public function setCity($city);


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
     *
     * @return $this
     */
    public function setCompany($company);


    /**
     * Get  county id
     *
     * @return int|null
     */
    public function getCountryId();

    /**
     * Set county id 
     *
     * @param int $countryId
     *
     * @return $this
     */
    public function setCountryId($countryId);


    /**
     * Get  fax
     *
     * @return string|null
     */
    public function getFax();

    /**
     * Set fax 
     *
     * @param string $fax
     *
     * @return $this
     */
    public function setFax($fax);

    /**
     * Get  post code 
     *
     * @return string|null
     */
    public function getPostcode();

    /**
     * Set post code  
     *
     * @param string $code
     *
     * @return $this
     */
    public function setPostcode($code);


    /**
     * Get region 
     *
     * @return string|null
     */
    public function getRegion();

    /**
     * Set region 
     *
     * @param string $region
     *
     * @return $this
     */
    public function setRegion($region);


    /**
     * Get region id 
     *
     * @return int|null
     */
    public function getRegionId();

    /**
     * Set region id
     *
     * @param int $regionId
     *
     * @return $this
     */
    public function setRegionId($regionId);

    /**
     * Get street
     *
     * @return string|null
     */
    public function getStreet();

    /**
     * Set street
     *
     * @param string $street
     *
     * @return $this
     */
    public function setStreet($street);

    /**
     * Get telephone
     *
     * @return string|null
     */
    public function getTelephone();

    /**
     * Set telephone
     *
     * @param string $telephone
     *
     * @return $this
     */
    public function setTelephone($telephone);

    /**
     * Get main address
     *
     * @return string|null
     */
    public function getMainAddress();

    /**
     * Set main address
     *
     * @param string $mainAddress
     *
     * @return $this
     */
    public function setMainAddress($mainAddress);

    /**
     * Get shipping address
     *
     * @return string|null
     */
    public function getShippingAddress();

    /**
     * Set shipping address
     *
     * @param string $shippingAddress
     *
     * @return $this
     */
    public function setShippingAddress($shippingAddress);

    /**
     * Get return address
     *
     * @return string|null
     */
    public function getReturnAddress();

    /**
     * Set return address
     *
     * @param string $returnAddress
     *
     * @return $this
     */
    public function setReturnAddress($returnAddress);

    /**
     * Get ves test
     *
     * @return string|null
     */
    public function getVesTestAtrribute4();

    /**
     * Set ves test
     *
     * @param string $atrribute4
     *
     * @return $this
     */
    public function setVesTestAtrribute4($atrribute4);

    /**
     * Get flag notification email
     *
     * @return int|null
     */
    public function getFlagNotifyEmail();

    /**
     * Set flag notification email
     *
     * @param int $notify
     *
     * @return $this
     */
    public function setFlagNotifyEmail($notify);


    /**
     * Get customer
     *
     * @return \Wiki\Vendors\Api\Data\CustomerInterface
     */
    public function getCustomer();

    /**
     * Set customer
     *
     * @param \Wiki\Vendors\Api\Data\CustomerInterface $customer
     *
     * @return $this
     */
    public function setCustomer($customer);

    /**
     * Get first name
     *
     * @return string|null
     */
    public function getFirstname();

    /**
     * Set first name
     *
     * @param string $firstname
     *
     * @return $this
     */
    public function setFirstname($firstname);

    /**
     * Get middle name
     *
     * @return string|null
     */
    public function getMiddlename();

    /**
     * Set middle name
     *
     * @param string $middlename
     *
     * @return $this
     */
    public function setMiddlename($middlename);

    /**
     * Get last name
     *
     * @return string|null
     */
    public function getLastname();

    /**
     * Set last name
     *
     * @param string $lastname
     *
     * @return $this
     */
    public function setLastname($lastname);

    /**
     * Get email
     *
     * @return string|null
     */
    public function getEmail();

    /**
     * Set email
     *
     * @param string $email
     *
     * @return $this
     */
    public function setEmail($email);

    /**
     * Get novice
     *
     * @return bool
     */
    public function getNovice();

    /**
     * Set novice
     *
     * @param bool $novice
     *
     * @return $this
     */
    public function setNovice($novice);

    /**
     * Get general 
     *
     * @return \Wiki\Vendors\Api\Data\GeneralInterface|null
     */
    public function getGeneral();

    /**
     * Set general
     *
     * @param \Wiki\Vendors\Api\Data\GeneralInterface $general
     *
     * @return $this
     */
    public function setGeneral($general);

    /**
     * Get seller page 
     *
     * @return \Wiki\Vendors\Api\Data\SellerPageInterface|null
     */
    public function getSellerPage();

    /**
     * Set seller page
     *
     * @param \Wiki\Vendors\Api\Data\SellerPageInterface $sell
     *
     * @return $this
     */
    public function setSellerPage($sell);

    /**
     * Get Rating
     *
     * @return string|null
     */
    public function getRating();

    /**
     * Set Rating
     *
     * @param string $rating
     *
     * @return $this
     */
    public function setRating($rating);

    /**
     * Get wish list
     *
     * @return string|null
     */
    public function getWishlist();

    /**
     * Set wish list
     *
     * @param string $wish
     *
     * @return $this
     */
    public function setWishlist($wish);

    /**
     * Get Followers
     *
     * @return int|null
     */
    public function getFollowers();

    /**
     * Set Followers
     *
     * @param int|null $followers
     *
     * @return $this
     */
    public function setFollowers($followers);
}
