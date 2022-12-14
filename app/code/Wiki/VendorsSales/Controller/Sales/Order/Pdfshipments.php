<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\VendorsSales\Controller\Sales\Order;

use Magento\Framework\App\ResponseInterface;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Wiki\Vendors\App\Action\Frontend\Context;
use Magento\Framework\App\Response\Http\FileFactory;
use Magento\Ui\Component\MassAction\Filter;
use Wiki\VendorsSales\Model\Order\Pdf\Shipment;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Sales\Model\ResourceModel\Order\Shipment\CollectionFactory as ShipmentCollectionFactory;
use Wiki\VendorsSales\Model\ResourceModel\Order\CollectionFactory;
use Wiki\VendorsSales\Controller\Sales\Order\AbstractMassAction;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Pdfshipments extends AbstractMassAction
{
    /**
     * @var FileFactory
     */
    protected $fileFactory;

    /**
     * @var DateTime
     */
    protected $dateTime;

    /**
     * @var Shipment
     */
    protected $pdfShipment;

    /**
     * @var ShipmentCollectionFactory
     */
    protected $shipmentCollectionFactotory;

    /**
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     * @param DateTime $dateTime
     * @param FileFactory $fileFactory
     * @param Shipment $shipment
     * @param ShipmentCollectionFactory $shipmentCollectionFactory
     */
    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory,
        DateTime $dateTime,
        FileFactory $fileFactory,
        Shipment $shipment,
        ShipmentCollectionFactory $shipmentCollectionFactory
    ) {
        $this->fileFactory = $fileFactory;
        $this->dateTime = $dateTime;
        $this->pdfShipment = $shipment;
        $this->collectionFactory = $collectionFactory;
        $this->shipmentCollectionFactotory = $shipmentCollectionFactory;
        parent::__construct($context, $filter);
    }

    /**
     * Print shipments for selected orders
     *
     * @param AbstractCollection $collection
     * @return ResponseInterface|\Magento\Backend\Model\View\Result\Redirect
     */
    protected function massAction(AbstractCollection $collection)
    {
        $shipmentsCollection = $this->shipmentCollectionFactotory->create()
            ->addFieldToFilter('vendor_order_id', ['in' => $collection->getAllIds()]);
        if (!$shipmentsCollection->getSize()) {
            $this->messageManager->addErrorMessage(__('There are no printable documents related to selected orders.'));
            return $this->resultRedirectFactory->create()->setPath($this->getComponentRefererUrl());
        }
        return $this->fileFactory->create(
            sprintf('packingslip%s.pdf', $this->dateTime->date('Y-m-d_H-i-s')),
            $this->pdfShipment->getPdf($shipmentsCollection->getItems())->render(),
            DirectoryList::VAR_DIR,
            'application/pdf'
        );
    }
}
