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

class Edit extends Image
{
    /**
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $imageId = $this->getRequest()->getParam('image_id');
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Wiki_SampleImageUploader::image')
            ->addBreadcrumb(__('Interest'), __('Interest'))
            ->addBreadcrumb(__('Manage Interest'), __('Manage Interest'));

        if ($imageId === null) {
            $resultPage->addBreadcrumb(__('New Interest'), __('New Interest'));
            $resultPage->getConfig()->getTitle()->prepend(__('New Interest'));
        } else {
            $resultPage->addBreadcrumb(__('Edit Interest'), __('Edit Interest'));
            $resultPage->getConfig()->getTitle()->prepend(__('Edit Interest'));
        }
        return $resultPage;
    }
}
