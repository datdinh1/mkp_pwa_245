<?php

namespace Wiki\SmsNotification\Model;

use Magento\Framework\Model\AbstractModel;

class News extends AbstractModel
{

    const NAME = 'title';

    const STATUS = 'status';

    const SUMMARY = 'summary';

    const DES = 'description';

    const OBJUSER = 'obj_user';

    const IMAGE = 'image';

    /**
     * Define resource model
     */
    protected function _construct()
    {
        $this->_init('Wiki\SmsNotification\Model\Resource\News');
    }
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->getData(self::NAME);
    }
    public function getStatus()
    {
        return $this->getData(self::STATUS);
    }
    public function getSummary()
    {
        return $this->getData(self::SUMMARY);
    }
    public function getDes()
    {
        return $this->getData(self::DES);
    }
    public function getObj()
    {
        return $this->getData(self::OBJUSER);
    }
    public function getImage()
    {
        return $this->getData(self::IMAGE);
    }
    
}