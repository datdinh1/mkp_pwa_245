<?php
namespace Wiki\VendorsPage\Block\Home;

class Social extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Wiki\VendorsPage\Helper\Data
     */
    protected $_pageHelper;
    
    /**
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;
    
    /**
     * @var string
     */
    protected $_title;
    
    /**
     * @var string
     */
    protected $_configPath;
    
    /**
     * @var \Wiki\VendorsConfig\Helper\Data
     */
    protected $_configHelper;
    
    /**
     *
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Wiki\VendorsPage\Helper\Data $pageHelper
     * @param \Wiki\Vendors\Helper\Data $vendorHelper
     * @param \Magento\MediaStorage\Helper\File\Storage\Database $fileStorageDatabase
     * @param \Magento\Framework\Filesystem $filesystem
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Wiki\VendorsPage\Helper\Data $pageHelper,
        \Wiki\VendorsConfig\Helper\Data $configHelper,
        array $data = []
    ) {
        $this->_pageHelper = $pageHelper;
        $this->_coreRegistry = $registry;
        $this->_configHelper = $configHelper;
        
        parent::__construct($context, $data);
    }
    
    /**
     * Get Vendor object
     *
     * @return \Wiki\Vendors\Model\Vendor
     */
    public function getVendor()
    {
        return $this->_coreRegistry->registry('vendor');
    }
    
    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->getData('title');
    }
    
    /**
     * Get Social URL
     *
     * @return string
     */
    public function getSocialUrl()
    {
        return $this->_configHelper->getVendorConfig(
            $this->getData('config_path'),
            $this->getVendor()->getId()
        );
    }
    
    public function _toHtml()
    {
        if (!$this->getData('config_path') || !$this->getSocialUrl()) {
            return '';
        }
        return parent::_toHtml();
    }
}
