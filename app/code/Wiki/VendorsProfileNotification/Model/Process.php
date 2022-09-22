<?php
namespace Wiki\VendorsProfileNotification\Model;

use Magento\Framework\App\ObjectManager;

class Process extends \Magento\Framework\Model\AbstractModel
{

    const STATUS_ENABLED    = 1;
    const STATUS_DISABLED   = 0;
    
    
    /**
     * Model event prefix
     *
     * @var string
     */
    protected $_eventPrefix = 'vendor_profile_process';
    
    /**
     * Name of the event object
     *
     * @var string
     */
    protected $_eventObject = 'vendor_profile_process';
    
    /**
     * Initialize customer model
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init('Wiki\VendorsProfileNotification\Model\ResourceModel\Process');
    }
    
    /**
     * @return \Wiki\VendorsProfileNotification\Helper\Data
     */
    public function getHelper(){
        $om = ObjectManager::getInstance();
        return $om->get('Wiki\VendorsProfileNotification\Helper\Data');
    }
    
    /**
     * @return \Wiki\VendorsProfileNotification\Model\Type\TypeInterface
     */
    public function getType(){
        return $this->getHelper()->getType($this->getData('type'));
    }
    
    /**
     * Process data before save.
     * 
     * @see \Magento\Framework\Model\AbstractModel::beforeSave()
     */
    public function beforeSave(){
        $this->getType()->beforeSaveProcess($this);
        return parent::beforeSave();
    }
    
    /**
     * Process data after load
     * @see \Magento\Framework\Model\AbstractModel::afterLoad()
     */
    public function afterLoad(){
        $this->getType()->afterLoadProcess($this);
        return parent::afterLoad();
    }
    
    /**
     * Is completed process
     * 
     * @param \Wiki\Vendors\Model\Vendor $vendor
     * @return boolean
     */
    public function isCompleted(\Wiki\Vendors\Model\Vendor $vendor){
        return $this->getType()->isCompletedProcess($this, $vendor);
    }
    
    /**
     * Get URL
     * 
     * @return string
     */
    public function getUrl(){
        return $this->getType()->getUrl($this);
    }
}
