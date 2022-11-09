<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\Core\Model;

class Key extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'ves_license';

    /**
     * Parameter name in event
     *
     * In observe method you can use $observer->getEvent()->getLicense() in this case
     *
     * @var string
     */
    protected $_eventObject = 'license';

    /**
     * @var \Wiki\Core\Test\Api
     */
    protected $_api;
    
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Wiki\Core\Model\ResourceModel\Key');
    }
    
    /**
     * Get API
     * 
     * @return \Wiki\Core\Test\Api
     */
    public function getApi(){
        if(!$this->_api){
            $this->_api = \Magento\Framework\App\ObjectManager::getInstance()->create('Wiki\Core\Test\Api');
        }
        
        return $this->_api;
    }
    /**
     * Get key info from remote server
     * 
     * @param string $licenseKey
     * @return Ambigous <\Zend\Http\Response, string, \Zend\Http\Response\Stream, unknown, \Zend\Http\Response\Stream>
     */
    public function getKeyInfo($licenseKey)
    {
        return $this->getApi()->getKeyInfo($licenseKey);
    }

    /**
     * Get extensions list from remote server
     *
     * @return Ambigous <\Zend\Http\Response, string, \Zend\Http\Response\Stream, unknown, \Zend\Http\Response\Stream>
     */
    public function getExtensionsList()
    {
        return $this->getApi()->getExtensionsList();
    }
    
    /**
     * Save the license key from remote server (Wiki.com).
     * 
     * @param string $licenseKey
     * @param array $domains
     * @throws LocalizedException
     * @return mixed
     */
    public function remoteSaveLicenseKey($licenseKey, $domains = [])
    {
        return $this->getApi()->remoteSaveLicenseKey($licenseKey, $domains);
    }
    
    /**
     * Get secure key
     * 
     * @return string
     */
    public function getSecureKey(){
        return $this->getApi()->getSecureKey();
    }
    
    /**
     * Decode the saved key
     * 
     * @return string|boolean
     */
    public function getSavedKeyInfo(){
        return $this->getApi()->getSavedKeyInfo($this);
    }
}
