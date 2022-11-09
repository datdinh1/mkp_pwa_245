<?php
namespace Wiki\VendorsChat\Model\Api;

use Magento\Framework\Model\AbstractModel;
use Wiki\VendorsChat\Api\Data\DataMessageItemsInterface;

class DataMessageItems extends AbstractModel implements DataMessageItemsInterface
{
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
    public function getTotal()
    {
        return $this->getData(self::TOTAL_COUNT);
    }

    /**
     * @inheritdoc
     */
    public function setTotal($totalCount)
    {
        return $this->setData(self::TOTAL_COUNT, $totalCount);
    }
}