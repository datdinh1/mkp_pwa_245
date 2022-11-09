<?php

namespace Wiki\VendorsAuction\Block;

use Magento\Checkout\Block\Checkout\LayoutProcessorInterface;
use Wiki\Vendors\Model\Session;


class Product extends \Magento\Framework\View\Element\Template
{
    /**
     * Block's template
     *
     * @var string
     */
    protected $_template = 'Wiki_VendorsAuction::product.phtml';

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
        Session                                          $session,
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
        $this->jsLayout['components']['product']['vendorId'] = $this->_vendorSession->getVendor()->getVendorId();

        foreach ($this->layoutProcessors as $processor) {
            $this->jsLayout = $processor->process($this->jsLayout);
        }
        return \Zend_Json::encode($this->jsLayout);
    }

    public function getProductImage()
    {
        return 'http://cmkp.funsecondlife.com/img/310/300/resize/pub/media/catalog/product/6/2/6243d87648f82_jpg.jpg';
    }

    public function getProductName()
    {
        return 'test 1';
    }

    public function getProductUrl()
    {
        return '/seller/auction/bid/teset-2-S85';
    }

    public function getProductStatus()
    {
        return 'In the process of bidding/highest bid';
    }

    public function getTotal()
    {
        return 2;
    }
}
