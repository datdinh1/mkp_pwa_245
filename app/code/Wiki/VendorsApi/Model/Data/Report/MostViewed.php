<?php

namespace Wiki\VendorsApi\Model\Data\Report;

class MostViewed extends \Magento\Framework\Api\AbstractExtensibleObject implements
    \Wiki\VendorsApi\Api\Data\Report\MostViewedInterface
{
    /**
     * @see \Wiki\VendorsApi\Api\Data\Report\MostViewedInterface::getId()
     */
    public function getId(){
        return $this->_get(self::ID);
    }
    
    /**
     * @see \Wiki\VendorsApi\Api\Data\Report\MostViewedInterface::setId()
     */
    public function setId($id){
        return $this->setData(self::ID, $id);
    }
    
    /**
     * @see \Wiki\VendorsApi\Api\Data\Report\MostViewedInterface::getName()
     */
    public function getName(){
        return $this->_get(self::NAME);
    }
    
    /**
     * @see \Wiki\VendorsApi\Api\Data\Report\MostViewedInterface::setName()
     */
    public function setName($name){
        return $this->setData(self::NAME, $name);
    }
    
    /**
     * @see \Wiki\VendorsApi\Api\Data\Report\MostViewedInterface::getPrice()
     */
    public function getPrice(){
        return $this->_get(self::PRICE);
    }
    
    /**
     * @see \Wiki\VendorsApi\Api\Data\Report\MostViewedInterface::setPrice()
     */
    public function setPrice($price){
        return $this->setData(self::PRICE, $price);
    }
    
    /**
     * @see \Wiki\VendorsApi\Api\Data\Report\MostViewedInterface::getViewCount()
     */
    public function getViewCount(){
        return $this->_get(self::VIEW_COUNT);
    }
    
    /**
     * @see \Wiki\VendorsApi\Api\Data\Report\MostViewedInterface::setViewCount()
     */
    public function setViewCount($viewCount){
        return $this->setData(self::VIEW_COUNT, $viewCount);
    }
    
}
