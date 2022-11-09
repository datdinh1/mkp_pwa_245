<?php

namespace Wiki\Vendorschat\Api\Data;

/**
 * Interface CommentInterface
 * @package Mageplaza\Blog\Api\Data
 */
interface InfoRoomInterface
{
    /**
     * Constants used as data array keys
     */
    const SELLER           = 'seller';
    const BUYER            = 'buyer';
    const ROOM             = 'room';

    /**
     * Get Seller
     *
     * @return \Wiki\Vendors\Api\Data\SellerInterface
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
     * @return \Magento\Customer\Api\Data\CustomerInterface
     */
    public function getBuyer();

    /**
     * Set Buyer
     *
     * @param \Magento\Customer\Api\Data\CustomerInterface $buyer
     *
     * @return $this
     */
    public function setBuyer($buyer);

    /**
     * Get Room
     *
     * @return \Wiki\VendorsChat\Api\Data\RoomInterface|null
     */
    public function getRoom();

    /**
     * Set Room
     *
     * @param \Wiki\VendorsChat\Api\Data\RoomInterface|null $room
     *
     * @return $this
     */
    public function setRoom($room);
}
