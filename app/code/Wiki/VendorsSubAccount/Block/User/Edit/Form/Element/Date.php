<?php

namespace Wiki\VendorsSubAccount\Block\User\Edit\Form\Element;

use Magento\Framework\Escaper;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;

/**
 * Date element
 */
class Date extends \Magento\Framework\Data\Form\Element\Date
{
    /**
     * Set date value
     *
     * @param mixed $value
     * @return $this
     */
    public function setValue($value)
    {
        $this->_value = $value;
        return $this;
    }

    /**
     * Get date value as string.
     *
     * Format can be specified, or it will be taken from $this->getFormat()
     *
     * @param string $format (compatible with \DateTime)
     * @return string
     */
    public function getValue($format = null)
    {
        return date('Y-m-d', strtotime($this->_value));
    }
}
