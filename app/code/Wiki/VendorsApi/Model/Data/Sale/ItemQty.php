<?php

namespace Wiki\VendorsApi\Model\Data\Sale;

use Magento\Framework\Model\AbstractModel;

/**
 * Class vendor
 * @SuppressWarnings(PHPMD.ExcessivePublicCount)
 */
class ItemQty extends AbstractModel implements
    \Wiki\VendorsApi\Api\Data\Sale\ItemQtyInterface
{
    /**
     * @return int
     */
    public function getItemId(){
        return $this->_getData(self::ITEM_ID);
    }

    /**
     * @return float
     */
    public function getQty(){
        return $this->_getData(self::QTY);
    }

    /**
     * @param int $id
     * @return \Wiki\VendorsApi\Api\Data\Sale\ItemQtyInterface
     */
    public function setItemId($id){
        return $this->setData(self::ITEM_ID, $id);
    }

    /**
     * @param float $qty
     * @return \Wiki\VendorsApi\Api\Data\Sale\ItemQtyInterface
     */
    public function setQty($qty){
        return $this->setData(self::QTY, $qty);
    }

}


