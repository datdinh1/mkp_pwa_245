<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\VendorsCustomTheme\Ui\DataProvider\Page\Vendor;

use Magento\Cms\Model\ResourceModel\Page\CollectionFactory;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\SearchCriteriaBuilder;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\View\Element\UiComponent\DataProvider\Reporting;
use Magento\Framework\Api\Filter;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\AuthorizationInterface;
/**
 * Class ProductDataProvider
 */
class PageDataProvider extends \Magento\Cms\Ui\Component\DataProvider
{

//    /**
//     * Construct
//     *
//     * @param string $name
//     * @param string $primaryFieldName
//     * @param string $requestFieldName
//     * @param CollectionFactory $collectionFactory
//     * @param \Magento\Ui\DataProvider\AddFieldToCollectionInterface[] $addFieldStrategies
//     * @param \Magento\Ui\DataProvider\AddFilterToCollectionInterface[] $addFilterStrategies
//     * @param array $meta
//     * @param array $data
//     */
//    public function __construct(
//        $name,
//        $primaryFieldName,
//        $requestFieldName,
//        CollectionFactory $collectionFactory,
//        \Wiki\Vendors\Model\Session $vendorSession,
//        array $addFieldStrategies = [],
//        array $addFilterStrategies = [],
//        array $meta = [],
//        array $data = []
//    ) {
//        parent::__construct($name, $primaryFieldName, $requestFieldName, $collectionFactory, $addFieldStrategies, $addFilterStrategies, $meta, $data);
//        $this->collection->addAttributeToFilter('vendor_id', $vendorSession->getVendor()->getId());
//        $this->collection->joinField(
//            'qty',
//            'cataloginventory_stock_item',
//            'qty',
//            'product_id=entity_id',
//            '{{table}}.stock_id=1',
//            'left'
//        );
//        /*Join with vendor table.*/
//        //$this->collection->joinTable($this->collection->getTable('ves_vendor_entity'), "entity_id=vendor_id",['vendor_identifier'=>'vendor_id'],null,'left');
//    }
    public function __construct(
        $name, 
        $primaryFieldName, 
        $requestFieldName, 
        Reporting $reporting, 
        SearchCriteriaBuilder $searchCriteriaBuilder, 
        RequestInterface $request, 
        FilterBuilder $filterBuilder,
        \Wiki\Vendors\Model\Session $vendorSession,
        array $meta = [], 
        array $data = [], 
        array $additionalFilterPool = []
    ){
        parent::__construct(
            $name, 
            $primaryFieldName, 
            $requestFieldName, 
            $reporting, 
            $searchCriteriaBuilder, 
            $request, 
            $filterBuilder, 
            $meta, 
            $data, 
            $additionalFilterPool
        );
        $this->collection->addAttributeToFilter('vendor_id', $vendorSession->getVendor()->getId());
        $this->collection->joinField(
            'qty',
            'cataloginventory_stock_item',
            'qty',
            'product_id=entity_id',
            '{{table}}.stock_id=1',
            'left'
        );
    }
}
