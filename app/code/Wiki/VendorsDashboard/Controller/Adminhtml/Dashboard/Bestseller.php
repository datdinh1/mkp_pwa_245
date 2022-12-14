<?php
/**
 *
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\VendorsDashboard\Controller\Adminhtml\Dashboard;

class Bestseller extends AjaxBlock
{
    /**
     * Gets the list of most active customers
     *
     * @return \Magento\Framework\Controller\Result\Raw
     */
    public function execute()
    {
        $this->_initVendor();
        
        $output = $this->layoutFactory->create()
            ->createBlock('Wiki\VendorsDashboard\Block\Adminhtml\Dashboard\Bestseller\Grid')
            ->toHtml();
        $resultRaw = $this->resultRawFactory->create();
        return $resultRaw->setContents($output);
    }
}
