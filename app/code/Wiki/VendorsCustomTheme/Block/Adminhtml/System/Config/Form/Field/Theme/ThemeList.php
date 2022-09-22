<?php

namespace Wiki\VendorsCustomTheme\Block\Adminhtml\System\Config\Form\Field\Theme;

use Magento\Framework\UrlInterface;
use Wiki\VendorsCustomTheme\Model\Theme;

class ThemeList extends \Magento\Backend\Block\Template
{
    /**
     * @var string
     */
    protected $_template = 'config/theme-list.phtml';

    /**
     * @var \Wiki\VendorsCustomTheme\Model\ResourceModel\CollectionFactory
     */
    protected $_collectionFactory;
    
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Wiki\VendorsCustomTheme\Model\ResourceModel\Theme\CollectionFactory $collectionFactory,
        $data =[]
    ) {
        $this->_collectionFactory = $collectionFactory;
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
     * Get customize theme URL
     * 
     * @param \Wiki\VendorsCustomTheme\Model\Theme $theme
     * @return string
     */
    public function getThemeCustomizeUrl(\Wiki\VendorsCustomTheme\Model\Theme $theme){
        echo $this->getUrl('theme/index/customize',['id' => $theme->getId()]);
    }
}
