<?php
namespace Wiki\StoreApi\Model\Api\Data;

use Magento\Framework\Model\AbstractModel;
use Wiki\StoreApi\Api\Data\DataProductOutStockInterface;

class DataProductOutStock extends AbstractModel implements DataProductOutStockInterface
{

    /**
     * @inheritdoc
     */
    public function getSku()
    {
        return $this->getData(self::SKU);
    }

    /**
     * @inheritdoc
     */
    public function setSku($sku)
    {
        return $this->setData(self::SKU, $sku);
    }

    /**
     * @inheritdoc
     */
    public function getIsInStock()
    {
        return $this->getData(self::IS_IN_STOCK);
    }

    /**
     * @inheritdoc
     */
    public function setIsInStock($isInStock)
    {
        return $this->setData(self::IS_IN_STOCK, $isInStock);
    }

    /**
     * @inheritdoc
     */
    public function getQty()
    {
        return $this->getData(self::QTY);
    }

    /**
     * @inheritdoc
     */
    public function setQty($qty)
    {
        return $this->setData(self::QTY, $qty);
    }
}