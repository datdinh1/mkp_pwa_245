<?php

namespace Wiki\VendorsProfile\Block;

use Magento\Checkout\Block\Checkout\LayoutProcessorInterface;
use Wiki\Vendors\Model\Session;
use Wiki\VendorsMedia\Helper\Data;

/**
 * Upload image content block
 */
class Address extends \Magento\Framework\View\Element\Template
{
    /**
     * Block's template
     *
     * @var string
     */
    protected $_template = 'Wiki_VendorsProfile::address.phtml';

    /**
     * @var array
     */
    protected $jsLayout;


    /**
     * @var array|LayoutProcessorInterface[]
     */
    protected $layoutProcessors;

    /**
     * @var Session
     */
    protected $_vendorSession;

    /**
     * @var Data
     */
    protected $helper;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        Session                      $session,
        Data                   $helper,
        array                                            $layoutProcessors = [],
        array                                            $data = []
    )
    {
        parent::__construct($context, $data);
        $this->jsLayout = isset($data['jsLayout']) && is_array($data['jsLayout']) ? $data['jsLayout'] : [];
        $this->layoutProcessors = $layoutProcessors;
        $this->_vendorSession = $session;
        $this->helper = $helper;
    }

    /**
     * @return string
     */
    public function getJsLayout(): string
    {
        $this->jsLayout['components']['address']['vendorId'] = $this->_vendorSession->getVendor()->getVendorId();

        foreach ($this->layoutProcessors as $processor) {
            $this->jsLayout = $processor->process($this->jsLayout);
        }
        return \Zend_Json::encode($this->jsLayout);
    }

    /**
     * @return string
     */
    public function testText(): string
    {
        return 'asdasdasdasdasd';
    }
}
