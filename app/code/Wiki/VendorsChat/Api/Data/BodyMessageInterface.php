<?php

namespace Wiki\Vendorschat\Api\Data;

/**
 * Interface CommentInterface
 * @package Mageplaza\Blog\Api\Data
 */
interface BodyMessageInterface
{
    /**
     * Constants used as data array keys
     */
    const CONTENT          = 'content';
    const SELLER           = 'seller';
    const BUYER            = 'buyer';




    /**
     * Get Content
     *
     * @return \Wiki\VendorsChat\Api\Data\MessageInterface[]
     */
    public function getContent();

    /**
     * Set Content
     *
     * @param \Wiki\VendorsChat\Api\Data\MessageInterface[] $id
     *
     * @return $this
     */
    public function setContent($id);

    /**
     * Get Seller
     *
     * @return \Wiki\Vendors\Api\Data\SellerInterface|null
     */
    public function getSeller();

    /**
     * Set Seller
     *
     * @param \Wiki\Vendors\Api\Data\SellerInterface $seller
     *
     * @return $this
     */
    public function setSeller($seller);

    /**
     * Get Buyer
     *
     * @return \Magento\Customer\Api\Data\CustomerInterface|null
     */
    public function getBuyer();

    /**
     * Set Buyer
     *
     * @param \Magento\Customer\Api\Data\CustomerInterface $buyer
     *
     * @return $this
     */
    public function setBuyer($body);
}
