<?php

namespace Wiki\VendorsSales\Controller\Vendors\Order\Shipment;

use Magento\Framework\App\ResponseInterface;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\Ui\Component\MassAction\Filter;
use Wiki\Vendors\App\Action\Context;
use Magento\Shipping\Model\Shipping\LabelGenerator;
use Magento\Framework\App\Response\Http\FileFactory;
use Magento\Sales\Model\ResourceModel\Order\Shipment\CollectionFactory as ShipmentCollectionFactory;
use Magento\Framework\Controller\ResultInterface;
use Wiki\VendorsSales\Model\ResourceModel\Order\CollectionFactory;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class MassPrintShippingLabel extends \Wiki\VendorsSales\Controller\Vendors\Order\AbstractMassAction
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    protected $_aclResource = 'Wiki_VendorsSales::sales_shipments';
    
    /**
     * @var LabelGenerator
     */
    protected $labelGenerator;

    /**
     * @var FileFactory
     */
    protected $fileFactory;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var ShipmentCollectionFactory
     */
    protected $shipmentCollectionFactory;

    /**
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     * @param FileFactory $fileFactory
     * @param LabelGenerator $labelGenerator
     * @param ShipmentCollectionFactory $shipmentCollectionFactory
     */
    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory,
        FileFactory $fileFactory,
        LabelGenerator $labelGenerator,
        ShipmentCollectionFactory $shipmentCollectionFactory
    ) {
        $this->fileFactory = $fileFactory;
        $this->collectionFactory = $collectionFactory;
        $this->shipmentCollectionFactory = $shipmentCollectionFactory;
        $this->labelGenerator = $labelGenerator;
        parent::__construct($context, $filter);
    }

    /**
     * Batch print shipping labels for whole shipments.
     * Push pdf document with shipping labels to user browser
     *
     * @param AbstractCollection $collection
     * @return ResponseInterface|ResultInterface
     */
    protected function massAction(AbstractCollection $collection)
    {
        $labelsContent = [];
        $shipments = $this->shipmentCollectionFactory->create()
            ->addFieldToFilter('vendor_order_id', ['in' => $collection->getAllIds()]);

        if ($shipments->getSize()) {
            /** @var \Magento\Sales\Model\Order\Shipment $shipment */
            foreach ($shipments as $shipment) {
                $labelContent = $shipment->getShippingLabel();
                if ($labelContent) {
                    $labelsContent[] = $labelContent;
                }
            }
        }

        if (!empty($labelsContent)) {
            $outputPdf = $this->labelGenerator->combineLabelsPdf($labelsContent);
            return $this->fileFactory->create(
                'ShippingLabels.pdf',
                $outputPdf->render(),
                DirectoryList::VAR_DIR,
                'application/pdf'
            );
        }

        $this->messageManager->addErrorMessage(__('There are no shipping labels related to selected orders.'));
        return $this->resultRedirectFactory->create()->setPath('sales/order/');
    }
}
