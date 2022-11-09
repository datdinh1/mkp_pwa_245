<?php
namespace Wiki\VendorsImportExport\Model\Export;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\App\Response\Http\FileFactory;
use Magento\Store\Model\Store;
use Magento\CatalogImportExport\Model\Import\Product as ImportProduct;
use Magento\ImportExport\Model\Import;

use Wiki\Vendors\Api\SellerManagementInterface;
use Wiki\Vendors\Model\Vendor;

class AbstractExport extends \Magento\CatalogImportExport\Model\Export\Product
{
    /**
     * @var DirectoryList
     */
    protected $directoryList;

    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * @var Vendor
     */
    protected $vendorsModel;

    /**
     * @var ResourceConnection
     */
    protected $resource;

    /**
     * @var SellerManagementInterface
     */
    protected $sellerManagement;

    /**
     * @var FileFactory
     */
    protected $fileFactory;

    public function __construct(
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $localeDate,
        \Magento\Eav\Model\Config $config,
        \Magento\Framework\App\ResourceConnection $resource,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $collectionFactory,
        \Magento\ImportExport\Model\Export\ConfigInterface $exportConfig,
        \Magento\Catalog\Model\ResourceModel\ProductFactory $productFactory,
        \Magento\Eav\Model\ResourceModel\Entity\Attribute\Set\CollectionFactory $attrSetColFactory,
        \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoryColFactory,
        \Magento\CatalogInventory\Model\ResourceModel\Stock\ItemFactory $itemFactory,
        \Magento\Catalog\Model\ResourceModel\Product\Option\CollectionFactory $optionColFactory,
        \Magento\Catalog\Model\ResourceModel\Product\Attribute\CollectionFactory $attributeColFactory,
        \Magento\CatalogImportExport\Model\Export\Product\Type\Factory $_typeFactory,
        \Magento\Catalog\Model\Product\LinkTypeProvider $linkTypeProvider,
        \Magento\CatalogImportExport\Model\Export\RowCustomizerInterface $rowCustomizer,
        DirectoryList $directoryList,
        FileFactory $fileFactory,
        Filesystem $filesystem,
        Vendor $vendorsModel,
        SellerManagementInterface $sellerManagement,
        array $dateAttrCodes = []
    ) {
        parent::__construct(
            $localeDate,
            $config,
            $resource,
            $storeManager,
            $logger,
            $collectionFactory,
            $exportConfig,
            $productFactory,
            $attrSetColFactory,
            $categoryColFactory,
            $itemFactory,
            $optionColFactory,
            $attributeColFactory,
            $_typeFactory,
            $linkTypeProvider,
            $rowCustomizer,
            $dateAttrCodes
        );
        $this->fileFactory                 = $fileFactory;
        $this->directoryList               = $directoryList;
        $this->directory                   = $filesystem->getDirectoryWrite(DirectoryList::VAR_DIR);
        $this->filesystem                  = $filesystem;
        $this->vendorsModel                = $vendorsModel;
        $this->resource                    = $resource;
        $this->path                        = "export";
        $this->sellerManagement            = $sellerManagement;
    }
}