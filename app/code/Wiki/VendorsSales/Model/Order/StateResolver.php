<?php

namespace Wiki\VendorsSales\Model\Order;

use Magento\Sales\Model\Order;

/**
 * Class OrderStateResolver
 */
class StateResolver
{
    const IN_PROGRESS = 'order_in_progress';
    const FORCED_CREDITMEMO = 'forced_creditmemo';

    /**
     * Check if order should be in complete state
     *
     * @param \Wiki\VendorsSales\Model\Order $order
     * @return bool
     */
    private function isOrderComplete(\Wiki\VendorsSales\Model\Order $order)
    {
        /** @var $order Order|\Wiki\VendorsSales\Model\Order */
        if (0 == $order->getBaseGrandTotal() || $order->canCreditmemo()) {
            return true;
        }
        return false;
    }

    /**
     * Check if order should be in closed state
     *
     * @param \Wiki\VendorsSales\Model\Order $order
     * @param array $arguments
     * @return bool
     */
    private function isOrderClosed(\Wiki\VendorsSales\Model\Order $order, $arguments)
    {
        /** @var $order Order|\Wiki\VendorsSales\Model\Order */
        $forceCreditmemo = in_array(self::FORCED_CREDITMEMO, $arguments);
        if ((float)$order->getTotalRefunded() || !$order->getTotalRefunded() && $forceCreditmemo) {
            return true;
        }
        return false;
    }

    /**
     * Check if order is processing
     *
     * @param \Wiki\VendorsSales\Model\Order $order
     * @param array $arguments
     * @return bool
     */
    private function isOrderProcessing(\Wiki\VendorsSales\Model\Order $order, $arguments)
    {
        /** @var $order Order|\Wiki\VendorsSales\Model\Order */
        if ($order->getState() == Order::STATE_NEW && in_array(self::IN_PROGRESS, $arguments)) {
            return true;
        }
        return false;
    }

    /**
     * Returns initial state for order
     *
     * @param \Wiki\VendorsSales\Model\Order $order
     * @return string
     */
    private function getInitialOrderState(\Wiki\VendorsSales\Model\Order $order)
    {
        return $order->getState() === Order::STATE_PROCESSING ? Order::STATE_PROCESSING : Order::STATE_NEW;
    }

    /**
     * @param \Wiki\VendorsSales\Model\Order $order
     * @param array $arguments
     * @return string
     */
    public function getStateForOrder(\Wiki\VendorsSales\Model\Order $order, array $arguments = [])
    {
        /** @var $order Order|\Wiki\VendorsSales\Model\Order */
        $orderState = $this->getInitialOrderState($order);
        if (!$order->isCanceled() && !$order->canUnhold() && !$order->canInvoice() && !$order->canShip()) {
            if ($this->isOrderComplete($order)) {
                $orderState = Order::STATE_COMPLETE;
            } elseif ($this->isOrderClosed($order, $arguments)) {
                $orderState = Order::STATE_CLOSED;
            }
        }
        if ($this->isOrderProcessing($order, $arguments)) {
            $orderState = Order::STATE_PROCESSING;
        }
        return $orderState;
    }
}
