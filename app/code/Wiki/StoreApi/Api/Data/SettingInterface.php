<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\StoreApi\Api\Data;

interface SettingInterface
{
    /**
     * @return string|int
     */
    public function getSettingId();

    /**
     * @param string|int $settingId
     * @return $this
     */
    public function setSettingId($settingId);

    /**
     * @return string|null 
     */
    public function getCode();

    /**
     * @param string $code
     * @return $this
     */
    public function setCode($code);

    /**
     * @return string|null
     */
    public function getLabel();

    /**
     * @param string $label
     * @return $this
     */
    public function setLabel($label);

    /**
     * @return string|null
     */
    public function getValue();

    /**
     * @param string $value
     * @return $this
     */
    public function setValue($value);
}
