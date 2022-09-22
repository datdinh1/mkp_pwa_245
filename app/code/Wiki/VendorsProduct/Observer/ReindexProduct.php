<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\VendorsProduct\Observer;

use Magento\Framework\Event\ObserverInterface;

class ReindexProduct implements ObserverInterface
{
    /**
     * @var CollectionFactory
     */
    protected $indexersFactory;
    
    public function __construct(
        \Magento\Indexer\Model\Indexer\CollectionFactory $indexersFactory
    ) {
        $this->indexersFactory = $indexersFactory;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     * @return self
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $product = $observer->getProduct();
        $indexers = $this->indexersFactory->create()->getItems();
        foreach ( $indexers as $indexer ){
            try {
                $indexer->reindexList([$product->getId()]);
            }
            catch ( \Exception $e ){
                continue;
            }
        }
        return $this;
    }
}
