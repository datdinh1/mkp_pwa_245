<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\VendorsProduct\Model\ResourceModel\Entity\Attribute;

use \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * App page collection
 */
class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'entity_attribute_id';


    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Wiki\VendorsProduct\Model\Entity\Attribute', 'Wiki\VendorsProduct\Model\ResourceModel\Entity\Attribute');
    }

    /**
     * Set Attribute Group Filter
     * @param \Wiki\VendorsProduct\Model\Entity\Attribute\Group|int|string $group
     * @return \Wiki\VendorsProduct\Model\ResourceModel\Entity\Attribute\Collection
     */
    public function setAttributeGroupFilter($group)
    {
        $groupId = $group;
        if ($group instanceof \Wiki\VendorsProduct\Model\Entity\Attribute\Group) {
            $groupId = $group->getId();
        }
        $this->addFieldToFilter('attribute_group_id', $groupId);
        return $this;
    }
    
    /**
     * Set Attribute Group Filter
     * @param \Wiki\VendorsProduct\Model\Entity\Attribute\Set|int|string $set
     * @return \Wiki\VendorsProduct\Model\ResourceModel\Entity\Attribute\Collection
     */
    public function setAttributeSetFilter($set)
    {
        $setId = $set;
        if ($set instanceof \Wiki\VendorsProduct\Model\Entity\Attribute\Set) {
            $setId = $set->getId();
        }
        $this->addFieldToFilter('attribute_set_id', $setId);
        return $this;
    }
}
