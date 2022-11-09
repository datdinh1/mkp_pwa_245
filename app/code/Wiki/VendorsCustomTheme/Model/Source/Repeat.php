<?php
namespace Wiki\VendorsCustomTheme\Model\Source;

class Repeat extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
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
                ['label' => __("No Repeat"), 'value' => "No Repeat"],
                ['label' => __("Repeat"), 'value' => "Repeat"],
                ['label' => __("Repeat X"), 'value' => "Repeat X"],
                ['label' => __("Repeat Y"), 'value' => "Repeat Y"],
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
