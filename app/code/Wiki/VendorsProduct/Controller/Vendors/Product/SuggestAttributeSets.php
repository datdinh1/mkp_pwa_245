<?php

namespace Wiki\VendorsProduct\Controller\Vendors\Product;

use Magento\Framework\Registry;
use Magento\Framework\Stdlib\DateTime\Filter\Date;

class SuggestAttributeSets extends \Wiki\Vendors\Controller\Vendors\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    protected $_aclResource = 'Wiki_Vendors::catalog_product';
    
    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $resultJsonFactory;

    /**
     * @var \Magento\Catalog\Model\Product\AttributeSet\SuggestedSet
     */
    protected $suggestedSet;

    /**
     * @var  \Wiki\VendorsProduct\Helper\Data
     */
    protected $productHelper;
    
    /**
     * Constructor
     *
     * @param \Wiki\Vendors\App\Action\Context $context
     * @param \Wiki\Vendors\App\ConfigInterface $config
     * @param Registry $coreRegistry
     * @param Date $dateFilter
     * @param \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
     * @param \Magento\Catalog\Model\Product\AttributeSet\SuggestedSet $suggestedSet
     */

    public function __construct(
        \Wiki\Vendors\App\Action\Context $context,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Magento\Catalog\Model\Product\AttributeSet\SuggestedSet $suggestedSet,
        \Wiki\VendorsProduct\Helper\Data $productHelper
    ) {
        parent::__construct($context);
        $this->resultJsonFactory    = $resultJsonFactory;
        $this->suggestedSet         = $suggestedSet;
        $this->productHelper        = $productHelper;
    }
    

    /**
     * Action for attribute set selector
     *
     * @return \Magento\Framework\Controller\Result\Json
     */
    public function execute()
    {
        $resultJson = $this->resultJsonFactory->create();
        $result = $this->suggestedSet->getSuggestedSets($this->getRequest()->getParam('label_part'));
        foreach ($result as $index => $setInfo) {
            if (isset($setInfo['id']) && in_array($setInfo['id'], $this->productHelper->getAttributeSetRestriction())) {
                unset($result[$index]);
            }
        }
        $resultJson->setData(
            array_values($result)
        );
        return $resultJson;
    }
}
