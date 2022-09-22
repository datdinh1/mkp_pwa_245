<?php 
namespace Wiki\VendorsFaq\Model;

use Magento\Framework\Model\AbstractModel;
use Wiki\VendorsFaq\Api\Data\FaqInterface;

class Faq extends AbstractModel implements FaqInterface
{
	const CACHE_TAG = 'wiki_faq';
	public function _construct(){
		$this->_init("Wiki\VendorsFaq\Model\ResourceModel\Faq");
	}
	public function getIdentities()
	{
		return [self::CACHE_TAG . '_' . $this->getId()];
	}

    public function getDefaultValues()
	{
		$values = [];

		return $values;
	}

    /**
     * 
     * Get Vendor Id
     * @return string
     */
    public function getVendorId()
    {
        return $this->getData(self::VENDOR_ID);
    }

    /**
     * Set Vendor Id
     * @param string $vendor
     * @return $this
     */
    public function setVendorId($vendor)
    {
        return $this->setData(self::VENDOR_ID, $vendor);
	}

    /**
     * Get Title
     * @return string
     */
    public function getTitle()
    {
        return $this->getData(self::TITLE);
    }

    /**
     * Set Title
     * @param string $title
     * @return $this
     */
    public function setTitle($title)
    {
        return $this->setData(self::TITLE, $title);
	}

    /**
     * Get Type
     * @return string
     */
    public function getType()
    {
        return $this->getData(self::TYPE);
    }

    /**
     * Set Type
     * @param string $type
     * @return $this
     */
    public function setType($type)
    {
        return $this->setData(self::TYPE, $type);
	}

    /**
     * Get List Detail of FAQ
     * @return \Wiki\VendorsFaq\Api\Data\FaqDetailInterface[] 
     */
    public function getListDetail()
    {
        return $this->getData(self::LIST_DETAIL);
    }

    /**
     * Set  Assign Name
     * @param \Wiki\VendorsFaq\Api\Data\FaqDetailInterface[]  $list
     * @return $this
     */
    public function setListDetail($list)
    {
        return $this->setData(self::LIST_DETAIL, $list);
	}

}
 ?>