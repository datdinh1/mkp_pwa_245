<?php
/**
 *
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wiki\VendorsProduct\Controller\Adminhtml\Catalog\Product;

use Magento\Framework\Controller\ResultFactory;
use Magento\Catalog\Controller\Adminhtml\Product\Builder;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Wiki\VendorsProduct\Model\Source\Approval;
use Wiki\VendorsProduct\Model\Product\Update as ProductUpdate;

class MassUnapprove extends \Magento\Catalog\Controller\Adminhtml\Product
{
    /**
     * Massactions filter
     *
     * @var Filter
     */
    protected $filter;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var \Wiki\VendorsProduct\Helper\Data
     */
    protected $productHelper;
    
    /**
     * @var \Wiki\Vendors\Model\VendorFactory
     */
    protected $vendorFactory;
    
    /**
     *
     * @param Context $context
     * @param Builder $productBuilder
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     * @param \Wiki\VendorsProduct\Helper\Data $productHelper
     * @param \Wiki\Vendors\Model\VendorFactory $vendorFactory
     */
    public function __construct(
        Context $context,
        Builder $productBuilder,
        Filter $filter,
        CollectionFactory $collectionFactory,
        \Wiki\VendorsProduct\Helper\Data $productHelper,
        \Wiki\Vendors\Model\VendorFactory $vendorFactory
    ) {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->productHelper = $productHelper;
        $this->vendorFactory = $vendorFactory;
        
        parent::__construct($context, $productBuilder);
    }

    /**
     * Approve Update Changes of an Exist product
     * @param \Magento\Catalog\Model\Product $product
     */
    protected function unapproveExistProduct(
        \Magento\Catalog\Model\Product $product,
        \Wiki\Vendors\Model\Vendor $vendor
    ) {
        $updateCollection = $this->_objectManager->create('Wiki\VendorsProduct\Model\ResourceModel\Product\Update\Collection');
        $updateCollection->addFieldToFilter('product_id', $product->getId())
            ->addFieldToFilter('status', ProductUpdate::STATUS_PENDING);
    
        foreach ($updateCollection as $update) {
            $update->setStatus(ProductUpdate::STATUS_UNAPPROVED)->setId($update->getUpdateId())->save();
        }
        /*Send update product notification email*/
        $this->productHelper->sendUpdateProductUnapprovedEmailToVendor($product, $vendor, $updateCollection);
    }
    
    /**
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $productApproved = 0;
        $vendors = [];
        
        foreach ($collection->getItems() as $product) {
            $product->load($product->getId());
            $vendorId = $product->getVendorId();
            
            if (!$vendorId) {
                continue;
            }
            
            if (!isset($vendors[$vendorId])) {
                $vendor = $this->vendorFactory->create();
                $vendor->load($vendorId);
                $vendors[$vendorId] = $vendor;
            }
            
            $vendor = $vendors[$vendorId];
            
            $approval = Approval::STATUS_UNAPPROVED;
            /**
             * Approve Pending updates.
             */
            if ($product->getApproval() == Approval::STATUS_PENDING_UPDATE) {
                $this->unapproveExistProduct($product, $vendor);
                $message = __('Updates of %1 are rejected', '<strong>'.$product->getName().'</strong>');
                $approval = Approval::STATUS_APPROVED;
            } else {
                $this->productHelper->sendProductUnapprovedEmailToVendor($product, $vendor);
                $message = __('Product %1 is rejected', '<strong>'.$product->getName().'</strong>');
            }
            $product->setApproval($approval)->getResource()->saveAttribute($product, 'approval');
            if($product->getTypeId() == \Magento\ConfigurableProduct\Model\Product\Type\Configurable::TYPE_CODE){
                $childProductCollection = $product->getTypeInstance()->getUsedProductCollection($product);
                foreach($childProductCollection as $childProduct){
                    $childProduct->setApproval($approval)
                        ->getResource()
                        ->saveAttribute($childProduct, 'approval');
                }
            }
            
            $this->_eventManager->dispatch(
                'Wiki_vendors_push_notification',
                [
                    'vendor_id' => $vendor->getId(),
                    'type' => 'product_approval',
                    'message' => $message,
                    'additional_info' => ['id' => $product->getId()],
                ]
            );
            
            $productApproved++;
        }
        
        $this->messageManager->addSuccess(
            __('A total of %1 product(s) have been unapproved.', $productApproved)
        );

        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath('vendors/catalog_product/index');
    }
}
