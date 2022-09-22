<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\StoreApi\Model\Api\Data;

use Magento\Framework\Model\AbstractModel;
use Wiki\StoreApi\Api\Data\SettingInterface;

class Setting extends AbstractModel implements SettingInterface
{
    /**
     * @inheritdoc
     */
    public function getSettingId()
    {
        return $this->getData('setting_id');
    }

    /**
     * @inheritdoc
     */
    public function setSettingId($settingId)
    {
        return $this->setData('setting_id', $settingId);
    }

    /**
     * @inheritdoc
     */
    public function getCode()
    {
        return $this->getData('code');
    }

    /**
     * @inheritdoc
     */
    public function setCode($code)
    {
        return $this->setData('code', $code);
    }

    /**
     * @inheritdoc
     */
    public function getLabel()
    {
        return $this->getData('label');
    }

    /**
     * @inheritdoc
     */
    public function setLabel($label)
    {
        return $this->setData('label', $label);
    }

    /**
     * @inheritdoc
     */
    public function getValue()
    {
        return $this->getData('value');
    }

    /**
     * @inheritdoc
     */
    public function setValue($value)
    {
        return $this->setData('value', $value);
    }
}
