<?php
/**
 * Copyright © Wiki. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\VendorsSales\Model\Service;

use Magento\Framework\Exception\LocalizedException;
use Magento\Sales\Api\Data\InvoiceItemInterface;
use Magento\Sales\Api\Data\OrderItemInterface;
use Wiki\VendorsSales\Model\Order;

class InvoiceService extends \Magento\Sales\Model\Service\InvoiceService
{
    /**
     * @param Order $order
     * @param array $orderItemsQtyToInvoice
     * @return \Magento\Sales\Model\Order\Invoice
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function prepareVendorInvoice(Order $vendorOrder, array $orderItemsQtyToInvoice = [])
    {
        $isQtysEmpty = empty($orderItemsQtyToInvoice);
        $order = $vendorOrder->getOrder();
        $invoice = $this->orderConverter->toInvoice($order);
        $totalQty = 0;
        $vendorOrderItems = $vendorOrder->getAllItems();
        $preparedItemsQty = $this->prepareItemsQty($order, $orderItemsQtyToInvoice);

        foreach ($order->getAllItems() as $orderItem) {
            if (!$this->canInvoiceItem($orderItem, $preparedItemsQty)) {
                continue;
            }

            if ($orderItem->isDummy()) {
                $qty = $orderItem->getQtyOrdered() ? $orderItem->getQtyOrdered() : 1;
            } elseif (isset($preparedItemsQty[$orderItem->getId()])) {
                $qty = $preparedItemsQty[$orderItem->getId()];
            } elseif ($isQtysEmpty) {
                $qty = $orderItem->getQtyToInvoice();
            } else {
                $qty = 0;
            }
            if (!isset($vendorOrderItems[$orderItem->getId()])) {
                $qty = 0;
            }
            $item = $this->orderConverter->itemToInvoiceItem($orderItem);
            $totalQty += $qty;
            $this->setInvoiceItemQuantity($item, $qty);
            $invoice->addItem($item);
        }

        $invoice->setVendorOrder($vendorOrder);
        $invoice->setTotalQty($totalQty);
        $invoice->collectTotals();

        $order->getInvoiceCollection()->addItem($invoice);
        return $invoice;
    }

    /**
     * Check if order item can be invoiced.
     *
     * @param OrderItemInterface $item
     * @param array $qtys
     * @return bool
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    private function canInvoiceItem(OrderItemInterface $item, array $qtys)
    {
        if ($item->getLockedDoInvoice()) {
            return false;
        }
        if ($item->isDummy()) {
            if ($item->getHasChildren()) {
                foreach ($item->getChildrenItems() as $child) {
                    if (empty($qtys)) {
                        if ($child->getQtyToInvoice() > 0) {
                            return true;
                        }
                    } else {
                        if (isset($qtys[$child->getId()]) && $qtys[$child->getId()] > 0) {
                            return true;
                        }
                    }
                }
                return false;
            } elseif ($item->getParentItem()) {
                $parent = $item->getParentItem();
                if (empty($qtys)) {
                    return $parent->getQtyToInvoice() > 0;
                } else {
                    return isset($qtys[$parent->getId()]) && $qtys[$parent->getId()] > 0;
                }
            }
        } else {
            return $item->getQtyToInvoice() > 0;
        }
    }

    /**
     * Prepare qty to invoice for parent and child products if theirs qty is not specified in initial request.
     *
     * @param \Magento\Sales\Model\Order $order
     * @param array $orderItemsQtyToInvoice
     * @return array
     */
    private function prepareItemsQty(
        \Magento\Sales\Model\Order $order,
        array $orderItemsQtyToInvoice
    ) {
        foreach ($order->getAllItems() as $orderItem) {
            if (isset($orderItemsQtyToInvoice[$orderItem->getId()])) {
                if ($orderItem->isDummy() && $orderItem->getHasChildren()) {
                    $orderItemsQtyToInvoice = $this->setChildItemsQtyToInvoice($orderItem, $orderItemsQtyToInvoice);
                }
            } else {
                if (isset($orderItemsQtyToInvoice[$orderItem->getParentItemId()])) {
                    $orderItemsQtyToInvoice[$orderItem->getId()] =
                        $orderItemsQtyToInvoice[$orderItem->getParentItemId()];
                }
            }
        }

        return $orderItemsQtyToInvoice;
    }

    /**
     * Sets qty to invoice for children order items, if not set.
     *
     * @param OrderItemInterface $parentOrderItem
     * @param array $orderItemsQtyToInvoice
     * @return array
     */
    private function setChildItemsQtyToInvoice(
        OrderItemInterface $parentOrderItem,
        array $orderItemsQtyToInvoice
    ) {
        /** @var OrderItemInterface $childOrderItem */
        foreach ($parentOrderItem->getChildrenItems() as $childOrderItem) {
            if (!isset($orderItemsQtyToInvoice[$childOrderItem->getItemId()])) {
                $productOptions = $childOrderItem->getProductOptions();

                if (isset($productOptions['bundle_selection_attributes']) &&
                    class_exists('Magento\Framework\Serialize\Serializer\Json')) {
                    $jsonSerializer = \Magento\Framework\App\ObjectManager::getInstance()->get('Magento\Framework\Serialize\Serializer\Json');
                    $bundleSelectionAttributes = $jsonSerializer
                        ->unserialize($productOptions['bundle_selection_attributes']);
                    $orderItemsQtyToInvoice[$childOrderItem->getItemId()] =
                        $bundleSelectionAttributes['qty'] * $orderItemsQtyToInvoice[$parentOrderItem->getItemId()];
                } elseif (isset($productOptions['bundle_selection_attributes']) &&
                    !class_exists('Magento\Framework\Serialize\Serializer\Json')) {
                    $bundleSelectionAttributes = unserialize($productOptions['bundle_selection_attributes']);
                    $orderItemsQtyToInvoice[$childOrderItem->getItemId()] =
                        $bundleSelectionAttributes['qty'] * $orderItemsQtyToInvoice[$parentOrderItem->getItemId()];
                }
            }
        }

        return $orderItemsQtyToInvoice;
    }

    /**
     * Set quantity to invoice item.
     *
     * @param InvoiceItemInterface $item
     * @param float $qty
     * @return $this
     * @throws LocalizedException
     */
    protected function setInvoiceItemQuantity(InvoiceItemInterface $item, float $qty)
    {
        $qty = ($item->getOrderItem()->getIsQtyDecimal()) ? (double) $qty : (int) $qty;
        $qty = $qty > 0 ? $qty : 0;

        /**
         * Check qty availability
         */
        $qtyToInvoice = sprintf("%F", $item->getOrderItem()->getQtyToInvoice());
        $qty = sprintf("%F", $qty);
        if ($qty > $qtyToInvoice && !$item->getOrderItem()->isDummy()) {
            throw new LocalizedException(
                __('We found an invalid quantity to invoice item "%1".', $item->getName())
            );
        }

        $item->setQty($qty);

        return $this;
    }
}
