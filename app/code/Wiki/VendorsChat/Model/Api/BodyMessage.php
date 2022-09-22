<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Wiki\VendorsChat\Model\Api;

/**
 * Softprodigy Dailydeal date model
 */
class BodyMessage extends \Magento\Framework\Model\AbstractModel implements \Wiki\VendorsChat\Api\Data\BodyMessageInterface
{
    /**
     * Get Content
     *
     * @return \Wiki\VendorsChat\Api\Data\MessageInterface[]
     */
    public function getContent()
    {
        return $this->getData(self::CONTENT);
    }

    /**
     * Set Content
     *
     * @param \Wiki\VendorsChat\Api\Data\MessageInterface[] $content
     * @return $this
     */
    public function setContent($content)
    {
        return $this->setData(self::CONTENT, $content);
    }

    /**
     * Get Seller
     *
     * @return \Wiki\Vendors\Api\Data\SellerInterface|null
     */
    public function getSeller()
    {
        return $this->getData(self::SELLER);
    }

    /**
     * Set Seller
     * @param \Wiki\Vendors\Api\Data\SellerInterface $seller
     * @return $this
     */
    public function setSeller($seller)
    {
        return $this->setData(self::SELLER, $seller);
    }

    /**
     * Get Buyer
     *
     * @return \Magento\Customer\Api\Data\CustomerInterface|null
     */
    public function getBuyer()
    {
        return $this->getData(self::BUYER);
    }

    /**
     * Set Buyer
     *
     * @param \Magento\Customer\Api\Data\CustomerInterface $customer
     * @return $this
     */
    public function setBuyer($customer)
    {
        return $this->setData(self::BUYER, $customer);
    }
}
