<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\StoreApi\Model\Api;

use Wiki\StoreApi\Model\CardFactory;
use Wiki\StoreApi\Api\CardManagementInterface;
use Magento\Framework\App\ResourceConnection;

class CardManagement implements CardManagementInterface
{
    /**
     * @var ResourceConnection
     */
    private $resource;

    /**
     * @var CardFactory
     */
    private $cardFactory;

    /**
     * @param CardFactory $cardFactory
     */
    public function __construct(
        ResourceConnection $resource,
        CardFactory $cardFactory
    ) {
        $this->resource = $resource;
        $this->cardFactory = $cardFactory;
    }

    /**
	 * {@inheritdoc}
	 */
    public function addCardInfo($card) 
    {
        try {
            if (!empty($card->getToken())) {
                $card->save();
                if ($card->getActive() == 1) {
                    $this->unActiveCards($card->getId());
                }
                return $card;
            }
        }
        catch (\Exception $e) { }
        return false;
    }

    private function unActiveCards($cardId)
    {
        $connection = $this->resource->getConnection();
        $table = $this->resource->getTableName('wiki_card_token');
        $data = [
            'active' => 0,
        ];
        $connection->update($table, $data, ['card_id != ?' => $cardId]);
    }

    /**
	 * {@inheritdoc}
	 */
    public function deleteCardInfo($cardId)
    {
        try {
            $card = $this->cardFactory->create()->load($cardId);
            if (!$card->getId()) {
                throw new \Exception('This card does not exist.');
            }
            $card->delete();
        }
        catch (\Exception $e) {
            return false;
        }
        return true;
    }
}
