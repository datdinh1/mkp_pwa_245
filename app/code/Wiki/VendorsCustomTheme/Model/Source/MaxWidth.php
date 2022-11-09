<?php
namespace Wiki\VendorsCustomTheme\Model\Source;

class MaxWidth extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{
    /**
     * Options array
     *
     * @var array
     */
    protected $_options = null;
    
    /**
     * Retrieve all options array
     *
     * @return array
     */
    public function getAllOptions()
    {
        if ($this->_options === null) {
            $this->_options = [
                ['label' => __("1024px"), 'value' => "width1024"],
                ['label' => __("1200px"), 'value' => "width1200"],
                ['label' => __("1366px"), 'value' => "width1366"],
                ['label' => __("Full Width"), 'value' => "fullwidth"],
            ];
        }
        return $this->_options;
    }

    /**
     * Retrieve option array
     *
     * @return array
     */
    public function getOptionArray()
    {
        $_options = [];
        foreach ($this->getAllOptions() as $option) {
            $_options[$option['value']] = $option['label'];
        }
        return $_options;
    }
    
    
    /**
     * Get options as array
     *
     * @return array
     * @codeCoverageIgnore
     */
    public function toOptionArray()
    {
        return $this->getAllOptions();
    }
}
