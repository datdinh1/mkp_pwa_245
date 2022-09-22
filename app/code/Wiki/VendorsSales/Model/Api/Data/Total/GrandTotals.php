<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Wiki\VendorsSales\Model\Api\Data\Total;
use Magento\Framework\Model\AbstractModel;
use Wiki\VendorsSales\Api\Data\Total\GrandTotalsInterface;


class GrandTotals extends AbstractModel implements GrandTotalsInterface
{
    /**
     * @inheritdoc
     */
    public function getVendorId()
    {
        return $this->getData(self::VENDOR_ID);
    }

    /**
     * @inheritdoc
     */
    public function setVendorId($vendorId)
    {
        return $this->setData(self::VENDOR_ID, $vendorId);
    }

    /**
     * @inheritdoc
     */
    public function getTotals()
    {
        return $this->getData(self::TOTALS);
    }

    /**
     * @inheritdoc
     */
    public function setTotals($totals)
    {
        return $this->setData(self::TOTALS, $totals);
    }
}
