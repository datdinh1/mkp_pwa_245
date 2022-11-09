<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\VendorsSales\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Catalog\Model\Product;

class QuoteItemSaveBefore implements ObserverInterface
{
    /**
     * @var \Magento\Framework\Event\ManagerInterface
     */
    protected $_eventManager;
    
    /**
     * @var Product
     */
    protected $productModel;
    
    public function __construct(
        \Magento\Framework\Event\ManagerInterface $eventManager,
        Product $productModel
    ) {
        $this->_eventManager = $eventManager;
        $this->productModel  = $productModel;
    }
    
    /**
     * Set Vendor Id for Quote Item if it's not exist
     * Set Weight Unit
     * Set Size Unit
     * @param \Magento\Framework\Event\Observer $observer
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $item = $observer->getItem();
        if (!$item->getVendorId()) {
            $vendorId = $item->getProduct()->getVendorId();
            $transport = new \Magento\Framework\DataObject(['vendor_id'=>$vendorId, 'item'=>$item]);
            $this->_eventManager->dispatch('ves_vendors_checkout_init_vendor_id', ['transport'=>$transport]);
            $vendorId = $transport->getVendorId();
            $item->setVendorId($vendorId);
        }

        try {
            $product = $this->productModel->load($item->getProduct()->getId());
            /** Set Weight Unit */
            if ( $product->getResource()->getAttribute('product_weight_unit') ){
                $item->setWeightUnit($product->getAttributeText('product_weight_unit'));
            }
            
            /** * Set Size Unit */
            if ( $product->getResource()->getAttribute('product_size_unit') ){
                $item->setWeightUnit($product->getAttributeText('product_size_unit'));
            }
        }
        catch ( \Exception $e ){}

        return $this;
    }
}
