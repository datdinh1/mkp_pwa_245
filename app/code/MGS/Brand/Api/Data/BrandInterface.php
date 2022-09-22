<?php

namespace MGS\Brand\Api\Data;


interface BrandInterface
{
    /**
     * @return int/null
     */
    public function getBrandId();

    /**
     * @param int $brandId
     * @return $this
     */
    public function setBrandId($brandId);
    /**
     * @return string/null
     */
    public function getName();

    /**
     * @param string $name
     * @return $this
     */
    public function setName($name);
    /**
     * @return string/null
     */
    public function getUrlKey();

    /**
     * @param string $urlKey
     * @return $this
     */
    public function setUrlKey($urlKey);
    /**
     * @return string/null
     */
    public function getSmallImage();

    /**
     * @param string $smallImage
     * @return $this
     */
    public function setSmallImage($smallImage);
    /**
     * @return string/null
     */
    public function getImage();

    /**
     * @param string $image
     * @return $this
     */
    public function setImage($image);
    /**
     * @return string/null
     */
    public function getDescription();

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription($description);
    /**
     * @return string/null
     */
    public function getMetaKeywords();

    /**
     * @param string $metaKeywords
     * @return $this
     */
    public function setMetaKeywords($metaKeywords);
    /**
     * @return string/null
     */
    public function getMetaDescription();

    /**
     * @param string $metaDescription
     * @return $this
     */
    public function setMetaDescription($metaDescription);
    /**
     * @return int/null
     */
    public function getStatus();

    /**
     * @param int $status
     * @return $this
     */
    public function setStatus($status);
    /**
     * @return int/null
     */
    public function getIsFeatured();

    /**
     * @param int $isFeatured
     * @return $this
     */
    public function setIsFeatured($isFeatured);
    /**
     * @return int/null
     */
    public function getSortOrder();

    /**
     * @param int $sortOrder
     * @return $this
     */
    public function setSortOrder($sortOrder);
    /**
     * @return int/null
     */
    public function getOptionId();

    /**
     * @param int $optionId
     * @return $this
     */
    public function setOptionId($optionId);

    /**
     * @return mixed/null
     */
    public function getProductIds();

    /**
     * @param mixed $productIds
     * @return $this
     */
    public function setProductIds($productIds);
}