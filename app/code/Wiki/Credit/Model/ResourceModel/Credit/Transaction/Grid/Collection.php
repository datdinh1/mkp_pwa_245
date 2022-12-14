<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\Credit\Model\ResourceModel\Credit\Transaction\Grid;

use Magento\Framework\Event\ManagerInterface as EventManager;
use Magento\Framework\Data\Collection\Db\FetchStrategyInterface as FetchStrategy;
use Magento\Framework\Data\Collection\EntityFactoryInterface as EntityFactory;
use Psr\Log\LoggerInterface as Logger;

/**
 * App page collection
 */
class Collection extends \Magento\Framework\View\Element\UiComponent\DataProvider\SearchResult
{
    public function __construct(
        EntityFactory $entityFactory,
        Logger $logger,
        FetchStrategy $fetchStrategy,
        EventManager $eventManager
    ) {
        $mainTable = 'ves_store_credit_transaction';
        $resourceModel = 'Wiki\Credit\Model\ResourceModel\Credit\Transaction';
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $mainTable, $resourceModel);
    }


    protected function _construct()
    {
        parent::_construct();
        $fields = [
            'email',
            'name',
        ];
        foreach ($fields as $field) {
            $this->addFilterToMap(
                $field,
                'customer_grid.'.$field
            );
        }
    }

    /**
     * Init collection select
     *
     * @return $this
     */
    protected function _initSelect()
    {
        parent::_initSelect();
        $this->join(['customer_grid' => $this->getTable('customer_grid_flat')], "entity_id=customer_id",['email'=>'email','name'=>'name'],null,'left');
        return $this;
    }
}
