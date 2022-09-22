<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\StoreApi\Api\Data;

/**
 * Interface ShippingMethodInterface
 */
interface ShippingMethodInterface
{
    const CARRIER_CODE  = 'carrier_code';
    const CARRIER_TITLE = 'carrier_title';
    const METHOD_TITLE  = 'method_title';
    const LOGO_SHIPPOP  = 'logo_shippop';

    /**
     * Returns the shipping carrier code.
     * @return string|null Shipping carrier code.
     */
    public function getCarrierCode();

    /**
     * Sets the shipping carrier code.
     * @param string|null $carrierCode
     * @return $this
     */
    public function setCarrierCode($carrierCode);

    /**
     * Returns the shipping carrier title.
     * @return string|null Shipping carrier title. Otherwise, null.
     */
    public function getCarrierTitle();

    /**
     * Sets the shipping carrier title.
     * @param string|null $carrierTitle
     * @return $this
     */
    public function setCarrierTitle($carrierTitle);

    /**
     * Returns the shipping method title.
     * @return string|null Shipping method title. Otherwise, null.
     */
    public function getMethodTitle();

    /**
     * Sets the shipping method title.
     * @param string|null $methodTitle
     * @return $this
     */
    public function setMethodTitle($methodTitle);

    /**
     * Returns the shipping logo shippop.
     * @return string|null Shipping method code.
     */
    public function getLogoShippop();

    /**
     * Sets the shipping logo shippop.
     * @param string|null $logo
     * @return $this
     */
    public function setLogoShippop($logo);
}
