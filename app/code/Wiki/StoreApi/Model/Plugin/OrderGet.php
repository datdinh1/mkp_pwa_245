<?php
namespace Wiki\StoreApi\Model\Plugin;

use Magento\Framework\Exception\NoSuchEntityException;
use Wiki\StoreApi\Model\Api\Data\AddressFactory;

class OrderGet
{
     /**
     * @var AddressFactory
     */
    protected $addressFactory;

    /**
     * Init plugin
     *
     * @param \Magento\Sales\Api\Data\OrderItemExtensionFactory $orderItemExtensionFactory
     */
    public function __construct(
        AddressFactory          $addressFactory
    ){
        $this->addressFactory   = $addressFactory;
    }

    /**
     * @param \Magento\Sales\Api\OrderRepositoryInterface $subject
     * @param \Magento\Sales\Api\Data\OrderInterface $resultOrder
     * @return \Magento\Sales\Api\Data\OrderInterface
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterGet(
        \Magento\Sales\Api\OrderRepositoryInterface $subject,
        \Magento\Sales\Api\Data\OrderInterface $resultOrder
    ) {
        $resultOrder = $this->getOrderDistrict($resultOrder);
        return $resultOrder;
    }

    public function afterGetList(
        \Magento\Sales\Api\OrderRepositoryInterface $subject,
        \Magento\Sales\Model\ResourceModel\Order\Collection $resultOrder
    ) {
        /** @var  $order */
        foreach ($resultOrder->getItems() as $order) {
            $this->afterGet($subject, $order);
        }
        return $resultOrder;
    }

    /**
     * @param \Magento\Sales\Api\Data\OrderInterface $order
     * @return \Magento\Sales\Api\Data\OrderInterface
     */
    protected function getOrderDistrict(\Magento\Sales\Api\Data\OrderInterface $order)
    {
        $extensionAttributes = $order->getExtensionAttributes();
        if ($extensionAttributes && $extensionAttributes->getShippingAddress()) {
            return $order;
        }

        try {
            /** @var \Magento\Sales\Api\Data\OrderExtension $orderExtension */
            $orderExtension = $extensionAttributes ? $extensionAttributes : $this->orderExtensionFactory->create();
            $shippingDistrict = null;
            $billingDistrict = null;
            if ($order->getShippingAddress()) {
                $shipping = $this->addressFactory->create();
                $shipping->setDistrict($order->getShippingAddress()->getData('district'));
                $shipping->setSubDistrict($order->getShippingAddress()->getData('sub_district'));
                $orderExtension->setShippingAddress($shipping);
            }
            if ($order->getBillingAddress()) {
                $billing = $this->addressFactory->create();
                $billing->setDistrict($order->getBillingAddress()->getData('district'));
                $billing->setSubDistrict($order->getBillingAddress()->getData('sub_district'));
                $orderExtension->setBillingAddress($billing);
            }
            $order->setExtensionAttributes($orderExtension);
        } catch (NoSuchEntityException $e) {
            return $order;
        }      
        return $order;
    }
}
