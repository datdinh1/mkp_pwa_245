<?php

namespace Wiki\VendorsLayerNavigation\Model\Layer\VendorHomePage;

class FilterableAttributeList extends \Magento\Catalog\Model\Layer\Category\FilterableAttributeList
{
    public function getList()
    {
        $collection = parent::getList();

       // $collection->addFieldToFilter('main_table.attribute_code', ['notlike' => '%category_ids%']);

        return $collection;
    }
}