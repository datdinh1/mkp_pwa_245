<?php
namespace Wiki\VendorsSalesRule\Block\Adminhtml\Renderer;

use Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer;
 
class Image extends AbstractRenderer
{
    protected $storeManager;

    public function __construct(
        \Magento\Backend\Block\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        array $data = [])
    {
        parent::__construct($context, $data);
        $this->storeManager = $storeManager;
    }

    public function render(\Magento\Framework\DataObject $row)
    {
        $image = $this->_getValue($row);
        if ( !empty($image) ){
            $mediaUrl = $this ->storeManager-> getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA );
            $strImage = '<img width="100" height="50" src="'.$mediaUrl. 'sampleimageuploader/images/image/'.$image.'" />';
            return $strImage;
        }
    }
}