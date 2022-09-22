<?php
namespace Wiki\StoreApi\Model\Api\Data;

use Magento\Framework\Model\AbstractModel;
use Wiki\StoreApi\Api\Data\ShippingMethodInterface;

class ShippingMethod extends AbstractModel implements ShippingMethodInterface
{

    /**
     * @inheritdoc
     */
    public function getCarrierCode()
    {
        return $this->getData(self::CARRIER_CODE);
    }

    /**
     * @inheritdoc
     */
    public function setCarrierCode($carrierCode)
    {
        return $this->setData(self::CARRIER_CODE, $carrierCode);
    }

    /**
     * @inheritdoc
     */
    public function getCarrierTitle()
    {
        return $this->getData(self::CARRIER_TITLE);
    }

    /**
     * @inheritdoc
     */
    public function setCarrierTitle($carrierTitle)
    {
        return $this->setData(self::CARRIER_TITLE, $carrierTitle);
    }

    /**
     * @inheritdoc
     */
    public function getMethodTitle()
    {
        return $this->getData(self::METHOD_TITLE);
    }

    /**
     * @inheritdoc
     */
    public function setMethodTitle($methodTitle)
    {
        return $this->setData(self::METHOD_TITLE, $methodTitle);
    }

    /**
     * @inheritdoc
     */
    public function getLogoShippop()
    {
        return $this->getData(self::LOGO_SHIPPOP);
    }

    /**
     * @inheritdoc
     */
    public function setLogoShippop($logo)
    {
        return $this->setData(self::LOGO_SHIPPOP, $logo);
    }
}
