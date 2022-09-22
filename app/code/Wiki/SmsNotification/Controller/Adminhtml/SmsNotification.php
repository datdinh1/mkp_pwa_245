<?php

namespace Wiki\SmsNotification\Controller\Adminhtml;

// use \Magento\Framework\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Wiki\SmsNotification\Model\NewsFactory;

use Magento\Framework\Filesystem;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem\Io\File;

class SmsNotification extends \Magento\Framework\App\Action\Action
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * Result page factory
     *
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_resultPageFactory;

    /**
     * News model factory
     *
     * @var \Wiki\SmsNotification\Model\NewsFactory
     */
    protected $_newsFactory;

        /**
     * @var FileUploaderFactory
     */

    protected $_fileUploaderFactory;
    protected $_filesystem;
    protected $_fileDriver;

    protected $file;
    protected $dir;

    protected $_notificationFactory;

        /**
     * @var Context
     */
    protected $context;

    /**
     * @param Context $context
     * @param Registry $coreRegistry
     * @param PageFactory $resultPageFactory
     * @param NewsFactory $newsFactory
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        PageFactory $resultPageFactory,
        NewsFactory $newsFactory,
        \Magento\MediaStorage\Model\File\UploaderFactory $fileUploaderFactory,
        \Magento\Framework\Filesystem $filesystem,
        \Magento\Framework\Filesystem\Driver\File $fileDriver,
        File $file,
        DirectoryList $dir,
        \Wiki\VendorsNotification\Model\NotificationFactory $notificaitonFactory
    ) {
       parent::__construct($context);
        $this->_coreRegistry = $coreRegistry;
        $this->_resultPageFactory = $resultPageFactory;
        $this->_newsFactory = $newsFactory;
        $this->_fileUploaderFactory = $fileUploaderFactory;
        $this->_filesystem = $filesystem;
        $this->_fileDriver = $fileDriver;
        $this->file = $file;
        $this->dir = $dir;

        $this->_notificationFactory = $notificaitonFactory;
    }

    /**
     * News access rights checking
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Wiki_SmsNotification::manage_news');
    }
    public function execute() {

        $this->resultPage = $this->resultPageFactory->create();
        $this->resultPage->setActiveMenu('Wiki_SmsNotification::manage');
        return $this->resultPage;       
    }
    public function initModel()
    {
        $model = $this->_newsFactory->create();
        if ($this->getRequest()->getParam('id')) {
            $model->load($this->getRequest()->getParam('id'));
        }

        $this->registry->register('current_model', $model);

        return $model;
    }
}