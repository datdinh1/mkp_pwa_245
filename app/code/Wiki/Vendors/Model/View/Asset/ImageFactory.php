<?php
namespace Wiki\Vendors\Model\View\Asset;

/**
 * Factory class for @see \Magento\Catalog\Model\View\Asset\Image
 */
class ImageFactory extends \Magento\Catalog\Model\View\Asset\ImageFactory
{
    /**
     * Factory constructor
     *
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     * @param string $instanceName
     */
    public function __construct(\Magento\Framework\ObjectManagerInterface $objectManager, $instanceName = '\\Wiki\\Vendors\\Model\\View\\Asset\\Image')
    {
        parent::__construct($objectManager, $instanceName);
    }
}
