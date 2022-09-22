<?php
namespace Wiki\VendorsImportExport\Model\Import;

use Psr\Log\LoggerInterface;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\App\Response\Http\FileFactory;
use Magento\Store\Model\Store;
use Magento\CatalogImportExport\Model\Import\Product as ImportProduct;
use Magento\ImportExport\Model\Import;
use Magento\Framework\Stdlib\DateTime;
use Magento\Framework\Model\ResourceModel\Db\ObjectRelationProcessor;
use Magento\Framework\Model\ResourceModel\Db\TransactionManagerInterface;
use Magento\CatalogImportExport\Model\Import\Product\TaxClassProcessor;
use Magento\CatalogImportExport\Model\StockItemImporterInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\File\Csv;
use Magento\Catalog\Model\Product\Attribute\Backend\Sku;
use Magento\ImportExport\Model\Import\ErrorProcessing\ProcessingError;
use Magento\ImportExport\Model\Import\Entity\AbstractEntity;
use Magento\Store\Model\StoreManager;
use Magento\Eav\Model\Entity\Attribute\AbstractAttribute;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\ResourceModel\Eav\AttributeFactory;
use Magento\Indexer\Model\Indexer\CollectionFactory as IndexerCollectionFactory;

use Wiki\Vendors\Api\SellerManagementInterface;
use Wiki\VendorsImportExport\Model\Import\Product\CategoryProcessor as WikiImportExportCategoryProcessor;
use Wiki\Vendors\Model\Vendor;

class AbstractImport extends \Magento\CatalogImportExport\Model\Import\Product
{
    /**
     * @var Csv
     */
    protected $csv;

    /**
     * @var StockItemImporterInterface
     */
    protected $stockItemImporter;

    /**
     * @var Vendor
     */
    protected $vendor;

    /**
     * @var WikiImportExportCategoryProcessor
     */
    protected $customCategoryProcessor;

    /**
     * @var ProductCollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @var AttributeFactory
     */
    protected $attributeFactory;

    /**
     * @var IndexerCollectionFactory
     */
    protected $indexersFactory;

    /**
     * @var StoreManager
     */
    protected $storeManager;

    public function __construct(
        \Magento\Framework\App\Request\Http $request,
        \Magento\Framework\Json\Helper\Data $jsonHelper,
        \Magento\ImportExport\Helper\Data $importExportData,
        \Magento\ImportExport\Model\ResourceModel\Import\Data $importData,
        \Magento\Eav\Model\Config $config,
        \Magento\Framework\App\ResourceConnection $resource,
        \Magento\ImportExport\Model\ResourceModel\Helper $resourceHelper,
        \Magento\Framework\Stdlib\StringUtils $string,
        \Magento\ImportExport\Model\Import\ErrorProcessing\ProcessingErrorAggregatorInterface $errorAggregator,
        \Magento\Framework\Event\ManagerInterface $eventManager,
        \Magento\CatalogInventory\Api\StockRegistryInterface $stockRegistry,
        \Magento\CatalogInventory\Api\StockConfigurationInterface $stockConfiguration,
        \Magento\CatalogInventory\Model\Spi\StockStateProviderInterface $stockStateProvider,
        \Magento\Catalog\Helper\Data $catalogData,
        \Magento\ImportExport\Model\Import\Config $importConfig,
        \Magento\CatalogImportExport\Model\Import\Proxy\Product\ResourceModelFactory $resourceFactory,
        \Magento\CatalogImportExport\Model\Import\Product\OptionFactory $optionFactory,
        \Magento\Eav\Model\ResourceModel\Entity\Attribute\Set\CollectionFactory $setColFactory,
        \Magento\CatalogImportExport\Model\Import\Product\Type\Factory $productTypeFactory,
        \Magento\Catalog\Model\ResourceModel\Product\LinkFactory $linkFactory,
        \Magento\CatalogImportExport\Model\Import\Proxy\ProductFactory $proxyProdFactory,
        \Magento\CatalogImportExport\Model\Import\UploaderFactory $uploaderFactory,
        \Magento\Framework\Filesystem $filesystem,
        \Magento\CatalogInventory\Model\ResourceModel\Stock\ItemFactory $stockResItemFac,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $localeDate,
        DateTime $dateTime,
        LoggerInterface $logger,
        \Magento\Framework\Indexer\IndexerRegistry $indexerRegistry,
        \Magento\CatalogImportExport\Model\Import\Product\StoreResolver $storeResolver,
        \Magento\CatalogImportExport\Model\Import\Product\SkuProcessor $skuProcessor,
        \Magento\CatalogImportExport\Model\Import\Product\CategoryProcessor $categoryProcessor,
        \Magento\CatalogImportExport\Model\Import\Product\Validator $validator,
        ObjectRelationProcessor $objectRelationProcessor,
        TransactionManagerInterface $transactionManager,
        TaxClassProcessor $taxClassProcessor,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Catalog\Model\Product\Url $productUrl,
        array $data = [],
        // add custom
        Csv $csv,
        StockItemImporterInterface $stockItemImporter = null,
        Vendor $vendor,
        WikiImportExportCategoryProcessor $customCategoryProcessor,
        ProductCollectionFactory $collectionFactory,
        ProductRepositoryInterface $productRepository,
        AttributeFactory $attributeFactory,
        IndexerCollectionFactory $indexersFactory,
        StoreManager $storeManager
    )
    {
        parent::__construct(
            $jsonHelper,
            $importExportData,
            $importData,
            $config,
            $resource,
            $resourceHelper,
            $string,
            $errorAggregator,
            $eventManager,
            $stockRegistry,
            $stockConfiguration,
            $stockStateProvider,
            $catalogData,
            $importConfig,
            $resourceFactory,
            $optionFactory,
            $setColFactory,
            $productTypeFactory,
            $linkFactory,
            $proxyProdFactory,
            $uploaderFactory,
            $filesystem,
            $stockResItemFac,
            $localeDate,
            $dateTime,
            $logger,
            $indexerRegistry,
            $storeResolver,
            $skuProcessor,
            $categoryProcessor,
            $validator,
            $objectRelationProcessor,
            $transactionManager,
            $taxClassProcessor,
            $scopeConfig,
            $productUrl,
            $data
        );
        $this->csv = $csv;
        $this->stockItemImporter = $stockItemImporter ?: ObjectManager::getInstance()
            ->get(StockItemImporterInterface::class);
        $this->vendor = $vendor;
        $this->customCategoryProcessor = $customCategoryProcessor;
        $this->collectionFactory = $collectionFactory;
        $this->attributeFactory = $attributeFactory;
        $this->indexersFactory = $indexersFactory->create()->getItems();
        $this->storeManager = $storeManager;
    }
}
