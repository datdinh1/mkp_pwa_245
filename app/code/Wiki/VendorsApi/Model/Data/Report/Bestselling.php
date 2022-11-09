<?php

namespace Wiki\VendorsApi\Model\Data\Report;

class Bestselling extends \Magento\Framework\Api\AbstractExtensibleObject implements
    \Wiki\VendorsApi\Api\Data\Report\BestsellingInterface
{
    /**
     * @see \Wiki\VendorsApi\Api\Data\Report\BestsellingInterface::getId()
     */
    public function getId(){
        return $this->_get(self::ID);
    }
    
    /**
     * @see \Wiki\VendorsApi\Api\Data\Report\BestsellingInterface::setId()
     */
    public function setId($id){
        return $this->setData(self::ID, $id);
    }
    
    /**
     * @see \Wiki\VendorsApi\Api\Data\Report\BestsellingInterface::getName()
     */
    public function getName(){
        return $this->_get(self::NAME);
    }
    
    /**
     * @see \Wiki\VendorsApi\Api\Data\Report\BestsellingInterface::setName()
     */
    public function setName($name){
        return $this->setData(self::NAME, $name);
    }
    
    /**
     * @see \Wiki\VendorsApi\Api\Data\Report\BestsellingInterface::getPrice()
     */
    public function getPrice(){
        return $this->_get(self::PRICE);
    }
    
    /**
     * @see \Wiki\VendorsApi\Api\Data\Report\BestsellingInterface::setPrice()
     */
    public function setPrice($price){
        return $this->setData(self::PRICE, $price);
    }
    
    /**
     * @see \Wiki\VendorsApi\Api\Data\Report\BestsellingInterface::getQty()
     */
    public function getQty(){
        return $this->_get(self::QTY);
    }
    
    /**
     * @see \Wiki\VendorsApi\Api\Data\Report\BestsellingInterface::setQty()
     */
    public function setQty($qty){
        return $this->setData(self::QTY, $qty);
    }
    
}
