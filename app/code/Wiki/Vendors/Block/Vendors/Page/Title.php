<?php
/**
 * Copyright © Wiki. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\Vendors\Block\Vendors\Page;

/**
 * Vendor Title Block
 *
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Title extends \Wiki\Vendors\Block\Vendors\AbstractBlock
{
    /**
     * Get short title
     * @return string
     */
    public function getTitle()
    {
        $title = $this->pageConfig->getTitle()->getShort();
        return isset($title) ? __($title) : '';
    }
}
