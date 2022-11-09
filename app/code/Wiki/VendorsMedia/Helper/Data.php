<?php

namespace Wiki\VendorsMedia\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

/**
 * @SuppressWarnings(PHPMD.LongVariable)
 */
class Data extends AbstractHelper
{
    const MEDIA_FOLDER = 'Wiki_vendorsmedia';
    /**
     * Get allowed image extensions
     *
     * @return multitype:string
     */
    public function getAllowedExtensions()
    {
        return ['jpg', 'jpeg', 'gif', 'png'];
    }
    
    /**
     * @param \Wiki\Vendors\Model\Vendor $vendor
     * @return string
     */
    public function getMediaFolder(\Wiki\Vendors\Model\Vendor $vendor){
        return self::MEDIA_FOLDER.'/'.$vendor->getVendorId(); 
    }
}
