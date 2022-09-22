<?php

namespace Wiki\VendorsSubAccount\Model\ResourceModel\User\Grid;

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
        $mainTable = 'ves_vendor_user';
        $resourceModel = 'Magento\Customer\Model\ResourceModel\Customer';
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $mainTable, $resourceModel);
    }

    protected function _construct()
    {
        parent::_construct();

        $this->addFilterToMap(
            "vendor_id",
            'main_table.vendor_id'
        );
    }

    /**
     * Init collection select
     *
     * @return $this
     */
    protected function _initSelect()
    {
        parent::_initSelect();
        $this->getSelect()->join(
            ['customer'=>$this->getTable('customer_entity')],
            'customer.entity_id=main_table.customer_id',
            ['firstname'=>'firstname','lastname'=>'lastname','middlename'=>'middlename','email'=>'email', 'web_id' => 'website_id', 'store_id' => 'store_id']
        );
        return $this;
    }
}
