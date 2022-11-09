<?php

namespace Wiki\VendorsSales\Model;

use Magento\Framework\Model\AbstractModel;
use Wiki\VendorsSales\Api\Data\RequestReturnOrderInterface;

class RequestReturnOrder extends AbstractModel implements RequestReturnOrderInterface
{
    const CACHE_TAG = 'wiki_request_return_order';

	protected $_cacheTag = 'wiki_request_return_order';

	protected $_eventPrefix = 'wiki_request_return_order';
    /**
     * Define resource model
     */
    protected function _construct()
    {
        $this->_init('Wiki\VendorsSales\Model\ResourceModel\RequestReturnOrder');
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
     * Get Order Id
     * @return string
     */
    public function getOrderId()
    {
        return $this->getData(self::ORDER_ID);
    }

    /**
     * Set Order Id
     * @param int $id
     * @return $this
     */
    public function setOrderId($id)
    {
        return $this->setData(self::ORDER_ID, $id);
	}
	
	/**
     * Get Items
     * @return int[]
     */
    public function getItems()
    {
        return $this->getData(self::ITEMS);
    }

    /**
     * Set Items
     * @param int[] $item
     * @return $this
     */
    public function setItems($item)
    {
        return $this->setData(self::ITEMS, $item);
	}
	
	/**
     * Get Reason
     * @return string
     */
    public function getReason()
    {
        return $this->getData(self::REASON);
    }

    /**
     * Set Reason
     * @param string $reason
     * @return $this
     */
    public function setReason($reason)
    {
        return $this->setData(self::REASON, $reason);
	}
	
	/**
     * Get Picture
     * @return string[]
     */
    public function getPicture()
    {
        return $this->getData(self::PICTURE);
    }

    /**
     * Set Picture
     * @param string[] $pic
     * @return $this
     */
    public function setPicture($pic)
    {
        return $this->setData(self::PICTURE, $pic);
	}
    
    /**
     * @inheritdoc
     */
    public function getContentOfSeller()
    {
        return $this->getData(self::CONTENT);
    }

    /**
     * @inheritdoc
     */
    public function setContentOfSeller($content)
    {
        return $this->setData(self::CONTENT, $content);
    }
    
    /**
     * @inheritdoc
     */
    public function getStatusOfSeller()
    {
        return $this->getData(self::STATUS);
    }

    /**
     * @inheritdoc
     */
    public function setStatusOfSeller($status)
    {
        return $this->setData(self::STATUS, $status);
	}
}
