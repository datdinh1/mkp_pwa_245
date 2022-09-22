<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\VendorsSalesRule\Model\Rule;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\SalesRule\Model\ResourceModel\Rule\Collection;
use Magento\SalesRule\Model\ResourceModel\Rule\CollectionFactory;
use Magento\SalesRule\Model\Rule;
/**
 * Class DataProvider
 */
class DataProvider extends \Magento\SalesRule\Model\Rule\DataProvider
{
    /**
     * @var Collection
     */
    protected $collection;
    /**
     * @var array
     */
    protected $loadedData;
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $coreRegistry;
    /**
     * @var \Magento\SalesRule\Model\Rule\Metadata\ValueProvider
     */
    protected $metadataValueProvider;
    /**
     * @var DataPersistorInterface
     */
    private $dataPersistor;
   /**
    * Initialize dependencies.
    *
    * @param string $name
    * @param string $primaryFieldName
    * @param string $requestFieldName
    * @param CollectionFactory $collectionFactory
    * @param \Magento\Framework\Registry $registry
    * @param \Magento\SalesRule\Model\Rule\Metadata\ValueProvider $metadataValueProvider
    * @param array $meta
    * @param array $data
    * @param DataPersistorInterface $dataPersistor
    */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        \Magento\Framework\Registry $registry,
        \Magento\SalesRule\Model\Rule\Metadata\ValueProvider $metadataValueProvider,
        array $meta = [],
        array $data = [],
        DataPersistorInterface $dataPersistor = null
    ){
        parent::__construct(
            $name,
            $primaryFieldName,
            $requestFieldName,
            $collectionFactory,
            $registry,
            $metadataValueProvider,
            $meta,
            $data,
            $dataPersistor
        );
        $this->collection = $collectionFactory->create();
        $this->coreRegistry = $registry;
        $this->metadataValueProvider = $metadataValueProvider;
        $meta = array_replace_recursive($this->getMetadataValues(), $meta);
        $this->dataPersistor = $dataPersistor ?? \Magento\Framework\App\ObjectManager::getInstance()->get(
            DataPersistorInterface::class
        );
    }
    /**
     * Get metadata values
     *
     * @return array
     */
    protected function getMetadataValues()
    {
        $rule = $this->coreRegistry->registry(\Magento\SalesRule\Model\RegistryConstants::CURRENT_SALES_RULE);
        return $this->metadataValueProvider->getMetadataValues($rule);
    }
    /**
     * @inheritdoc
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $storemanage = $objectManager->create('\Magento\Store\Model\StoreManagerInterface');
        $items = $this->collection->getItems();
        /** @var Rule $rule */
        foreach ($items as $rule) {
            $rule->load($rule->getId());
            $rule->setDiscountAmount($rule->getDiscountAmount() * 1);
            $rule->setDiscountQty($rule->getDiscountQty() * 1);
            $this->loadedData[$rule->getId()] = $rule->getData();
            $data = $this->dataPersistor->get('sale_rule');
            if (!empty($data)) {
                $rule = $this->collection->getNewEmptyItem();
                $rule->setData($data);
                $this->loadedData[$rule->getId()] = $rule->getData();
                $this->dataPersistor->clear('sale_rule');
            }
            $image = [];
            $image[0]['name'] = "image";
            if ( $rule->getImage() ){
                $image[0]['url'] = $storemanage->getStore()->getBaseUrl() ."pub/media/sampleimageuploader/images/image" . $rule->getImage();
                $rule->setImage($image);
                $this->loadedData[$rule->getId()]["image"] = $image;
            }
        }
        return $this->loadedData;
    }
}