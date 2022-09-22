<?php

namespace Wiki\VendorsNotification\Controller\Adminhtml\Notification;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Ui\Component\MassAction\Filter;
use Wiki\VendorsNotification\Model\ResourceModel\Notification\CollectionFactory;

/**
 * Class MassStatus
 * @package Mageplaza\BannerSlider\Controller\Adminhtml\Banner
 */
class MassObjectUsers extends Action
{
    /**
     * @var Filter
     */
    public $filter;

    /**
     * @var CollectionFactory
     */
    public $collectionFactory;

    /**
     * MassStatus constructor.
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        Context                     $context,
        Filter                      $filter,
        CollectionFactory           $collectionFactory
    ){
        parent::__construct($context);
        $this->filter               = $filter;
        $this->collectionFactory    = $collectionFactory;
    }

    /**
     * @return $this|\Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     * @throws LocalizedException
     */
    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $data       = (int)$this->getRequest()->getParam('notification_of');
        $record     = 0;

        foreach ( $collection as $item ){
            try {
                $item->setNotificationOf($data)->save();
                $record++;
            } catch ( LocalizedException $e ){
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch ( \Exception $e ){
                $this->messageManager->addErrorMessage(__('Something went wrong while updating Object User for %1.'));
            }
        }

        if ( $record ){
            $this->messageManager->addSuccessMessage(__('A total of %1 record(s) have been updated.', $record));
        }

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        return $resultRedirect->setPath('*/*/');
    }
}
