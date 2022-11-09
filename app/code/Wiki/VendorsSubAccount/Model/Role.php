<?php
/**
 * Copyright (c) 2017 Wiki Co ltd. All rights reserved.
 */

namespace Wiki\VendorsSubAccount\Model;

use Magento\Framework\App\ObjectManager;
/**
 * Class Message
 * @package Wiki\Quotation\Model
 * @method string getAuthor()
 * @method Message setAuthor($author)
 * @method string getMessage()
 * @method Message setMessage($message)
 * @method string getCreatedAt()
 * @method Message setCreatedAt($time)
 */
class Role extends \Magento\Framework\Model\AbstractModel
{
    const ALLOWED_RESOURCE = 'Wiki_Vendors::allowed';
    
    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'vendors_role';

    /**
     * Parameter name in event
     *
     * In observe method you can use $observer->getEvent()->getObject() in this case
     *
     * @var string
     */
    protected $_eventObject = 'role';

    /**
     * Selected resources
     * 
     * @var array
     */
    protected $resources;
    
    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Wiki\VendorsSubAccount\Model\ResourceModel\Role');
    }

    /**
     * Update resources
     * 
     * @param array $resources
     */
    public function updateResources($resources = []){
        $this->getResource()->updateResources($this, $resources);
        return $this;
    }
    
    /**
     * Get Selected Resources
     * 
     * @return array
     */
    public function getSelectedResources(){
        if(!$this->resources){
            $this->resources = $this->getResource()->getSelectedResources($this); 
        }
        return $this->resources;
    }
    
    /**
     * Get Root Resource
     * 
     * @return \Wiki\VendorsAcl\Model\AclResource\RootResource
     */
    public function getRootResource(){
        return ObjectManager::getInstance()->get('Wiki\VendorsAcl\Model\AclResource\RootResource')->getId();
    }
    
    /**
     * Permission of a resource
     * 
     * @param string $resource
     * @return boolean
     */
    public function checkPermission($resource = ''){
        $resources = $this->getSelectedResources();
        return $resource == self::ALLOWED_RESOURCE ||
        in_array($this->getRootResource(), $resources) ||
         in_array($resource, $resources);
    }
    
    /**
     * Get all user id related to the role.
     * 
     * @return array
     */
    public function getAllUserIds(){
        return $this->getResource()->getAllUserIds($this);
    }
}
