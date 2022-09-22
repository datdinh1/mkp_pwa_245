<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\VendorsCredit\Block\Adminhtml\Vendor\Edit\Tab\Transaction;

use Magento\Framework\DataObject;
use Wiki\VendorsCredit\Model\Withdrawal;

/**
 * Customer Credit transactions grid
 * @SuppressWarnings(PHPMD.DepthOfInheritance)
 */
class Description extends \Magento\Backend\Block\Widget\Grid\Column\Renderer\Text
{
    /**
     * Renders grid column
     *
     * @param   Object $row
     * @return  string
     */
    public function render(DataObject $row)
    {
        return $row->getData($this->getColumn()->getIndex());
    }
}
