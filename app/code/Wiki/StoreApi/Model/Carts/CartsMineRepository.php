<?php
namespace Wiki\StoreApi\Model\Carts;

use Wiki\StoreApi\Api\CartsMineInterface;
use Wiki\StoreApi\Model\Api\Data\DataProductOutStockFactory;
use Magento\Quote\Model\Quote\Item\Repository;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Quote\Api\Data\CartItemInterface;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollection;
use Magento\Quote\Model\QuoteIdMaskFactory;
use Magento\Quote\Model\QuoteFactory;

/** magento >= v2.3 */
use Magento\InventorySalesAdminUi\Model\GetSalableQuantityDataBySku;

class CartsMineRepository implements CartsMineInterface
{
    /**
     * @var DataProductOutStockFactory
     */
    protected $dataProductOutStockFactory;

    /**
     * @var Repository
     */
    protected $cartRepository;

    /**
     * @var CartRepositoryInterface
     */
    protected $quoteRepository;

    /**
     * @var ProductCollection
     */
    protected $productCollection;

    /**
     * @var QuoteIdMaskFactory
     */
    protected $quoteIdMaskFactory;

    /**
     * @var QuoteFactory
     */
    protected $quoteFactory;
    
    /**
     * @var GetSalableQuantityDataBySku
     */
    protected $getSalableQuantity;

    public function __construct(
        DataProductOutStockFactory          $dataProductOutStockFactory,
        Repository                          $cartRepository,
        CartRepositoryInterface             $quoteRepository,
        ProductCollection                   $productCollection,
        QuoteIdMaskFactory                  $quoteIdMaskFactory,
        QuoteFactory                        $quoteFactory,
        GetSalableQuantityDataBySku         $getSalableQuantity
    ) {
        $this->dataProductOutStockFactory   = $dataProductOutStockFactory;
        $this->cartRepository               = $cartRepository;
        $this->quoteRepository              = $quoteRepository;
        $this->productCollection            = $productCollection;
        $this->quoteIdMaskFactory           = $quoteIdMaskFactory;
        $this->quoteFactory                 = $quoteFactory;
        $this->getSalableQuantity           = $getSalableQuantity;
    }

    /**
     * @param int $cartId
     * @param CartItemInterface[] $cartItems
     * @return string[]
     */
    public function addCartMultiProduct($cartId, $cartItems)
    {
        try {
            $quote = $this->quoteFactory->create()->loadByIdWithoutStore($cartId);
            if ( !$quote->getData() ){
                $quote = $this->quoteRepository->get($cartId);
            }
        }
        catch ( \Exception $e ){
            return false;
        }
        return $this->_addCart($quote, $cartItems);
    }

    /**
     * @param string $cartId
     * @param CartItemInterface[] $cartItems
     * @return string[]
     */
    public function addGuestCartMultiProduct($cartId, $cartItems)
    {
        try {
            $quoteIdMask = $this->quoteIdMaskFactory->create()->load($cartId, 'masked_id');
            $quote = $this->quoteFactory->create()->loadByIdWithoutStore($quoteIdMask->getQuoteId());
            if ( !$quote->getData() ){
                $quote = $this->quoteRepository->get($quoteIdMask->getQuoteId());
            }
        }
        catch ( \Exception $e ){
            return false;
        }
        return $this->_addCart($quote, $cartItems);
    }

    public function _addCart($quote, $cartItems)
    {
        // $quote->removeAllItems();
        $result = $quoteItems = [];
        foreach ( $cartItems as $item ){
            $collection = $this->productCollection->create()
                ->addFieldToFilter('sku', $item->getSku())
                ->joinField('qty', 'cataloginventory_stock_item', 'qty', 'product_id=entity_id', '{{table}}.stock_id=1', 'left')
                ->joinTable('cataloginventory_stock_item', 'product_id=entity_id', array('is_in_stock' => 'is_in_stock'))
                ->addAttributeToSelect('is_in_stock')
                ->getLastItem();

            if ( $collection->getData() ){
                /** magento >= v2.3 */
                $salable = $this->getSalableQuantity->execute($item->getSku());
                $collection->setQty($salable[0]['qty']);

                if ( $item->getQty() <  $collection->getQty() && $collection->getIsInStock() ){
                    $item->setQuoteId($quote->getQuoteId());
                    $quoteItems[] = $item;
                    continue;
                }
            }
            $data = $this->dataProductOutStockFactory->create();
            $data->setData($collection->getData() ? : ['sku' => $item->getSku()]);
            $result[] = $data;
        }
        $quote->setItems($quoteItems);
        $this->quoteRepository->save($quote);
        $quote->collectTotals();
        
        return $result;
    }

    public function removeAllItems($cartId)
    {
        try {
            $quote = $this->quoteFactory->create()->loadByIdWithoutStore($cartId);
            if ( !$quote->getData() ){
                $quote = $this->quoteRepository->get($cartId);
            }
            $quote->removeAllItems()->save();
        }
        catch ( \Exception $e ){
            return false;
        }
        return true;
    }

    public function removeGuestCartAllItems($cartId)
    {
        try {
            $quoteIdMask = $this->quoteIdMaskFactory->create()->load($cartId, 'masked_id');
            $quote = $this->quoteFactory->create()->loadByIdWithoutStore($quoteIdMask->getQuoteId());
            if ( !$quote->getData() ){
                $quote = $this->quoteRepository->get($quoteIdMask->getQuoteId());
            }
            $quote->removeAllItems()->save();
        }
        catch ( \Exception $e ){
            return false;
        }
        return true;
    }
}