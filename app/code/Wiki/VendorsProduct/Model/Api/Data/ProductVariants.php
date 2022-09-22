<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Wiki\VendorsProduct\Model\Api\Data;

/**
 * Attribute Product Data model
 */
class ProductVariants extends \Magento\Framework\Model\AbstractModel implements \Wiki\VendorsProduct\Api\Data\ProductVariantsInterface
{
    /**
     * @inheritdoc
     */
    public function getAttributeId()
    {
        return $this->getData(self::ID);
    }

    /**
     * @inheritdoc
     */
    public function setAttributeId($id)
    {
        return $this->setData(self::ID, $id);
    }

     /**
     * @inheritdoc
     */
    public function getFrontendLabel()
    {
        return $this->getData(self::FRONTEND_LABEL);
    }

    /**
     * @inheritdoc
     */
    public function setFrontendLabel($label)
    {
        return $this->setData(self::FRONTEND_LABEL, $label);
    }

    /**
     * @inheritdoc
     */
    public function getAttributeCode()
    {
        return $this->getData(self::ATTRIBUTE_CODE);
    }

    /**
     * @inheritdoc
     */
    public function setAttributeCode($attr)
    {
        return $this->setData(self::ATTRIBUTE_CODE, $attr);
    }

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
    public function getOptions()
    {
        return $this->getData(self::OPTIONS);
    }

    /**
     * @inheritdoc
     */
    public function setOptions($options)
    {
        return $this->setData(self::OPTIONS, $options);
    }
}
