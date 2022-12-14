<?php
/**
 * Copyright © Wiki, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\VendorsSales\Model\Order;

use Magento\Sales\Api\Data\ShipmentInterface;
use Magento\Sales\Api\Data\ShipmentItemCreationInterface;
use Magento\Sales\Api\Data\ShipmentPackageCreationInterface;
use Magento\Sales\Api\Data\ShipmentTrackCreationInterface;
use Magento\Framework\EntityManager\HydratorPool;
use Magento\Sales\Model\Order\Shipment\TrackFactory;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\Data\ShipmentCommentCreationInterface;
use Magento\Sales\Api\Data\ShipmentCreationArgumentsInterface;
use Magento\Sales\Api\Data\OrderItemInterface;
use Magento\Sales\Model\Order\Shipment;

/**
 * Class ShipmentDocumentFactory
 *
 *
 */
class ShipmentDocumentFactory
{
    /**
     * @var ShipmentFactory
     */
    private $shipmentFactory;

    /**
     * @var TrackFactory
     */
    private $trackFactory;

    /**
     * @var HydratorPool
     */
    private $hydratorPool;

    /**
     * ShipmentDocumentFactory constructor.
     *
     * @param ShipmentFactory $shipmentFactory
     * @param HydratorPool $hydratorPool
     * @param TrackFactory $trackFactory
     */
    public function __construct(
        ShipmentFactory $shipmentFactory,
        HydratorPool $hydratorPool,
        TrackFactory $trackFactory
    ) {
        $this->shipmentFactory = $shipmentFactory;
        $this->trackFactory = $trackFactory;
        $this->hydratorPool = $hydratorPool;
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     *
     * @param \Wiki\VendorsSales\Model\Order $order
     * @param ShipmentItemCreationInterface[] $items
     * @param ShipmentTrackCreationInterface[] $tracks
     * @param ShipmentCommentCreationInterface|null $comment
     * @param bool $appendComment
     * @param ShipmentPackageCreationInterface[] $packages
     * @param ShipmentCreationArgumentsInterface|null $arguments
     * @return ShipmentInterface
     * @since 100.1.2
     */
    public function create(
        $order,
        array $items = [],
        array $tracks = [],
        ShipmentCommentCreationInterface $comment = null,
        $appendComment = false,
        array $packages = [],
        ShipmentCreationArgumentsInterface $arguments = null
    ) {
        $shipmentItems = empty($items)
            ? $this->getQuantitiesFromOrderItems($order->getAllItems())
            : $this->getQuantitiesFromShipmentItems($items);

        /** @var Shipment $shipment */
        $shipment = $this->shipmentFactory->createVendorShipment(
            $order,
            $shipmentItems
        );

        foreach ($tracks as $track) {
            $hydrator = $this->hydratorPool->getHydrator(
                \Magento\Sales\Api\Data\ShipmentTrackCreationInterface::class
            );
            $shipment->addTrack($this->trackFactory->create(['data' => $hydrator->extract($track)]));
        }

        if ($comment) {
            $shipment->addComment(
                $comment->getComment(),
                $appendComment,
                $comment->getIsVisibleOnFront()
            );

            if ($appendComment) {
                $shipment->setCustomerNote($comment->getComment());
                $shipment->setCustomerNoteNotify($appendComment);
            }
        }

        return $shipment;
    }

    /**
     * Translate OrderItemInterface array to product id => product quantity array.
     *
     * @param OrderItemInterface[] $items
     * @return int[]
     */
    private function getQuantitiesFromOrderItems(array $items)
    {
        $shipmentItems = [];
        foreach ($items as $item) {
            if (!$item->getIsVirtual() && (!$item->getParentItem() || $item->isShipSeparately())) {
                $shipmentItems[$item->getItemId()] = $item->getQtyOrdered();
            }
        }
        return $shipmentItems;
    }

    /**
     * Translate ShipmentItemCreationInterface array to product id => product quantity array.
     *
     * @param ShipmentItemCreationInterface[] $items
     * @return int[]
     */
    private function getQuantitiesFromShipmentItems(array $items)
    {
        $shipmentItems = [];
        foreach ($items as $item) {
            $shipmentItems[$item->getOrderItemId()] = $item->getQty();
        }
        return $shipmentItems;
    }
}
