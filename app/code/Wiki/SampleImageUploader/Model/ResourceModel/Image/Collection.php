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
namespace Wiki\SampleImageUploader\Model\ResourceModel\Image;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'image_id';

    /**
     * Collection initialisation
     */
    protected function _construct()
    {
        $this->_init(
            'Wiki\SampleImageUploader\Model\Image',
            'Wiki\SampleImageUploader\Model\ResourceModel\Image'
        );
    }
}
