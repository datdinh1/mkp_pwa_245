<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\Core\Model\Locator;

/**
 * Interface LocatorInterface
 */
interface LocatorInterface
{
    /**
     * @return \Wiki\Core\Model\Key
     */
    public function getLicense();
}
