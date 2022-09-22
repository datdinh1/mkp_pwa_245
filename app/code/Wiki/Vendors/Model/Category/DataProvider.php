<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Wiki\Vendors\Model\Category;

use Magento\Catalog\Api\Data\CategoryInterface;
use Magento\Catalog\Api\Data\EavAttributeInterface;
use Magento\Catalog\Model\Attribute\ScopeOverriddenValue;
use Magento\Catalog\Model\Category;
use Magento\Catalog\Model\Category\Attribute\Backend\Image as ImageBackendModel;
use Magento\Catalog\Model\CategoryFactory;
use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory as CategoryCollectionFactory;
use Magento\Catalog\Model\ResourceModel\Eav\Attribute as EavAttribute;
use Magento\Eav\Api\Data\AttributeInterface;
use Magento\Eav\Model\Config;
use Magento\Eav\Model\Entity\Attribute\Source\SpecificSourceInterface;
use Magento\Eav\Model\Entity\Type;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Filesystem;
use Magento\Framework\Stdlib\ArrayManager;
use Magento\Framework\Stdlib\ArrayUtils;
use Magento\Store\Model\Store;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Ui\Component\Form\Field;
use Magento\Ui\DataProvider\EavValidationRules;
use Magento\Ui\DataProvider\Modifier\PoolInterface;
use Magento\Framework\AuthorizationInterface;

/**
 * Category form data provider.
 *
 * @api
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @SuppressWarnings(PHPMD.TooManyFields)
 * @since 101.0.0
 */
class DataProvider extends \Magento\Catalog\Model\Category\DataProvider
{
    /**
     * @var string
     * @since 101.0.0
     */
    protected $requestScopeFieldName = 'store';

    /**
     * @var array
     * @since 101.0.0
     */
    protected $loadedData;

    /**
     * EAV attribute properties to fetch from meta storage
     *
     * @var array
     * @since 101.0.0
     */
    protected $metaProperties = [
        'dataType' => 'frontend_input',
        'visible' => 'is_visible',
        'required' => 'is_required',
        'label' => 'frontend_label',
        'sortOrder' => 'sort_order',
        'notice' => 'note',
        'default' => 'default_value',
        'size' => 'multiline_count',
    ];

    private $boolMetaProperties = ['visible', 'required'];

    /**
     * Form element mapping
     *
     * @var array
     * @since 101.0.0
     */
    protected $formElement = [
        'text' => 'input',
        'boolean' => 'checkbox',
    ];

    /**
     * Elements with use config setting
     *
     * @var array
     * @since 101.0.0
     */
    protected $elementsWithUseConfigSetting = [
        'available_sort_by',
        'default_sort_by',
        'filter_price_range',
    ];

    /**
     * List of fields that should not be added into the form
     *
     * @var array
     * @since 101.0.0
     */
    protected $ignoreFields = [
        'products_position',
        'position'
    ];

    /**
     * @var EavValidationRules
     * @since 101.0.0
     */
    protected $eavValidationRules;

    /**
     * @var \Magento\Framework\Registry
     * @since 101.0.0
     */
    protected $registry;

    /**
     * @var \Magento\Framework\App\RequestInterface
     * @since 101.0.0
     */
    protected $request;

    /**
     * @var Config
     */
    private $eavConfig;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var CategoryFactory
     */
    private $categoryFactory;

    /**
     * @var ScopeOverriddenValue
     */
    private $scopeOverriddenValue;

    /**
     * @var ArrayManager
     */
    private $arrayManager;

    /**
     * @var ArrayUtils
     */
    private $arrayUtils;

    /**
     * @var Filesystem
     */
    private $fileInfo;

    /**
     * @var AuthorizationInterface
     */
    private $auth;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param EavValidationRules $eavValidationRules
     * @param CategoryCollectionFactory $categoryCollectionFactory
     * @param StoreManagerInterface $storeManager
     * @param \Magento\Framework\Registry $registry
     * @param Config $eavConfig
     * @param \Magento\Framework\App\RequestInterface $request
     * @param CategoryFactory $categoryFactory
     * @param array $meta
     * @param array $data
     * @param PoolInterface|null $pool
     * @param AuthorizationInterface|null $auth
     * @param ArrayUtils|null $arrayUtils
     * @throws \Magento\Framework\Exception\LocalizedException
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        EavValidationRules $eavValidationRules,
        CategoryCollectionFactory $categoryCollectionFactory,
        StoreManagerInterface $storeManager,
        \Magento\Framework\Registry $registry,
        Config $eavConfig,
        \Magento\Framework\App\RequestInterface $request,
        CategoryFactory $categoryFactory,
        array $meta = [],
        array $data = [],
        PoolInterface $pool = null,
        ?AuthorizationInterface $auth = null,
        ?ArrayUtils $arrayUtils = null
    ){
        parent::__construct(
            $name,
            $primaryFieldName,
            $requestFieldName,
            $eavValidationRules,
            $categoryCollectionFactory,
            $storeManager,
            $registry,
            $eavConfig,
            $request,
            $categoryFactory,
            $meta,
            $data,
            $pool,
            $auth,
            $arrayUtils
        );
    }

    /**
     * Get current category
     *
     * @return Category
     * @throws NoSuchEntityException
     * @since 101.0.0
     */
    public function getCurrentCategory()
    {
        $requestId = $this->request->getParam($this->requestFieldName);
        $requestScope = $this->request->getParam($this->requestScopeFieldName, Store::DEFAULT_STORE_ID);
        if ($requestId) {
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $category = $objectManager->create('\Magento\Catalog\Model\CategoryRepository');
            $category = $category->get($requestId);
            if (!$category->getId()) {
                throw NoSuchEntityException::singleField('id', $requestId);
            }
            return $category;
        }else{
            $category = $this->registry->registry('category');
            if ($category) {
                return $category;
            }
        }
        
    }

}
