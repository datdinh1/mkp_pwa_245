<?php

namespace Wiki\VendorsApi\Model\Data;


/**
 * Class vendor
 * @SuppressWarnings(PHPMD.ExcessivePublicCount)
 */
class Notification extends \Magento\Framework\Api\AbstractExtensibleObject implements
    \Wiki\VendorsApi\Api\Data\NotificationInterface
{
    /**
     * @see \Wiki\VendorsApi\Api\Data\NotificationInterface::getId()
     */
    public function getId(){
        return $this->_get(self::ID);
    }
    
    /**
     * @see \Wiki\VendorsApi\Api\Data\NotificationInterface::setId()
     */
    public function setId($id){
        return $this->setData(self::ID, $id);
    }
    
    /**
     * @see \Wiki\VendorsApi\Api\Data\NotificationInterface::getType()
     */
    public function getType(){
        return $this->_get(self::TYPE);
    }
    
    /**
     * @see \Wiki\VendorsApi\Api\Data\NotificationInterface::setType()
     */
    public function setType($type){
        return $this->setData(self::TYPE, $type);
    }
    
    /**
     * @see \Wiki\VendorsApi\Api\Data\NotificationInterface::getMessage()
     */
    public function getMessage(){
        return $this->_get(self::MESSAGE);
    }
    
    /**
     * @see \Wiki\VendorsApi\Api\Data\NotificationInterface::setMessage()
     */
    public function setMessage($message){
        return $this->setData(self::MESSAGE, $message);
    }
    
    /**
     * @see \Wiki\VendorsApi\Api\Data\NotificationInterface::getAdditionalInfo()
     */
    public function getAdditionalInfo(){
        return $this->_get(self::ADDITIONAL_INFO);
    }
    
    /**
     * @see \Wiki\VendorsApi\Api\Data\NotificationInterface::setAdditionalInfo()
     */
    public function setAdditionalInfo($additionalInfo=[]){
        return $this->setData(self::ADDITIONAL_INFO, $additionalInfo);
    }
    
    /**
     * @see \Wiki\VendorsApi\Api\Data\NotificationInterface::getIsRead()
     */
    public function getIsRead(){
        return $this->_get(self::IS_READ);
    }
    
    /**
     * @see \Wiki\VendorsApi\Api\Data\NotificationInterface::setIsRead()
     */
    public function setIsRead($isRead){
        return $this->setData(self::IS_READ, $isRead);
    }
    
    /**
     * @see \Wiki\VendorsApi\Api\Data\NotificationInterface::getIsReached()
     */
    public function getIsReached(){
        return $this->_get(self::IS_REACHED);
    }
    
    /**
     * @see \Wiki\VendorsApi\Api\Data\NotificationInterface::setIsReached()
     */
    public function setIsReached($isReached){
        return $this->setData(self::IS_REACHED, $isReached);
    }
    
    /**
     * @see \Wiki\VendorsApi\Api\Data\NotificationInterface::getIsHidden()
     */
    public function getIsHidden(){
        return $this->_get(self::IS_HIDDEN);
    }
    
    /**
     * @see \Wiki\VendorsApi\Api\Data\NotificationInterface::setIsHidden()
     */
    public function setIsHidden($isHidden){
        return $this->setData(self::IS_HIDDEN, $isHidden);
    }
    
    
    /**
     * @see \Wiki\VendorsApi\Api\Data\NotificationInterface::getCreatedAt()
     */
    public function getCreatedAt(){
        return $this->_get(self::CREATED_AT);
    }
    
    /**
     * @see \Wiki\VendorsApi\Api\Data\NotificationInterface::setCreatedAt()
     */
    public function setCreatedAt($createdAt){
        return $this->setData(self::CREATED_AT, $createdAt);
    }
    
}
