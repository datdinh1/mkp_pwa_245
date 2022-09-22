<?php
namespace Wiki\VendorsCoupon\Model\Api;

use Magento\Framework\Model\AbstractModel;
use Wiki\VendorsCoupon\Api\Data\ItemsInterface;

class Items extends AbstractModel implements ItemsInterface
{
     /**
     * @inheritdoc
     */
    public function getCategory()
    {
        return $this->getData(self::CATEGORY);
    }

    /**
     * @inheritdoc
     */
    public function setCategory($category)
    {
        return $this->setData(self::CATEGORY, $category);
    }

    /**
     * @inheritdoc
     */
    public function getItems()
    {
        return $this->getData(self::ITEMS);
    }

    /**
     * @inheritdoc
     */
    public function setItems($items)
    {
        return $this->setData(self::ITEMS, $items);
    }

    /**
     * @inheritdoc
     */
    public function getTotalCount()
    {
        return $this->getData(self::TOTAL_COUNT);
    }

    /**
     * @inheritdoc
     */
    public function setTotalCount($totalCount)
    {
        return $this->setData(self::TOTAL_COUNT, $totalCount);
    }
}