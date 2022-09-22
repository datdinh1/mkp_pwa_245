<?php
namespace Wiki\VendorsConfigApproval\Model\NotificationType;

class ConfigApproval extends \Wiki\VendorsNotification\Model\Type\DefaultType
{

    /**
     * @var Type code
     */
    const CODE = 'config_approval';
    
    /**
     * (non-PHPdoc)
     * @see \Wiki\VendorsNotification\Model\Type\TypeInterface::getIconClass()
     */
    public function getIconClass()
    {
        return 'fa fa-cog text-red';
    }
    
    /**
     * Get order URL
     * @see \Wiki\VendorsNotification\Model\Type\TypeInterface::getUrl()
     */
    public function getUrl()
    {
        try {
            $additionalInfo = unserialize($this->_notification->getAdditionalInfo());
            $additionalInfo = $additionalInfo['path'];
            $section = explode("/",$additionalInfo);
            $section = $section[0];
            $hash = 'row_'.str_replace("/", "_", $additionalInfo);
            
            return $this->_urlBuilder->getUrl('config/index/edit', ['section' => $section]).'#'.$hash;
        } catch (\Exception $e) {
            return parent::getUrl();
        }
    }
}
