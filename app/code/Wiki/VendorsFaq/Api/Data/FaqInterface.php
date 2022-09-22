<?php

namespace Wiki\VendorsFaq\Api\Data;

/**
 * @api
 */
interface FaqInterface
{
    const ID              = 'id';
    const VENDOR_ID       = 'vendor_id';
    const TITLE           = 'title';
    const TYPE            = 'type';
    const LIST_DETAIL     = 'list_detail';



    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId();

    /**
     * Get Vendor ID
     *
     * @return string
     */
    public function getVendorId();

    /**
     * Get Title of FAQ
     *
     * @return string
     */
    public function getTitle();


    /**
     * Get Type
     * 
     * @return string
     */
    public function getType();

    /**
     * @return \Wiki\VendorsFaq\Api\Data\FaqDetailInterface[] 
     */
    public function getListDetail();


    /**
     * Set ID
     *
     * @param $id
     * @return $this
     */
    public function setId($id);

    /**
     * Set Vendor ID
     *
     * @param string $vendor
     * @return $this
     */
    public function setVendorId($vendor);

    /**
     * Set Title
     *
     * @param  string $title
     * @return $this
     */
    public function setTitle($title);


    /**
     * Set Type
     *
     * @param string $type
     * @return $this
     */
    public function setType($type);

    /**
     * Set List Detail of Faq
     *
     * @param \Wiki\VendorsFaq\Api\Data\FaqDetailInterface[] $listDetail
     * @return $this
     */
    public function setListDetail($listDetail);
}
