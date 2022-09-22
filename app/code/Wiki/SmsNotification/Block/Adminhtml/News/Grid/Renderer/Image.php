<?php
namespace Wiki\SmsNotification\Block\Adminhtml\News\Grid\Renderer;

use Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer;
use Magento\Framework\DataObject;
use Magento\Store\Model\StoreManagerInterface;

class Image extends AbstractRenderer
{
    private $_storeManager;

    public function __construct(\Magento\Backend\Block\Context $context, StoreManagerInterface $storemanager, array $data = [])
    {
        $this->_storeManager = $storemanager;
        parent::__construct($context, $data);
        $this->_authorization = $context->getAuthorization();
    }

    public function render(DataObject $row)
    {
        if($row['image']) {
        $mediaDirectory = $this->_storeManager->getStore()->getBaseUrl(
        \Magento\Framework\UrlInterface::URL_TYPE_MEDIA);

        $imageUrl = $mediaDirectory.'wiki_notification/images/'.$row['image'];

        return '<img src="'.$imageUrl.'" width="100"/>';

        }
    }
}