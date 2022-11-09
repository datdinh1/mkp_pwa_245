<?php

namespace Wiki\VendorsAuction\Block;

use Magento\Checkout\Block\Checkout\LayoutProcessorInterface;
use Wiki\Vendors\Model\Session;
use Wiki\VendorsMedia\Helper\Data;


class Create extends \Magento\Framework\View\Element\Template
{
    /**
     * Block's template
     *
     * @var string
     */
    protected $_template = 'Wiki_VendorsAuction::create.phtml';

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
        Session                                          $session,
        Data                                             $helper,
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
        $this->jsLayout['components']['create']['vendorId'] = $this->_vendorSession->getVendor()->getVendorId();
        $this->jsLayout['components']['create']['allowedExtensions'] = $this->getAllowedExtensions();
        $this->jsLayout['components']['create']['maxFileSize'] = false; /*Byes*/

        foreach ($this->layoutProcessors as $processor) {
            $this->jsLayout = $processor->process($this->jsLayout);
        }
        return \Zend_Json::encode($this->jsLayout);
    }

    /**
     * Get Allowed Extensions
     *
     * @return array
     */
    public function getAllowedExtensions(): array
    {
        return $this->helper->getAllowedExtensions();
    }

}
