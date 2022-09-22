<?php

namespace Wiki\VendorsSalesRule\Model;

use Magento\Framework\Model\AbstractModel;

class VarcharCode extends AbstractModel
{
    const CACHE_TAG = 'wiki_generate_varchar_code';
    protected $_cacheTag = 'wiki_generate_varchar_code';

    protected $_eventPrefix = 'wiki_generate_varchar_code';
    /**
     * Define resource model
     */
    protected function _construct()
    {
        $this->_init(\Wiki\VendorsSalesRule\Model\ResourceModel\VarcharCode::class);
    }
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getDefaultValues()
    {
        $values = [];

        return $values;
    }

    public function _getLastItem()
    {
        $collection = $this->getCollection()->getLastItem();
        if ( !$collection->getId() ){
            /** initialization auto_generate = A0001 */
            $collection = $this->setAutoGenerate('A0000')->save();
        }
        return $collection;
    }
}
