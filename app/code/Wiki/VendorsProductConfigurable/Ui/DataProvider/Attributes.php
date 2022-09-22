<?php

namespace Wiki\VendorsProductConfigurable\Ui\DataProvider;

class Attributes extends \Magento\ConfigurableProduct\Ui\DataProvider\Attributes
{
    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        $notAllowedAttribute = $this->getProductHelper()->getNotUsedVendorAttributes();
        
        $items = [];
        $skippedItems = 0;
        foreach ($this->getCollection()->getItems() as $attribute) {
            if ($this->configurableAttributeHandler->isAttributeApplicable($attribute)) {
                if(in_array($attribute->getAttributeCode(), $notAllowedAttribute)) continue;
                $items[] = $attribute->toArray();
            } else {
                $skippedItems++;
            }
        }
        return [
            'totalRecords' => $this->collection->getSize() - $skippedItems,
            'items' => $items
        ];
    }
    
    
    /**
     * @return \Wiki\VendorsProduct\Helper\Data
     */
    public function getProductHelper(){
        return \Magento\Framework\App\ObjectManager::getInstance()->get('Wiki\VendorsProduct\Helper\Data');
    }
}
