<?php

namespace Wiki\VendorsProduct\Block;

use Magento\Checkout\Block\Checkout\LayoutProcessorInterface;
use Wiki\Vendors\Model\Session;

/**
 * Upload image content block
 */
class Dashboard extends \Magento\Framework\View\Element\Template
{
    /**
     * Block's template
     *
     * @var string
     */
    protected $_template = 'Wiki_VendorsProduct::dashboard.phtml';

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



    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        Session                      $session,
        array                                            $layoutProcessors = [],
        array                                            $data = []
    )
    {
        parent::__construct($context, $data);
        $this->jsLayout = isset($data['jsLayout']) && is_array($data['jsLayout']) ? $data['jsLayout'] : [];
        $this->layoutProcessors = $layoutProcessors;
        $this->_vendorSession = $session;
    }

    /**
     * @return string
     */
    public function getJsLayout(): string
    {
        $this->jsLayout['components']['dashboard']['vendorId'] = $this->_vendorSession->getVendor()->getVendorId();

        foreach ($this->layoutProcessors as $processor) {
            $this->jsLayout = $processor->process($this->jsLayout);
        }
        return \Zend_Json::encode($this->jsLayout);
    }

    /**
     * @return int
     */

    public function getTotals(): int
    {
        return 2;
    }
}
