<?php

namespace Wiki\VendorsProduct\Api\Data;


interface ProductVariantsInterface
{
    /**
     * Constants used as data array keys
     */
    const ID                  = 'attribute_id';
    const ATTRIBUTE_CODE      = 'attribute_code';
    const LABEL               = 'label';
    const OPTIONS             = 'options';
    const FRONTEND_LABEL      = 'frontend_label';

    /**
     * Get id
     *
     * @return int
     */
    public function getAttributeId();

    /**
     * Set id
     *
     * @param int $id
     *
     * @return $this
     */
    public function setAttributeId($id);

     /**
     * Get Frontend Label
     *
     * @return string
     */
    public function getFrontendLabel();

    /**
     * Set Frontend Label
     *
     * @param string $label
     *
     * @return $this
     */
    public function setFrontendLabel($label);

    /**
     * Get Attribute Code
     *
     * @return string
     */
    public function getAttributeCode();

    /**
     * Set Attribute Code
     *
     * @param string $attr
     *
     * @return $this
     */
    public function setAttributeCode($attr);

     /**
     * Get Label
     *
     * @return string|null
     */
    public function getLabel();

    /**
     * Set Label
     *
     * @param string|null $label
     *
     * @return $this
     */
    public function setLabel($label);

    /**
     * Get Options.
     *
     * @return \Wiki\VendorsProduct\Api\Data\AttributeProductInterface[]
     */
    public function getOptions();

    /**
     * Set Options
     *
     * @param \Wiki\VendorsProduct\Api\Data\AttributeProductInterface[] $options
     *
     * @return $this
     */
    public function setOptions($options);
}
