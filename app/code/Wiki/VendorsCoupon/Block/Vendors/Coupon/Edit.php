<?php

namespace Wiki\VendorsCoupon\Block\Vendors\Coupon;

use Wiki\VendorsSalesRule\Helper\Data as SaleRuleHelper;
use Magento\Catalog\Helper\Category as CategoryHelper;
use Magento\Catalog\Model\Indexer\Category\Flat\State as CategoryFlatConfig;
use Magento\SalesRule\Model\Rule;

class Edit extends \Wiki\Vendors\Block\Vendors\Widget\Form\Container
{
    /**
     * @var array
     */
    protected $jsLayout;

    /** @var  \Magento\Framework\Registry */
    protected $_coreRegistry;

    /** @var  \Magento\Catalog\Helper\Category */
    protected $_categoryHelper;

    /** @var  \Magento\Catalog\Model\Indexer\Category\Flat\State  */
    protected $_categoryFlatConfig;
    
     /** @var  \Magento\SalesRule\Model\Rule  */
    protected $_saleRule;
    
    /**
     * @var array|LayoutProcessorInterface[]
     */
    protected $layoutProcessors;

    /** @var  \Wiki\VendorsSalesRule\Helper\Data */
    protected $_saleRuleHelper;

    /**
     *
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param array $data
     */
    public function __construct(
        CategoryHelper $categoryHelper,
        CategoryFlatConfig $categoryFlatConfig,
        Rule $saleRule,
        SaleRuleHelper $saleRuleHelper,
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Registry $registry,
        array $data = [],
        array $layoutProcessors = []
    ) {
        parent::__construct($context, $data);
        $this->_categoryHelper = $categoryHelper;
        $this->_categoryFlatConfig = $categoryFlatConfig;
        $this->_saleRule = $saleRule;
        $this->_saleRuleHelper = $saleRuleHelper;
        $this->_coreRegistry = $registry;
        $this->layoutProcessors = $layoutProcessors;
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

    /**
     * @return string
     */
    public function getDeleteUrl()
    {
        return $this->getUrl('*/*/delete', ['id' => $this->getRequest()->getParam('id')]);
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
    public function getListCouponById($id){
        $data = $this->_saleRule->load($id);
        return $data;
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
    public function getImageUrl(){
        $mediaPath = $this->filesystem->getDirectoryRead($this->directoryList::MEDIA)->getAbsolutePath();
        $mediaPath .= 'sampleimageuploader/images/image/';
    }
    /**
     * @return string
     */
    public function getJsLayout()
    {
        $image = '';
        $coupon = $this->getListCouponById($this->getRequest()->getParam('id'));
        ($coupon->getImage()) ? $image = $this->getUrl().$this->_saleRuleHelper->getUrlImage().$coupon->getImage() : '';
        $checkMaxDiscount = ($coupon->getMaxDiscountAmount() ? 'limit_value' : 'unlimited');
        $this->jsLayout['components']['editCoupon']['type_store'] = $coupon->getType();
        $this->jsLayout['components']['editCoupon']['simple_action'] = $coupon->getSimpleAction();
        $this->jsLayout['components']['editCoupon']['couponImgUrl'] = $image;
        $this->jsLayout['components']['editCoupon']['discountLimited'] = $checkMaxDiscount;
        foreach ($this->layoutProcessors as $processor) {
            $this->jsLayout = $processor->process($this->jsLayout);
        }
        return \Zend_Json::encode($this->jsLayout);
    }
}
