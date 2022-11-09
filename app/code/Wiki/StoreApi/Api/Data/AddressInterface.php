<?php
namespace Wiki\StoreApi\Api\Data;

interface AddressInterface
{
    /**
     * Constants defined for keys of array, makes typos less likely
     */
    const DISTRICT         = 'district';
    const SUB_DISTRICT     = 'sub_district';
    /**
     * @return string|null
     */
    public function getDistrict();

    /**
     * @param string|null
     * @return $this
     */
    public function setDistrict($district);

    /**
     * @return string|null
     */
    public function getSubDistrict();

    /**
     * @param string|null
     * @return $this
     */
    public function setSubDistrict($subDistrict);

}
