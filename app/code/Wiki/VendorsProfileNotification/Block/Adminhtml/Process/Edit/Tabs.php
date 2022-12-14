<?php

namespace Wiki\VendorsProfileNotification\Block\Adminhtml\Process\Edit;

class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    /**
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;
    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('vendors_process_edit_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Profile Process'));
    }
    
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Json\EncoderInterface $jsonEncoder,
        \Magento\Framework\Registry $registry,
        \Magento\Backend\Model\Auth\Session $authSession,
        array $data = []
    ) {
    
        $this->_coreRegistry = $registry;
        return parent::__construct($context, $jsonEncoder, $authSession);
    }
    protected function _beforeToHtml()
    {
        return parent::_beforeToHtml();
    }
}
