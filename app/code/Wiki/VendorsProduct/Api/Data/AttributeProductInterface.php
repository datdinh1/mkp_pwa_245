<?php

namespace Wiki\VendorsProduct\Api\Data;


interface AttributeProductInterface
{
    /**
     * Constants used as data array keys
     */
    const LABEL      = 'label';
    const VALUE      = 'value';

    /**
     * Get Label
     *
     * @return string
     */
    public function getLabel();

    /**
     * Set Label
     *
     * @param string $label
     *
     * @return $this
     */
    public function setLabel($label);

    /**
     * Get Value
     *
     * @return string|null
     */
    public function getValue();

    /**
     * Set Value
     *
     * @param string|null $value
     *
     * @return $this
     */
    public function setValue($value);

}
