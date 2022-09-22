<?php
/**
 * @author      Wiki Team <core@Wiki.com>
 */
namespace Wiki\VendorsProduct\Block\Vendors;

use Magento\Eav\Model\ResourceModel\Entity\Attribute\Set\CollectionFactory as AttributeSetCollectionFactory;

class Product extends \Wiki\Vendors\Block\Vendors\Widget\Container
{
    
    /**
     * @var \Magento\Catalog\Model\Product\TypeFactory
     */
    protected $_typeFactory;
    
    /**
     * @var \Magento\Catalog\Model\ProductFactory
     */
    protected $_productFactory;
    
    /**
     * @var \Wiki\VendorsProduct\Helper\Data
     */
    protected $_productHelper;

    /**
     * @var AttributeSetCollectionFactory
     */
    protected $attributeSetCollectionFactory;
    
    /**
     * @var int
     */
    protected $defaultAttributeSet;
    
    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_blockGroup = 'Wiki_VendorsProduct';
        $this->_controller = 'vendors_product';
        $this->_headerText = __('Manage Products');
        $this->_addButtonLabel = __('Add Product');
        
        parent::_construct();
    }
    
    
    /**
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param \Magento\Catalog\Model\Product\TypeFactory $typeFactory
     * @param \Magento\Catalog\Model\ProductFactory $productFactory
     * @param \Wiki\VendorsProduct\Helper\Data $productHelper
     * @param AttributeSetCollectionFactory $attributeSetCollectionFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Catalog\Model\Product\TypeFactory $typeFactory,
        \Magento\Catalog\Model\ProductFactory $productFactory,
        \Wiki\VendorsProduct\Helper\Data $productHelper,
        AttributeSetCollectionFactory $attributeSetCollectionFactory,
        array $data = []
    ) {
        $this->_productFactory  = $productFactory;
        $this->_typeFactory     = $typeFactory;
        $this->_productHelper   = $productHelper;
        $this->attributeSetCollectionFactory = $attributeSetCollectionFactory;
        parent::__construct($context, $data);
        $this->removeButton('add');
    }
    
    /**
     * Prepare button and grid
     *
     * @return \Magento\Catalog\Block\Adminhtml\Product
     */
    protected function _prepareLayout()
    {
        if($this->_isAllowedAction('Wiki_Vendors::product_action_save')){
            $addButtonProps = [
                'id' => 'add_new_product',
                'label' => __('Add Product'),
                'class' => 'btn-primary btn-sm',
                'button_class' => 'fa fa-plus-circle',
                'class_name' => 'Wiki\Vendors\Block\Vendors\Widget\Button\SplitButton',
                'options' => $this->_getAddProductButtonOptions(),
            ];
            $this->buttonList->add('add_new', $addButtonProps, 0, 0, 'toolbar');
        }
        return parent::_prepareLayout();
    }
    
    /**
     * Retrieve options for 'Add Product' split button
     *
     * @return array
     */
    protected function _getAddProductButtonOptions()
    {
        $splitButtonOptions = [];
        $types = $this->_typeFactory->create()->getTypes();
        uasort(
            $types,
            function ($elementOne, $elementTwo) {
                return ($elementOne['sort_order'] < $elementTwo['sort_order']) ? -1 : 1;
            }
        );

        foreach ($types as $typeId => $type) {
            if (in_array($typeId, $this->_productHelper->getProductTypeRestriction())) {
                continue;
            }
            
            $splitButtonOptions[$typeId] = [
                'label' => __($type['label']),
                'onclick' => "setLocation('" . $this->_getProductCreateUrl($typeId) . "')",
                'default' => \Magento\Catalog\Model\Product\Type::DEFAULT_TYPE == $typeId,
            ];
        }
    
        return $splitButtonOptions;
    }
    
    /**
     * Get default attribute set id
     * 
     * @return number
     */
    public function getDefaultAttributeSetId(){
        if(!$this->defaultAttributeSet){
            $attrSetsRestriction = $this->_productHelper->getAttributeSetRestriction();
            $product = $this->_productFactory->create();
            $defaultAttributeSetId = $product->getDefaultAttributeSetId();
            if(in_array($defaultAttributeSetId, $attrSetsRestriction)){
                $entityTypeId = $product->getResource()->getTypeId();
                $attrSetCollection = $this->attributeSetCollectionFactory->create()
                    ->setEntityTypeFilter($entityTypeId)
                    ->addFieldToFilter('attribute_set_id',['nin' => $attrSetsRestriction]);
                if($attrSetCollection->count()){
                    $defaultAttributeSetId = $attrSetCollection->getFirstItem()->getId();
                }
            }
            
            $this->defaultAttributeSet = $defaultAttributeSetId;
        }
        
        return $this->defaultAttributeSet;
    }
    
    /**
     * Retrieve product create url by specified product type
     *
     * @param string $type
     * @return string
     */
    protected function _getProductCreateUrl($type)
    {
        return $this->getUrl(
            'catalog/product/new',
            ['set' => $this->getDefaultAttributeSetId(), 'type' => $type]
        );
    }
    
    /**
     * Check whether it is single store mode
     *
     * @return bool
     */
    public function isSingleStoreMode()
    {
        return $this->_storeManager->isSingleStoreMode();
    }
    
    /**
     * Check permission for passed action
     *
     * @param string $resourceId
     * @return bool
     */
    protected function _isAllowedAction($resourceId)
    {
        $permission = new \Wiki\Vendors\Model\AclResult();
        $this->_eventManager->dispatch(
            'ves_vendor_check_acl',
            [
                'resource' => $resourceId,
                'permission' => $permission
            ]
        );
        return $permission->isAllowed();
    }
}
