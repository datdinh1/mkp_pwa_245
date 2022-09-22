<?php

namespace Wiki\VendorsSubAccount\Observer;

use Magento\Framework\Event\ObserverInterface;

class CheckPermission implements ObserverInterface
{
    /**
     * @var \Wiki\Vendors\Model\Session
     */
    protected $session;
    
    /**
     * @var \Wiki\VendorsSubAccount\Helper\Data
     */
    protected $helper;
    
    /**
     * @param \Wiki\Vendors\Model\Session $session
     * @param \Wiki\VendorsSubAccount\Helper\Data $helper
     */
    public function __construct(
        \Wiki\Vendors\Model\Session $session,
        \Wiki\VendorsSubAccount\Helper\Data $helper
    ) {
        $this->session = $session;
        $this->helper = $helper;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     * @codeCoverageIgnore
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $resource = $observer->getResource();
        $permission = $observer->getPermission();
        $vendor = $this->session->getVendor();
		if(!$vendor->getId()) return;
        $permission->push($this->helper->checkPermission($vendor, $resource));
    }
}
