<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\StoreApi\Api\Data;

interface CardInterface
{
    /**
     * @return string|int
     */
    public function getCardId();

    /**
     * @param string|int $cardId
     * @return $this
     */
    public function setCardId($cardId);

    /**
     * @return string|int
     */
    public function getCustomerId();

    /**
     * @param string|int $customerId
     * @return $this
     */
    public function setCustomerId($customerId);

    /**
     * @return string|null
     */
    public function getType();

    /**
     * @param string $type
     * @return $this
     */
    public function setType($type);

    /**
     * @return string|null
     */
    public function getToken();

    /**
     * @param string $token
     * @return $this
     */
    public function setToken($token);

    /**
     * @return string|int
     */
    public function getActive();

    /**
     * @param string|int $active
     * @return $this
     */
    public function setActive($active);
}
