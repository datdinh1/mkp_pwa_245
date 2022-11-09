<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Wiki\VendorsProduct\Model\Api\Data;

/**
 * Attribute Product Data model
 */
class AttributeProduct extends \Magento\Framework\Model\AbstractModel implements \Wiki\VendorsProduct\Api\Data\AttributeProductInterface
{
    /**
     * @inheritdoc
     */
    public function getLabel()
    {
        return $this->getData(self::LABEL);
    }

    /**
     * @inheritdoc
     */
    public function setLabel($label)
    {
        return $this->setData(self::LABEL, $label);
    }

    /**
     * @inheritdoc
     */
    public function getValue()
    {
        return $this->getData(self::VALUE);
    }

    /**
     * @inheritdoc
     */
    public function setValue($value)
    {
        return $this->setData(self::VALUE, $value);
    }   
}
