<?php
/**
 * Copyright © Wiki. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\Vendors\Block\Account;

use Wiki\Vendors\Model\Source\PanelType;

class Link extends \Magento\Framework\View\Element\Html\Link
{

    /**
     * @var \Wiki\Vendors\Helper\Data
     */
    protected $_vendorHelper;

    /**
     * @var \Wiki\Vendors\Model\Session
     */
    protected $_vendorSession;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Wiki\Vendors\Helper\Data $vendorHelper
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Wiki\Vendors\Helper\Data $vendorHelper,
        \Wiki\Vendors\Model\Session $session,
        array $data = []
    ) {
        $this->_vendorHelper = $vendorHelper;
        $this->_vendorSession = $session;
        parent::__construct($context, $data);
    }

    /**
     * Is registered vendor
     *
     * @return boolean
     */
    public function getIsRegisteredVendor()
    {
        return $this->_vendorSession->isLoggedIn() && $this->_vendorSession->getVendor()->getId();
    }

    /**
     * @return string
     */
    public function getHref()
    {
        if ($this->_vendorHelper->getPanelType() == PanelType::TYPE_SIMPLE) {
            return $this->getUrl('marketplace/seller/index');
        }

        return $this->_vendorHelper->getUrl('dashboard');
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Magento\Framework\View\Element\Html\Link::_toHtml()
     */
    protected function _toHtml()
    {
        if (!$this->_vendorHelper->moduleEnabled() ||
            !$this->getIsRegisteredVendor() ||
            (int) $this->_vendorSession->getVendor()->getStatus() == \Wiki\Vendors\Model\Vendor::STATUS_DISABLED
        ) {
            return '';
        }

        return parent::_toHtml();
    }
}
