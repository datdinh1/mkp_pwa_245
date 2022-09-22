<?php
namespace Wiki\VendorsCustomTheme\Model\Source;

class BackgroundRepeatImage extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
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
                ['label' => __("Left Top"), 'value' => "Left Top"],
                ['label' => __("Middle Top"), 'value' => "Middle Top"],
                ['label' => __("Right Top"), 'value' => "Right Top"],
                ['label' => __("Left Middle"), 'value' => "Left Middle"],
                ['label' => __("Center"), 'value' => "Center"],
                ['label' => __("Left Middle"), 'value' => "Left Middle"],
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
