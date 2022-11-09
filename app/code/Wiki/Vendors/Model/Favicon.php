<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\Vendors\Model;

class Favicon extends \Magento\Theme\Model\Favicon\Favicon
{
    /**
     * @return string
     */
    public function getDefaultFavicon()
    {
        return 'favicon.ico';
    }
    
    /**
     * @return string
     */
    protected function prepareFaviconFile()
    {
        $folderName = \Magento\Config\Model\Config\Backend\Image\Favicon::UPLOAD_DIR;
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $configHelper = $objectManager->create('\Wiki\VendorsConfig\Helper\Data');
        $vendorSession = $objectManager->create('\Wiki\Vendors\Model\Session');
        $scopeConfig = $configHelper->getVendorConfig(
            'general/store_information/favicon_icon_seller',
            $vendorSession->getVendor()->getId()
        );
        $basePath = 'ves_vendors/logo/';
        $path =  $basePath. $scopeConfig;
        $imageHelper = $objectManager->create('\Wiki\Vendors\Helper\Image');
        $image = $imageHelper->init($scopeConfig, '', [])
                ->setBaseMediaPath($basePath)
                ->backgroundColor([250,250,250]);
        $image = $image->getUrl();

        // $path = $folderName . '/' . $scopeConfig;
        // $faviconUrl = $this->storeManager->getStore()
        //     ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . $path;

        if ($scopeConfig !== null && $this->checkIsFile($path)) {
            return $image;
        }
    
        return false;
    }
}
