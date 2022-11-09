<?php

namespace Wiki\VendorsSubAccount\Block\User\Edit;

/**
 * @api
 * @since 100.0.2
 */
class Tabs extends \Wiki\Vendors\Block\Vendors\Widget\Tabs
{
    /**
     * Class constructor
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('user_info_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('User Information'));
    }
}
