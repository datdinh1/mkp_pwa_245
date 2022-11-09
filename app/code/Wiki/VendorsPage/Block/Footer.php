<?php
namespace Wiki\VendorsPage\Block;

class Footer extends \Wiki\VendorsPage\Block\Head
{
    /**
     * Get Head Html
     * 
     * @return string
     */
    public function getFooterHtml(){
        return $this->helper->getVendorFooterHtml($this->getVendorId());
    }

    /**
     * @see \Magento\Framework\View\Element\Template::_toHtml()
     */
    protected function _toHtml(){
        if(!$this->getVendorId() || !$this->getFooterHtml()) return '';
        return \Magento\Framework\View\Element\Template::_toHtml();
    }
}
