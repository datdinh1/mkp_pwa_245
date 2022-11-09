<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\VendorsProduct\Observer;

use Magento\Framework\Event\ObserverInterface;
use Wiki\VendorsProduct\Helper\Data;

class AddSoldProduct implements ObserverInterface
{
    /**
     * @var Data
     */
    protected $helperData;
    
    public function __construct(
        Data                    $helperData
    ) {
        $this->helperData       = $helperData;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     * @return self
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $product = $observer->getProduct();
        try {
            $product->setCustomAttribute("sold", $this->helperData->getSoldQtyByProductId($product->getId()));
        }
        catch ( \Exception $e ){}
        return $this;
    }
}
