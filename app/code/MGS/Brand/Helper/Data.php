<?php

namespace MGS\Brand\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    protected $_storeManager;
    protected $_config = [];
    protected $_filterProvider;

    protected $_productRepository;
    protected $_categoryCollectionFactory;

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Cms\Model\Template\FilterProvider $filterProvider,
        \Magento\Catalog\Model\ProductRepository $productRepository,
        \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoryCollectionFactory
    )
    {
        parent::__construct($context);
        $this->_filterProvider = $filterProvider;
        $this->_storeManager = $storeManager;
        $this->_productRepository = $productRepository;
        $this->_categoryCollectionFactory = $categoryCollectionFactory;
    }

    public function getConfig($key, $store = null)
    {
        if ($store == null || $store == '') {
            $store = $this->_storeManager->getStore()->getId();
        }
        $store = $this->_storeManager->getStore($store);
        $config = $this->scopeConfig->getValue(
            'brand/' . $key,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $store);
        return $config;
    }

    public function getBaseMediaUrl()
    {
        return $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
    }

    public function getBrandUrl()
    {
        return $this->_storeManager->getStore()->getBaseUrl() . $this->getConfig('general_settings/route');
    }

    public function filter($str)
    {
        $html = $this->_filterProvider->getPageFilter()->filter($str);
        return $html;
    }
	
	public function convertPerRowtoCol($perRow){
		switch ($perRow) {
            case 1:
                $result = 12;
                break;
            case 2:
                $result = 6;
                break;
            case 3:
                $result = 4;
                break;
            case 4:
                $result = 3;
                break;
            case 5:
                $result = 'custom-5';
                break;
            case 6:
                $result = 2;
                break;
        }
		
		return $result;
	}
	
	public function convertColClass($col, $type){
		if(($type=='row') && ($col=='custom-5')){
			return 'row-'.$col;
		}
		if($type=='col'){
			$class = "";	
			if(($col=='custom-5')){
				$class .= 'col-md-'.$col;
			}else{
				$class .= 'col-lg-'.$col.' col-md-'.$col;
			}
			return $class;
		}
	}
	
	public function convertClearClass($perRow, $position){
		$class = "";
		if($position % $perRow == 1){
			$class .= " first-row-item";
		}
		if($position % 3 == 1){
			$class .= " first-sm-item";
		}
		if($position % 2 == 1){
			$class .= " first-xs-item";
		}
		return $class;
	}

    public function getCategoryIdByProducts($data)
    {
        $result = [];
        foreach ($data as $item) {
            try {
                $product = $this->_productRepository->getById((int)$item['product_id']);
                $categoryIds = $product->getCategoryIds();

                $collection = $this->getCategoryCollection(false)
                            ->addAttributeToFilter('entity_id', $categoryIds);
                if ($collection->getSize()) {
                    foreach ($collection as $category) {
                        if (!in_array($category->getId(), $result)) {
                            $result[] = $category->getId();
                        }
                    }
                }
            }
            catch (\Exception $e) { }
        }
        return $result;
    }

    public function getCategoryCollection($isActive = true, $level = false, $sortBy = false, $pageSize = false)
    {
        $collection = $this->_categoryCollectionFactory->create()->addAttributeToSelect('*');       
        // select only active categories
        if ($isActive) {
            $collection->addIsActiveFilter();
        }     
        // select categories of certain level
        if ($level) {
            $collection->addLevelFilter($level);
        }
        // sort categories by some value
        if ($sortBy) {
            $collection->addOrderField($sortBy);
        }
        // select certain number of categories
        if ($pageSize) {
            $collection->setPageSize($pageSize); 
        }    
        return $collection;
    }
}