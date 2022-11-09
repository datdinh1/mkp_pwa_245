<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\VendorsConfig\Model\Config\Backend;

class Multiselect extends \Wiki\VendorsConfig\Model\Config
{
    /**
     * @return void
     */
    protected function _afterLoad()
    {
        if (!is_array($this->getValue())) {
            $value = $this->getValue();
            $this->setValue(empty($value) ? false : explode(",", $value));
        }
    }

    /**
     * @return $this
     */
    public function beforeSave()
    {
        if (is_array($this->getValue())) {
            $this->setValue(implode(",", $this->getValue()));
        }
        return parent::beforeSave();
    }
}
