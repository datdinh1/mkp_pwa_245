<?php
// @codingStandardsIgnoreFile
/*
 * Wiki_SampleImageUploader

 * @category   Wiki
 * @package    Wiki_SampleImageUploader
 * @copyright  Copyright (c) 2017 Wiki
 * @license    https://github.com/Wiki/magento2-sample-imageuploader/blob/master/LICENSE.md
 * @version    1.0.0
 */
namespace Wiki\SampleImageUploader\Model\ResourceModel\ImageInterest;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'entity_id';
	

	/**
	 * Define resource model
	 *
	 * @return void
	 */
	protected function _construct()
	{
		$this->_init('Wiki\SampleImageUploader\Model\ImageInterest', 'Wiki\SampleImageUploader\Model\ResourceModel\ImageInterest');
	}
}
