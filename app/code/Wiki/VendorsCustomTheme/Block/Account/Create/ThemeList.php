<?php

namespace Wiki\VendorsCustomTheme\Block\Account\Create;

use Magento\Framework\UrlInterface;
use Wiki\VendorsCustomTheme\Model\Theme;

class ThemeList extends \Magento\Framework\View\Element\Template
{
    /**
     * @var string
     */
    protected $_template = 'theme-list.phtml';

    /**
     * @var \Wiki\VendorsCustomTheme\Helper\Data
     */
    protected $helper;
    
    /**
     * @var \Wiki\VendorsCustomTheme\Model\ResourceModel\CollectionFactory
     */
    protected $_collectionFactory;
    
    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Wiki\VendorsCustomTheme\Helper\Data $helper
     * @param \Wiki\VendorsCustomTheme\Model\ResourceModel\Theme\CollectionFactory $collectionFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Wiki\VendorsCustomTheme\Helper\Data $helper,
        \Wiki\VendorsCustomTheme\Model\ResourceModel\Theme\CollectionFactory $collectionFactory,
        $data =[]
    ) {
        $this->_collectionFactory = $collectionFactory;
        $this->helper = $helper;
        parent::__construct($context, $data);
    }
    
    /**
     * Get collection
     * 
     * @return \Wiki\VendorsCustomTheme\Model\ResourceModel\Collection
     */
    public function getCollection(){
        if(!$this->getData('collection')){
            $collection = $this->_collectionFactory->create()
                ->addFieldToFilter('status', Theme::STATUS_ENABLE);
            $this->setData('collection', $collection);
        }
        
        return $this->getData('collection');        
    }
    
    /**
     * Get Preview Image Url
     * 
     * @param string $image
     * @return string
     */
    public function getPreviewImageUrl($image){
        return $this->_urlBuilder->getBaseUrl(['_type' => UrlInterface::URL_TYPE_MEDIA]).$image;
    }
    
    /**
     * (non-PHPdoc)
     * @see \Magento\Framework\View\Element\Template::_toHtml()
     */
    protected function _toHtml(){
        if(!$this->helper->isEnableForRegister()) return '';
        return parent::_toHtml();
    }
}
