<?php

namespace Wiki\VendorsCoupon\Block\Vendors\Coupon;
use Magento\Catalog\Helper\Category as CategoryHelper;
use Magento\Catalog\Model\Indexer\Category\Flat\State as CategoryFlatConfig;
use Magento\Catalog\Block\Adminhtml\Category\Tree as CategoryRoot;
use Magento\Catalog\Model\CategoryRepository;
class Add extends \Wiki\Vendors\Block\Vendors\Widget\Form\Container
{
    /**
     * @var array
     */
    protected $categoryRepository;
    protected $jsLayout;

    /** @var  \Magento\Framework\Registry */
    protected $_coreRegistry;
    /**
     * Magento\Catalog\Helper\Category
     */
    protected $_categoryHelper;

    /**
     * Magento\Catalog\Model\Indexer\Category\Flat\State 
     */    
    protected $_categoryFlatConfig;

    /**
     * Magento\Catalog\Block\Adminhtml\Category\Tree
     */    
    protected $_categoryRoot;

    /**
     *
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Registry $registry,
        CategoryHelper $categoryHelper,
        CategoryFlatConfig $categoryFlatConfig,
        CategoryRoot $categoryRoot,
        CategoryRepository $categoryRepository,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_coreRegistry = $registry;
        $this->_categoryHelper = $categoryHelper;
        $this->_categoryFlatConfig = $categoryFlatConfig;
        $this->_categoryRoot = $categoryRoot;
        $this->categoryRepository = $categoryRepository;
        $this->jsLayout = isset($data['jsLayout']) && is_array($data['jsLayout']) ? $data['jsLayout'] : [];
    }

    /**
     * Get edit form container banner text
     *
     * @return \Magento\Framework\Phrase
     */
    public function getHeaderText()
    {
        return __("Edit Coupon '%1'", $this->escapeHtml($this->_coreRegistry->registry('coupon')->getCode()));
    }


    /**
     * Call parent constructor
     *
     * @return void
     */
    protected function _construct()
    {

        $this->_objectId = 'id';
        $this->_blockGroup = 'Wiki_VendorsCoupon'; //declare before controller
        $this->_controller = 'vendors_coupon';

        parent::_construct();

        $this->buttonList->update('save', 'label', __('Save Coupon'));
        $this->buttonList->update('delete', 'label' , __('Delete Coupon'));
    }
    public function getStoreCategories($sorted = false, $asCollection = false, $toLoad = true){
        return $this->_categoryHelper->getStoreCategories($sorted , $asCollection, $toLoad);
    }
    public function getChildCategories($category)
    {
        if ($this->_categoryFlatConfig->isFlatEnabled() && $category->getUseFlatResource()) {
            $subcategories = (array)$category->getChildrenNodes();
        } else {
            $subcategories = $category->getChildren();
        }
        return $subcategories;
    }
    /**
     * @return string
     */
    public function getDeleteUrl()
    {
        return $this->getUrl('*/*/delete', ['id' => $this->getRequest()->getParam('id')]);
    }
    public function getAddUrl()
    {
        return $this->getUrl('*/*/add');
    }
    public function getSaveUrl()
    {
        return $this->getUrl('*/*/save');
    }
    /**
     * check action allowed
     *
     * @param $resourceId
     * @return bool
     */
    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }

    /**
     * @return string
     */
    public function getJsLayout()
    {
        return \Zend_Json::encode($this->jsLayout);
    }
}
