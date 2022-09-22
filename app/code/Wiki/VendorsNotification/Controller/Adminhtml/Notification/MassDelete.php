<?php

namespace Wiki\VendorsNotification\Controller\Adminhtml\Notification;

use Magento\Ui\Component\MassAction\Filter;
use Magento\Backend\App\Action\Context;
use Wiki\VendorsNotification\Model\ResourceModel\Notification\CollectionFactory;
use Wiki\VendorsNotification\Helper\Data;

class MassDelete extends \Magento\Backend\App\Action
{
    /**
     * @var Filter
     */
    protected $filter;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var Data
     */
    protected $helperData;

    public function __construct(
        Context                     $context,
        Filter                      $filter,
        CollectionFactory           $collectionFactory,
        Data                        $helperData
    ){
        parent::__construct($context);
        $this->filter               = $filter;
        $this->collectionFactory    = $collectionFactory;
        $this->helperData           = $helperData;
    }

    /**
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());

        $delete = 0;
        foreach ( $collection as $item ){
            $image = $item->getImage();
            $item->delete();
            if ( $image ){
                $this->helperData->deleteImage($image);
            }
            $delete++;
        }
        $this->messageManager->addSuccess(__('A total of %1 record(s) have been deleted.', $delete));
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }
}
