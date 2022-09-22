<?php

namespace Wiki\VendorsConfigApproval\Model\ResourceModel\Config\Pending;

class Collection extends \Wiki\VendorsConfigApproval\Model\ResourceModel\Config\Collection
{
    /**
     * {@inheritdoc}
     */
    protected function _initSelect()
    {
        parent::_initSelect();
        $this->join(
            ['vendor_tbl'=>$this->getTable('ves_vendor_entity')],
            'main_table.vendor_id=entity_id',
            ['vendor'=>'vendor_id']
        );
        $this->getSelect()->columns([
            'change_count' => 'count(update_id)',
            'last_update' => 'max(main_table.updated_at)',
        ])->group(
            'main_table.vendor_id'
        )->where(
            'main_table.status=?', \Wiki\VendorsConfigApproval\Model\Config::STATUS_PENDING
        );
    }
}
