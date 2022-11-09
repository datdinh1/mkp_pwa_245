<?php
namespace Wiki\VendorsPage\Block\Profile;

use Wiki\VendorsPage\Model\Source\ProfilePosition as Profile;

/**
 * Class View
 * @package Magento\Catalog\Block\Category
 */
class Left extends \Wiki\Vendors\Block\Profile
{
    /**
     * @var \Wiki\VendorsPage\Helper\Data
     */
    protected $_pageHelper;
    
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Wiki\Vendors\Helper\Data $vendorHelper,
        \Wiki\VendorsConfig\Helper\Data $configHelper,
        \Magento\Framework\Registry $registry,
        \Magento\MediaStorage\Helper\File\Storage\Database $fileStorageDatabase,
        \Wiki\Vendors\Helper\Image $imageHelper,
        \Wiki\VendorsSales\Model\ResourceModel\OrderFactory $orderResourceFactory,
        \Magento\Cms\Model\Template\Filter $filter,
        \Wiki\Vendors\Model\VendorFactory $vendorFactory,
        \Wiki\VendorsPage\Helper\Data $pageHelper,
        array $data = []
    ) {
        $this->_pageHelper = $pageHelper;
        parent::__construct(
            $context,
            $vendorHelper,
            $configHelper,
            $registry,
            $fileStorageDatabase,
            $imageHelper,
            $orderResourceFactory,
            $filter,
            $vendorFactory,
            $data
        );
    }
    
    protected function _toHtml()
    {
        if ($this->_pageHelper->getProfileBlockPosition() != Profile::POSITION_LEFT) {
            return '';
        }
        return parent::_toHtml();
    }
}
