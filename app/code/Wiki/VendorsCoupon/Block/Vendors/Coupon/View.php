<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

// @codingStandardsIgnoreFile

namespace Wiki\VendorsMessage\Block\Vendors\Messages;

/**
 * Vendor Notifications block
 */
class View extends \Wiki\Vendors\Block\Vendors\AbstractBlock
{
    /**
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;
    
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Wiki\Vendors\Model\UrlInterface $url,
        \Magento\Framework\Registry $coreRegistry,
        array $data = []
    ) {
        parent::__construct($context, $url, $data);
        $this->_coreRegistry = $coreRegistry;
    }
    
    /**
     * Get message
     * 
     * @return \Wiki\VendorsMessage\Model\Message
     */
    public function getMessage(){
        return $this->_coreRegistry->registry('current_message');
    }
    
    /**
     * Get Back URL
     * 
     * @return string
     */
    public function getBackUrl(){
        return $this->getUrl("message");
    }
    
    /**
     * Get Back URL
     *
     * @return string
     */
    public function getDeleteUrl(){
        return $this->getUrl("message/view/delete",['id' => $this->getMessage()->getId()]);
    }
    
    /**
     * Get Back URL
     *
     * @return string
     */
    public function getSendUrl(){
        return $this->getUrl("message/view/reply",['id' => $this->getMessage()->getId()]);
    }
}
