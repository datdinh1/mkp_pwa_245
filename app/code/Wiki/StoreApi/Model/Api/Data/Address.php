<?php
namespace Wiki\StoreApi\Model\Api\Data;

use Magento\Framework\Model\AbstractExtensibleModel;
use Wiki\StoreApi\Api\Data\AddressInterface;

/**
 * @codeCoverageIgnoreStart
 */
class Address extends AbstractExtensibleModel implements AddressInterface
{
    /**
     * @{inheritdoc}
     */
    public function getDistrict()
    {
        return $this->getData(self::DISTRICT);
    }

    /**
     * @{inheritdoc}
     */
    public function setDistrict($district)
    {
        return $this->setData(self::DISTRICT, $district);
    }

    /**
     * @{inheritdoc}
     */
    public function getSubDistrict()
    {
        return $this->getData(self::SUB_DISTRICT);
    }

    /**
     * @{inheritdoc}
     */
    public function setSubDistrict($subDistrict)
    {
        return $this->setData(self::SUB_DISTRICT, $subDistrict);
    }
}
