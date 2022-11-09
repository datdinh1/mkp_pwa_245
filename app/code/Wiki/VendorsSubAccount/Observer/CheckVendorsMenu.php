<?php
namespace Wiki\VendorsSubAccount\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\ObjectManager;
use Wiki\VendorsSubAccount\Helper\Data as Helper;

class CheckVendorsMenu implements ObserverInterface
{
    public function __construct(
        \Wiki\Vendors\Model\Session $vendorSession
    ) {
        $this->_vendorSession = $vendorSession;
    }

    /**
     *
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return self
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        if(!class_exists('Wiki\VendorsGroup\Helper\Data')) return;
        $vendorGroupId = $this->_vendorSession->getVendor()->getGroupId();
        /** @var \Wiki\VendorsGroup\Helper\Data $groupHelper */
        $groupHelper = ObjectManager::getInstance()->get('Wiki\VendorsGroup\Helper\Data');
        if (
            (strpos($observer->getResource(), 'subaccount') !== false) &&
            !$groupHelper->getConfig(Helper::XML_PATH_VENDOR_SUBACCOUNT, $vendorGroupId)
        ) {
            $observer->getResult()->setIsAllowed(false);
        }
    }
}
