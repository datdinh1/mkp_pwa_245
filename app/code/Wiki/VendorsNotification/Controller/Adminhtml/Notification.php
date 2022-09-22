<?php

namespace Wiki\VendorsNotification\Controller\Adminhtml;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Framework\Image\AdapterFactory;
use Magento\Framework\Filesystem;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem\Io\File;
use Magento\Framework\Filesystem\Driver\File as FileDriver;
use Wiki\VendorsNotification\Model\NotificationFactory;
use Wiki\VendorsNotification\Helper\Data;

class Notification extends \Magento\Framework\App\Action\Action
{   
    /**
     * @var Context
     */
    protected $context;

    /**
     * @var Registry
     */
    protected $_coreRegistry;

    /**
     * @var PageFactory
     */
    protected $_resultPageFactory;

    /**
     * @var UploaderFactory
     */
    protected $fileUploaderFactory;

    /**
     * @var AdapterFactory
     */
    protected $adapterFactory;

    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * @var FileDriver
     */
    protected $fileDriver;

    /**
     * @var File
     */
    protected $file;

    /**
     * @var DirectoryList
     */
    protected $dir;

    /**
     * @var NotificationFactory
     */
    protected $notificationFactory;

    /**
     * @var Data
     */
    protected $helperData;

    /**
     * @param Context $context
     * @param Registry $coreRegistry
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context                     $context,
        Registry                    $coreRegistry,
        PageFactory                 $resultPageFactory,
        UploaderFactory             $fileUploaderFactory,
        AdapterFactory              $adapterFactory,
        FileDriver                  $fileDriver,
        Filesystem                  $filesystem,
        File                        $file,
        DirectoryList               $dir,
        NotificationFactory         $notificaitonFactory,
        Data                        $helperData
    ){
        parent::__construct($context);
        $this->_coreRegistry        = $coreRegistry;
        $this->_resultPageFactory   = $resultPageFactory;
        $this->fileUploaderFactory  = $fileUploaderFactory;
        $this->adapterFactory       = $adapterFactory;
        $this->filesystem           = $filesystem;
        $this->fileDriver           = $fileDriver;
        $this->file                 = $file;
        $this->dir                  = $dir;
        $this->notificationFactory  = $notificaitonFactory;
        $this->helperData           = $helperData;
    }

    /**
     * News access rights checking
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Wiki_VendorsNotification::manage_news');
    }

    public function execute()
    {
        $this->resultPage = $this->_resultPageFactory->create();
        $this->resultPage->setActiveMenu('Wiki_VendorsNotification::manage');
        return $this->resultPage;       
    }

    public function initModel()
    {
        $model = $this->notificationFactory->create();
        if ( $this->getRequest()->getParam('id') ){
            $model->load($this->getRequest()->getParam('id'));
        }

        $this->registry->register('current_model', $model);
        return $model;
    }
}