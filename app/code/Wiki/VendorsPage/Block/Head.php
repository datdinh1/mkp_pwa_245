<?php
namespace Wiki\VendorsPage\Block;

use Magento\Framework\View\Element\Template\Context;
use Wiki\VendorsPage\Helper\Data as Helper;
use Magento\Framework\Registry;

class Head extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Wiki\VendorsPage\Helper\Data
     */
    protected $helper;
    
    /**
     * @var \Magento\Framework\Registry
     */
    protected $coreRegistry;
    
    /**
     * @param Context $context
     * @param Helper $helper
     * @param array $data
     */
    public function __construct(
        Context $context,
        Helper $helper,
        Registry $coreRegistry,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->helper = $helper;
        $this->coreRegistry = $coreRegistry;
    }
    
    /**
     * Get Head Html
     * 
     * @return string
     */
    public function getHeadHtml(){
        return $this->helper->getVendorHeadHtml($this->getVendorId());
    }
    
    /**
     * Get current vendor Id
     * 
     * @return int
     */
    public function getVendorId(){
        $product = $this->coreRegistry->registry('product');
        if($product) return $product->getVendorId();
        $vendor = $this->coreRegistry->registry('vendor');
        return $vendor?$vendor->getId():false;
    }
    
    /**
     * @see \Magento\Framework\View\Element\Template::_toHtml()
     */
    protected function _toHtml(){
        if(!$this->getVendorId() || !$this->getHeadHtml()) return '';
        return parent::_toHtml();
    }
}
