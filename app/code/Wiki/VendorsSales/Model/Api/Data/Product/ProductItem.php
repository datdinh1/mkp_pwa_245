<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Wiki\VendorsSales\Model\Api\Data\Product;
use Magento\Framework\Model\AbstractModel;
use Wiki\VendorsSales\Api\Data\Product\ProductItemInterface;


class ProductItem extends AbstractModel implements ProductItemInterface
{
    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getData(self::ID);
    }

    /**
     * @inheritdoc
     */
    public function setId($id)
    {
        return $this->setData(self::ID, $id);
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
