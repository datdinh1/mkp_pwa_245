<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

// @codingStandardsIgnoreFile

namespace Wiki\Vendors\Block\Vendors\Page\Toplinks;

/**
 * Vendor User links block
 *
 */
class Users extends \Wiki\Vendors\Block\Vendors\AbstractBlock
{
    /**
     * @var \Wiki\Vendors\Model\Session
     */
    protected $_session;
    
    /**
     * Top links
     *
     * @var array
     */
    protected $_links = [];
    
    /**
     * @var \Magento\Framework\Url
     */
    protected $_frontendUrl;
    
    /**
     * Constructor
     *
     * @param Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Wiki\Vendors\Model\UrlInterface $url,
        \Magento\Framework\Url $frontendUrl,
        \Wiki\Vendors\Model\Session $session,
        array $data = [])
    {
        $this->_frontendUrl = $frontendUrl;
        $this->_session = $session;
        parent::__construct($context, $url);
    }
    
    /**
     * Return new link position in list
     *
     * @param int $position
     * @return int
     */
    protected function _getNewPosition($position = 0)
    {
        if (intval($position) > 0) {
            while (isset($this->_links[$position])) {
                $position++;
            }
        } else {
            $position = 0;
            foreach ($this->_links as $k=>$v) {
                $position = $k;
            }
            $position += 10;
        }
        return $position;
    }
    
    
    /**
     * @param string $label
     * @param string $title
     * @param string $url
     * @param number $position
     * @param string $iconClass
     * @param string $resource
     * @return \Wiki\Vendors\Block\Vendors\Page\Toplinks\Users
     */
    public function addLink($label, $title = null, $url = '', $position=0, $iconClass='', $resource = 'Wiki_Vendors::allowed')
    {
        if(!$this->isAllowedLink($resource)) return;
        if (empty($title)) {
            $title = $label;
        }
        $this->_links[$this->_getNewPosition($position)] = [
            'label' => __($label),
            'title' => __($title),
            'url' => $url,
            'sort_order'=>$position,
            'icon_class'=>$iconClass,
            'resource' => $resource
        ];
        return $this;
    }
    
    /**
     * @param string $resource
     * @return boolean
     */
    protected function isAllowedLink($resource = ''){
        $permission = new \Wiki\Vendors\Model\AclResult();
        $this->_eventManager->dispatch(
            'ves_vendor_check_acl',
            [
                'resource' => $resource,
                'permission' => $permission
            ]
        );
        return $permission->isAllowed();
    }
    
    /**
     * {@inheritdoc}
     */
    protected function _beforeToHtml()
    {
        // TODO - Moved to Beta 2, no breadcrumbs displaying in Beta 1
        $this->assign('links', $this->_links);
        return parent::_beforeToHtml();
    }
    
    /**
     * @return \Wiki\Customer\Model\Customer|null
     */
    public function getUser()
    {
        return $this->_session->getCustomer();
    }
    
    /**
     * @return \Wiki\Vendors\Model\Vendor
     */
    public function getVendor(){
        return $this->_session->getVendor();
    }
    
    /**
     * @return string
     */
    public function getLogoutLink()
    {
        if($this->canShowBuyerDashboardLink())
            return $this->_frontendUrl->getUrl('customer/account/logout');
        
        return $this->getUrl('account/logout');
    }
    
    /**
     * Get seller dashboard URL
     * 
     * @return string
     */
    public function getBuyerDashboardUrl(){
        return $this->_frontendUrl->getUrl('customer/account');
    }
    
    /**
     * Can show buyer dashboard link
     */
    public function canShowBuyerDashboardLink(){
        return !$this->_scopeConfig->getValue(\Wiki\Vendors\App\Area\FrontNameResolver::XML_PATH_USE_CUSTOM_VENDOR_URL);
    }
    /**
     * @return string
     */
    public function getMyAccountLink(){
        return $this->getUrl('account');
    }
}
