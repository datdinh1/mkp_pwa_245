<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

/**
 * description
 *
 * @author      Magento Core Team <core@magentocommerce.com>
 */
namespace Wiki\VendorsCommission\Block\Adminhtml\Rule\Edit;

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
        $this->setId('commission_rule_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Commission Rule'));
    }
    
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Json\EncoderInterface $jsonEncoder,
        \Magento\Framework\Registry $registry,
        \Magento\Backend\Model\Auth\Session $authSession,
        array $data = []
    ) {
    
        $this->_coreRegistry = $registry;
        return parent::__construct($context, $jsonEncoder, $authSession, $data);
    }
}
