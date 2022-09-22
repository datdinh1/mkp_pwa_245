<?php
/**
 * Copyright © Wiki. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\Vendors\Block\Vendors;

/**
 * Adminhtml footer block
 *
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class AbstractBlock extends \Magento\Framework\View\Element\Template
{
    /**
     * Backend URL instance
     *
     * @var \Wiki\Vendors\Model\UrlInterface
     */
    protected $_url;

    /**
     * AbstractBlock constructor.
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Wiki\Vendors\Model\UrlInterface $url
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Wiki\Vendors\Model\UrlInterface $url,
        array $data = []
    ) {
        $this->_url = $url;
        parent::__construct($context, $data);
    }
    
    /**
     * Generate vendor url by route and parameters
     *
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->_url->getUrl($route, $params);
    }
}
