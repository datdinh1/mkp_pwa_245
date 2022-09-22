<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\Vendors\Block\Vendors\Account;

use Magento\Framework\App\ObjectManager;

/**
 * Base widget class
 *
 * @author     Magento Core Team <core@magentocommerce.com>
 *
 * @SuppressWarnings(PHPMD.NumberOfChildren)
 */
class Profile extends \Wiki\Vendors\Block\Profile
{
    /**
     * Get vendor object
     *
     * @return \Wiki\Vendors\Model\Vendor
     */
    public function getVendor()
    {
        $om = ObjectManager::getInstance();
        $session = $om->get('Wiki\Vendors\Model\Session');
        return $session->getVendor();
    }
}
