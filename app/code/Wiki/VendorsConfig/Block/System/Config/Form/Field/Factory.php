<?php
namespace Wiki\VendorsConfig\Block\System\Config\Form\Field;

class Factory extends \Magento\Config\Block\System\Config\Form\Field\Factory
{
    /**
     * 
     * @param array $data
     */
    public function create(array $data = [])
    {
        return $this->_objectManager->create('Wiki\VendorsConfig\Block\System\Config\Form\Field', $data);
    }
}
