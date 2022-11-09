<?php
namespace Wiki\Vendors\Block\Account\Create\Fieldset;

class VendorId extends Field
{
    /**
     * Get Validate VendorId Url
     * 
     * @return string
     */
    public function getVerifyVendorIdUrl(){
        return $this->getUrl('marketplace/seller/validateVendor');
    }
}
