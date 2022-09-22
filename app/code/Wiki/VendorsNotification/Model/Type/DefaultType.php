<?php
namespace Wiki\VendorsNotification\Model\Type;

use Wiki\VendorsNotification\Model\Type\TypeInterface;
use Wiki\VendorsNotification\Model\Notification;
use Wiki\Vendors\Model\UrlInterface;

class DefaultType implements TypeInterface
{

    /**
     * @var \Wiki\VendorsNotification\Model\Notification
     */
    protected $_notification;
    
    /**
     * @var \Wiki\Vendors\Model\UrlInterface
     */
    protected $_urlBuilder;
    
    /**
     * Constructor
     *
     * @param Notification $notification
     * @param UrlInterface $urlBuilder
     */
    public function __construct(
        Notification $notification,
        UrlInterface $urlBuilder
    ) {
        $this->_notification = $notification;
        $this->_urlBuilder = $urlBuilder;
    }

    /**
     * (non-PHPdoc)
     * @see \Wiki\VendorsNotification\Model\Type\TypeInterface::getMessage()
     */
    public function getMessage()
    {
        return $this->_notification->getMessage();
    }
    /**
     * (non-PHPdoc)
     * @see \Wiki\VendorsNotification\Model\Type\TypeInterface::getIconClass()
     */
    public function getIconClass()
    {
        return 'fa fa-envelope text-red';
    }
    
    /**
     * (non-PHPdoc)
     * @see \Wiki\VendorsNotification\Model\Type\TypeInterface::getUrl()
     */
    public function getUrl()
    {
        return '#';
    }
}
