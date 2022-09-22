<?php 
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\StoreApi\Api;
 
interface CardManagementInterface 
{
    /**
     * @api
     * @param \Wiki\StoreApi\Api\Data\CardInterface $card
     * @return \Wiki\StoreApi\Api\Data\CardInterface
     * @throws \Exception
     */
    public function addCardInfo($card);

    /**
     * @api
     * @param int $cardId
     * @return bool
     * @throws \Exception
     */
    public function deleteCardInfo($cardId);
}
