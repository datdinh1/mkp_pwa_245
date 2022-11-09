<?php
namespace Wiki\VendorsImportExport\Model\Import\Product;

use Magento\Framework\Stdlib\DateTime;

class CategoryProcessor extends \Magento\CatalogImportExport\Model\Import\Product\CategoryProcessor
{

    protected $generateUrl;

    protected $resource;

    protected $storeId;

    protected $attributes = [
        'name',
        'is_active',
        'include_in_menu',
        'url_key',
        'url_path'
    ];

    /**
     * @var \Magento\Framework\Stdlib\DateTime\TimezoneInterface
     */
    protected $localeDate;

    public function __construct(
        \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoryColFactory,
        \Magento\Catalog\Model\CategoryFactory $categoryFactory,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $localeDate
    ) {
        $this->localeDate = $localeDate;
        parent::__construct($categoryColFactory, $categoryFactory);
    }

    /**
     * @param $rowData
     * @return array
     */
    public function getRowCategories($rowData, $separator)
    {
        $categoryIds = [];
        if ( isset($rowData["categories"]) && !empty($rowData["categories"]) ){
            $categoriesData = explode($separator, $rowData["categories"]);

            foreach ( $categoriesData as $categories ){
                if ( $categories == '/' || $categories == '' ){
                    continue;
                }
                $secondCategory = null;
                if ( is_numeric($categories) ){
                    $collectionId = $this->categoryColFactory->create()->addFieldToFilter('entity_id', $categories);
                    if ( $collectionId->getSize() ){
                        $secondCategory = $collectionId->getFirstItem()->getId();
                    }
                } else {
                    $collection = $this->categoryColFactory->create()->addFieldToFilter('path', $categories);
                    if ( $collection->getSize() ){
                        $secondCategory = $categories;
                    }
                }
                if ( empty($secondCategory) ){
                    try {
                        $secondCategory = $this->upsertCategory($categories);
                    } catch ( \Magento\Framework\Exception\AlreadyExistsException $e ){
                        $this->addFailedCategory($categories, $e);
                    }
                }
                $categoryIds[] = $secondCategory;
            }
        }

        return $categoryIds;
    }

    /**
     * @param string $category
     * @param \Magento\Framework\Exception\AlreadyExistsException $exception
     * @return $this
     */
    private function addFailedCategory($category, $exception)
    {
        $this->failedCategories[] =
            [
                'category' => $category,
                'exception' => $exception,
            ];
        return $this;
    }

    protected function checkUrlKeyDuplicates($url, $category, $number)
    {
        if ($this->getGenerateUrl()) {
            $resource = $this->getResource();
            $select = $resource->getConnection()->select()->from(
                ['url_rewrite' => $resource->getTable('url_rewrite')],
                ['request_path', 'store_id']
            )->where('request_path LIKE "%' . $url . '.html"');
            $urlKeyDuplicates = $resource->getConnection()->fetchAssoc(
                $select
            );
            if (count($urlKeyDuplicates) > 0) {
                $url = $this->checkUrlKeyDuplicates(
                    $category->formatUrlKey($category->getName()) . "-" . $number,
                    $category,
                    $number + 1
                );
            }
        }

        return $url;
    }

    public function setGeneratUrl($number)
    {
        $this->generateUrl = $number;
    }

    public function getGenerateUrl()
    {
        return $this->generateUrl;
    }

    public function setResource($resource)
    {
        $this->resource = $resource;
    }

    public function getResource()
    {
        return $this->resource;
    }

    public function setStoreId($storeId)
    {
        $this->storeId = $storeId;
    }

    public function getStoreId()
    {
        return $this->storeId;
    }
}
