<?php
/*
 * Wiki_SampleImageUploader

 * @category   Wiki
 * @package    Wiki_SampleImageUploader
 * @copyright  Copyright (c) 2017 Wiki
 * @license    https://github.com/Wiki/magento2-sample-imageuploader/blob/master/LICENSE.md
 * @version    1.0.0
 */
namespace Wiki\SampleImageUploader\Controller\Adminhtml\Image;

use Wiki\SampleImageUploader\Controller\Adminhtml\Image;

class Index extends Image
{
    /**
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Wiki_SampleImageUploader::image');
        $resultPage->getConfig()->getTitle()->prepend(__('Custom Interest'));
        $resultPage->addBreadcrumb(__('Custom Interest'), __('Custom Interest'));
        return $resultPage;
    }
}
